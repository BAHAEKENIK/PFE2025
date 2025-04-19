<?php

namespace App\Http\Controllers\Client; // Adapter le namespace pour Client/Provider

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Utile pour obtenir l'utilisateur connecté

class DashboardController extends Controller // Adapter le nom de classe
{
    /**
     * Affiche le tableau de bord spécifique au rôle.
     * Le middleware 'auth' dans les routes assure que seul un user connecté y accède.
     * On pourrait ajouter un middleware de rôle ici ou dans les routes si nécessaire.
     */
    public function index()
    {
        // Optionnel: Vérification supplémentaire de rôle si non géré par middleware
        // if (Auth::user()->role !== 'admin') {
        //     abort(403, 'Accès non autorisé.');
        // }

        // $user = Auth::user(); // Récupérer l'utilisateur connecté si besoin de ses données
        return view('client.dashboard'); // Adapter le nom de la vue pour Client/Provider
    }
}
