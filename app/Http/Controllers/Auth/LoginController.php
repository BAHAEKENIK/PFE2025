<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Assurez-vous que le modèle User est importé
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gère une tentative de connexion.
     */
    public function login(Request $request)
    {
        // 1. Validation
        $credentials = $request->validate([
            'email' => ['required', 'email','unique:users'],
            'password' => ['required','string','min:6']
        ]);

        // 2. Tentative de connexion
        if (Auth::attempt($credentials, $request->filled('remember'))) { // 'remember' est optionnel
            $request->session()->regenerate(); // Sécurité: régénère l'ID de session

            $user = Auth::user();
            $welcomeMessage = 'Bienvenue, ' . $user->name . '!';

            // 3. Redirection basée sur le rôle
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('status', $welcomeMessage);
                case 'client':
                    return redirect()->route('client.dashboard')->with('status', $welcomeMessage);
                case 'provider':
                    return redirect()->route('provider.dashboard')->with('status', $welcomeMessage);
                default:
                    // Fallback au cas où le rôle n'est pas défini ou inattendu
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->with('error', 'Rôle utilisateur non valide.');
            }
        }

        // 4. Échec de la connexion
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')], // Message d'erreur générique
        ]);

        // Alternative pour l'échec (si vous n'utilisez pas ValidationException)
      //  return back()->withErrors(['email'=> 'Invalid email or password.'])->onlyInput('email');
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Invalide la session
        $request->session()->regenerateToken(); // Régénère le token CSRF

        return redirect('/login'); // Redirige vers la page de login
    }

    /**
     * Redirige vers le dashboard approprié (utilisé par la route /dashboard).
     * Utile si vous avez besoin d'une route centrale après une action.
     */
    public function redirectToDashboard()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'client':
                return redirect()->route('client.dashboard');
            case 'provider':
                return redirect()->route('provider.dashboard');
            default:
                 return redirect('/login'); // Sécurité
        }
    }
}
