<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Auth\Events\Registered; // Décommentez si vous l'utilisez
use Illuminate\Validation\Rule; // Assurez-vous que cette ligne est présente

class RegisterController extends Controller
{
    // Liste des villes marocaines (vous pouvez l'étendre ou la déplacer dans un fichier config)
    protected $moroccanCities = [
        'Agadir', 'Al Hoceima', 'Asilah', 'Azemmour', 'Azrou',
        'Beni Mellal', 'Berkane', 'Berrechid', 'Boujdour', 'Bouznika',
        'Casablanca', 'Chefchaouen', 'Dakhla', 'El Jadida', 'Errachidia',
        'Essaouira', 'Fes', 'Figuig', 'Fnideq', 'Guelmim',
        'Ifrane', 'Imzouren', 'Kenitra', 'Khemisset', 'Khenifra',
        'Khouribga', 'Ksar El Kebir', 'Laayoune', 'Larache', 'Marrakech',
        'Martil', 'Meknes', 'Midelt', 'Mohammedia', 'Nador',
        'Ouarzazate', 'Ouezzane', 'Oujda', 'Rabat', 'Safi',
        'Sale', 'Sefrou', 'Settat', 'Sidi Bennour', 'Sidi Ifni',
        'Sidi Kacem', 'Sidi Slimane', 'Skhrirate', 'Smara', 'Souk El Arbaa',
        'Tan-Tan', 'Tangier', 'Taourirt', 'Taroudant', 'Taza',
        'Temara', 'Tetouan', 'Tiflet', 'Tinghir', 'Tiznit', 'Youssoufia', 'Zagora'
        // Ajoutez plus de villes si nécessaire
    ];

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Affiche le formulaire d'enregistrement en passant la liste des villes.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Passe la liste des villes à la vue
        return view('auth.register', ['cities' => $this->moroccanCities]);
    }

    /**
     * Gère une requête d'enregistrement pour l'application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user = $this->create($request->all(), $profilePhotoPath);

        // event(new Registered($user)); // Décommentez si vous l'utilisez

        Auth::login($user);

        $welcomeMessage = 'Bienvenue, ' . $user->name . '! Votre compte a été créé.';

        switch ($user->role) {
            case 'client':
                return redirect()->route('client.dashboard')->with('status', $welcomeMessage);
            case 'provider':
                return redirect()->route('provider.dashboard')->with('status', $welcomeMessage);
            default:
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
        // Récupère la liste des villes pour la validation
        $cityList = $this->moroccanCities;

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['client', 'provider'])],
            'phone' => ['nullable', 'string', 'max:20'],
            // Validation pour la ville: optionnelle, mais si fournie, doit être dans la liste
            'city' => ['nullable', 'string', Rule::in($cityList)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
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
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            // S'assurer que 'city' existe même si elle est vide/null
            'city' => $data['city'] ?? null,
            'profile_photo' => $profilePhotoPath,
            'bio' => $data['bio'] ?? null,
        ]);
    }
}
