<?php

namespace App\Http\Controllers;
use App\Models\ChatEntry;
use App\Models\ChatHistory;
use Inertia\Inertia;
use function Termwind\render;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render('Login');
    }
}
