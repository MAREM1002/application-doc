<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PgwebController extends Controller
{
    public function index()
    {
        return view('pgweb'); // Affiche la vue pgweb.blade.php
    }
}

