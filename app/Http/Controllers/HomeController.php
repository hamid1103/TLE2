<?php

namespace App\Http\Controllers;
use App\Models\ChatEntry;
use App\Models\ChatHistory;
use Inertia\Inertia;
use function Termwind\render;

class HomeController extends Controller
{
    public function index()
    {
        $chats = ChatHistory::with('ChatEntries')->get();
        return Inertia::render('Homepage', ['chatList'=>$chats]);
    }
}
