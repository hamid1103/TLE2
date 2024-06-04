<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DigibordController extends Controller
{
    public function digibord()
    {
        return Inertia::render('Digibord');
    }
}
