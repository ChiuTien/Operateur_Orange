<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function accueil(): string
    {
        return view('accueil');
    }
}
