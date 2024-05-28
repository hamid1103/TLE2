<?php

namespace App\Http\Controllers;
use App\Models\ChatEntry;
use App\Models\ChatHistory;
use Inertia\Inertia;
use function Termwind\render;

class SubjectController extends Controller
{
    public function subject()
    {
        return Inertia::render('Subject');
    }
}
