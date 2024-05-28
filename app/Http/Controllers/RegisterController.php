<?php

namespace App\Http\Controllers;
use App\Models\ChatEntry;
use App\Models\ChatHistory;
use Inertia\Inertia;
use function Termwind\render;

class RegisterController extends Controller
{
    public function register()
    {
        return Inertia::render('Register');
    }
}
