<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'roleMid:enseignant']);
    // }

    /**
     * Afficher le dashboard enseignant
     */
    public function index()
    {

        return view("enseignant.dashboard");
    }
}
