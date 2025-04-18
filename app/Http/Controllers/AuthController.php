<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showForgetPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Générez un code aléatoire pour vérifier
            $verificationCode = rand(100000, 999999);
            session(['verification_code' => $verificationCode, 'user_id' => $user->id]);

            // Envoyer un e-mail avec le code de vérification
            Mail::raw("Votre code de réinitialisation est : $verificationCode", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Réinitialisation de mot de passe');
            });

            return view('auth.passwords.verify');
        }

        return back()->withErrors(['email' => 'Email not found']);
    }

    public function showResetPasswordForm()
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'verification_code' => 'required|numeric',
        ]);

        if (session('verification_code') == $request->verification_code) {
            $user = User::find(session('user_id'));
            $user->password = Hash::make($request->password);
            $user->save();

            session()->forget('verification_code');
            session()->forget('user_id');

            return redirect()->route('login')->with('status', 'Password reset successfully');
        }

        return back()->withErrors(['verification_code' => 'Invalid verification code']);
    }
}
