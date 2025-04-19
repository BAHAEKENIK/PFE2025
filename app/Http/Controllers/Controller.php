<?php

namespace App\Http\Controllers;

// Assurez-vous que cette ligne est présente et correcte
use Illuminate\Routing\Controller as BaseController;

// Optionnel mais commun: ajoute les helpers AuthorizesRequests et ValidatesRequests
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

// Assurez-vous que votre classe Controller étend BaseController
class Controller extends BaseController
{
    // Ces traits fournissent des fonctionnalités utiles, mais BaseController est clé pour middleware()
    use AuthorizesRequests, ValidatesRequests;
}
