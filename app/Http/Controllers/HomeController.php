<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use function Termwind\render;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Homepage', ['hoihoi'=>"Bezoeker"]);
    }
}
