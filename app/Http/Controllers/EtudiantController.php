<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantController extends Controller
{

    /**
     * Afficher le dashboard etudiant
     */
    public function index()
    {

       return view("etudiant.dashboard");
    }
}
