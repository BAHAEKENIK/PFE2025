<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered; // Pour l'événement d'enregistrement si besoin
use Illuminate\Validation\Rule; // Pour la validation du rôle

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     * On le gère dynamiquement dans la méthode register()
     *
     * @var string
     */
    // protected $redirectTo = '/dashboard'; // Vous pouvez le laisser ou le commenter

    /**
     * Create a new controller instance.
     * Applique le middleware 'guest' pour que les utilisateurs connectés ne voient pas cette page.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest'); // <-- L'appel qui causait problème
    }

    /**
     * Affiche le formulaire d'enregistrement.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Gère une requête d'enregistrement pour l'application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // 1. Validation des données
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput(); // Garde les anciennes entrées
        }

        // 2. Gestion de l'upload de la photo de profil (si fournie)
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            // Stocke l'image dans storage/app/public/profile_photos
            // Assurez-vous d'avoir lancé `php artisan storage:link`
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // 3. Création de l'utilisateur
        $user = $this->create($request->all(), $profilePhotoPath);

        // Optionnel: Déclencher un événement si nécessaire (ex: email de vérification)
        // event(new Registered($user));

        // 4. Connexion automatique de l'utilisateur après enregistrement
        Auth::login($user);

        // 5. Redirection vers le tableau de bord approprié
        $welcomeMessage = 'Bienvenue, ' . $user->name . '! Votre compte a été créé.';

        switch ($user->role) {
            case 'client':
                return redirect()->route('client.dashboard')->with('status', $welcomeMessage);
            case 'provider':
                return redirect()->route('provider.dashboard')->with('status', $welcomeMessage);
            default:
                // Fallback (ne devrait pas arriver avec la validation, mais par sécurité)
                 return redirect()->route('login')->with('status', 'Compte créé. Veuillez vous connecter.');
        }
    }

    /**
     * Obtient un validateur pour une requête d'enregistrement entrante.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // 'unique:users' vérifie l'unicité dans la table users
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' cherche un champ 'password_confirmation'
            'role' => ['required', 'string', Rule::in(['client', 'provider'])], // Assure que seul 'client' ou 'provider' est choisi
            'phone' => ['nullable', 'string', 'max:20'], // Exemple de validation simple
            'city' => ['nullable', 'string', 'max:100'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Image, types autorisés, taille max 2Mo
            'bio' => ['nullable', 'string'],
        ]);
    }

    /**
     * Crée une nouvelle instance d'utilisateur après une validation réussie.
     *
     * @param  array  $data
     * @param  string|null $profilePhotoPath
     * @return \App\Models\User
     */
    protected function create(array $data, ?string $profilePhotoPath = null)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hashage du mot de passe
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'profile_photo' => $profilePhotoPath, // Chemin stocké ou null
            'bio' => $data['bio'] ?? null,
        ]);
    }
}
