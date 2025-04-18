<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            return view('admin.dashboard');
        } elseif ($role == 'client') {
            return view('client.dashboard');
        } elseif ($role == 'provider') {
            return view('provider.dashboard');
        }

        return redirect()->route('login');
    }
}
