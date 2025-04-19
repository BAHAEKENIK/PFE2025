<?php

namespace App\Http\Controllers\Auth;

use Log;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\ResetCodeMail; // Importez votre Mailable
use Illuminate\Support\Facades\Password; // Peut être utile mais pas pour ce flux custom

class PasswordResetController extends Controller
{
    // Durée de validité du code en minutes
    protected $codeValidityDuration = 15;

    /**
     * Étape 1: Afficher le formulaire pour demander le lien/code de réinitialisation.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Étape 2: Envoyer l'email avec le code de réinitialisation.
     */
    public function sendResetCodeEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Générer un code aléatoire (ex: 6 chiffres)
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Stocker le code et l'email dans la session avec un timestamp d'expiration
        $request->session()->put('password_reset', [
            'email' => $user->email,
            'code' => $code, // Stocker le code en clair ici pour la comparaison simple
            'expires_at' => Carbon::now()->addMinutes($this->codeValidityDuration),
        ]);

        // Envoyer l'email
        try {
             Mail::to($user->email)->send(new ResetCodeMail($code));
        } catch (\Exception $e) {
             // Log l'erreur
             Log::error("Erreur envoi email reset code: " . $e->getMessage());
             // Rediriger avec une erreur générique
             return back()->with('error', 'Impossible d\'envoyer l\'email de réinitialisation pour le moment. Veuillez réessayer plus tard.');
        }

        // Rediriger vers le formulaire de saisie du code
        return redirect()->route('password.code.form')
                         ->with('status', 'Un code de réinitialisation a été envoyé à votre adresse email.');
    }

    /**
     * Étape 3: Afficher le formulaire pour saisir le code.
     */
    public function showCodeForm(Request $request)
    {
        // Vérifier si les données de session existent (pour éviter l'accès direct)
        if (!$request->session()->has('password_reset')) {
            return redirect()->route('password.request')->with('error', 'Veuillez d\'abord demander un code de réinitialisation.');
        }

        // Récupérer l'email de la session pour l'afficher si besoin (optionnel)
        // $email = $request->session()->get('password_reset.email');
        return view('auth.passwords.code'); // Passez $email à la vue si nécessaire
    }

    /**
     * Étape 4: Vérifier le code saisi par l'utilisateur.
     */
    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required|numeric|digits:6']);

        // Vérifier si les données de session existent et sont valides
        if (!$request->session()->has('password_reset')) {
            return redirect()->route('password.request')->with('error', 'Session expirée ou invalide. Veuillez recommencer.');
        }

        $resetData = $request->session()->get('password_reset');

        // Vérifier l'expiration
        if (Carbon::now()->gt($resetData['expires_at'])) {
            $request->session()->forget('password_reset'); // Nettoyer la session
            return redirect()->route('password.request')->with('error', 'Le code de réinitialisation a expiré. Veuillez en demander un nouveau.');
        }

        // Vérifier le code
        if ($request->code !== $resetData['code']) {
            return back()->with('error', 'Le code saisi est incorrect.');
        }

        // Code correct ! Marquer la vérification comme réussie dans la session
        $request->session()->put('password_reset.verified', true);

        // Rediriger vers le formulaire de nouveau mot de passe
        return redirect()->route('password.reset.form');
    }

    /**
     * Étape 5: Afficher le formulaire pour saisir le nouveau mot de passe.
     */
    public function showResetForm(Request $request)
    {
         // Vérifier si les étapes précédentes ont été complétées
         if (
             !$request->session()->has('password_reset') ||
             !$request->session()->get('password_reset.verified', false)
            ) {
            return redirect()->route('password.request')->with('error', 'Veuillez d\'abord vérifier votre code.');
        }

        // // Récupérer l'email pour l'afficher ou l'utiliser (optionnel)
        // $email = $request->session()->get('password_reset.email');
        return view('auth.passwords.reset'); // Passez $email à la vue si nécessaire
    }

    /**
     * Étape 6: Mettre à jour le mot de passe de l'utilisateur.
     */
    public function reset(Request $request)
    {
        // Vérifier si les étapes précédentes ont été complétées
        if (
            !$request->session()->has('password_reset') ||
            !$request->session()->get('password_reset.verified', false)
           ) {
           return redirect()->route('password.request')->with('error', 'Session invalide ou expirée. Veuillez recommencer.');
       }

        // Validation du nouveau mot de passe
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'], // 'confirmed' vérifie password_confirmation
        ]);

        $resetData = $request->session()->get('password_reset');
        $user = User::where('email', $resetData['email'])->first();

        if (!$user) {
             // Sécurité: si l'utilisateur a été supprimé entre temps
            $request->session()->forget('password_reset');
            return redirect()->route('login')->with('error', 'Utilisateur non trouvé.');
        }

        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        // Nettoyer la session de réinitialisation
        $request->session()->forget('password_reset');

        // Rediriger vers le login avec un message de succès
        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }
}
