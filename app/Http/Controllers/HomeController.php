<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Controleer of de gebruiker is ingelogd
        if (!Auth::check()) {
            // Zo niet, leid de gebruiker naar de login-pagina
            return redirect('/login');
        }

        // Haal de chatgeschiedenis op als de gebruiker is ingelogd
        $chats = ChatHistory::with('ChatEntries')->get();

        // Render de homepage met de chatlijst
        return Inertia::render('Homepage', ['chatList' => $chats]);
    }
}
