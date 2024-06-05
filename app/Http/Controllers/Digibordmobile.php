<?php

namespace App\Http\Controllers;
use App\Models\ChatEntry;
use App\Models\ChatHistory;
use Inertia\Inertia;
use function Termwind\render;

class Digibordmobile extends Controller
{
    public function Digibordmobile()
    {
        return Inertia::render('Digibordmobile');
    }
}
