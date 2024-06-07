<?php

namespace App\Http\Controllers;

use App\Models\BoardAssignmentLink;
use App\Models\Bord;
use App\Models\BordChatentry;
use App\Models\BordUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DigibordController extends Controller
{
    public function digibordList()
    {
        $boards = BordUser::where(['user_id' => Auth::id()])->with('bords')->get();
        return Inertia::render('DigibordList', ['boards'=>$boards]);
    }
    public function digibord($id)
    {
        $Questions = BordChatentry::where(['bord_id' => $id])->get();
        return Inertia::render('Digibord', ['board'=>Bord::find($id), 'questions'=>$Questions]);
    }

    public function fetchQuestionsByBoardID($id)
    {
        return BordChatentry::where(['bord_id' => $id])->get();
    }

    public function createBoard(Request $request): RedirectResponse
    {
        $newB = Bord::create(['Title' => $request->title]);
        BordUser::create(['bord_id' => $newB->id, 'user_id' => Auth::id()]);
        return redirect('/digibord/'.$newB->id);
    }

    //Removes the BordChatEntry Entry, so it won't show up on the board anymore
    public function AnswerQuestion(Request $request)
    {

    }

    //ID refers to the boardAssignmentLink Model Entry ID
    //Assign user to board
    public function AssignBoard(Request $request, $id): RedirectResponse
    {
        if(!Auth())
        {
            return redirect('/login');
        }
        $BAL = BoardAssignmentLink::find($id);
        BordUser::create(['bord_id' => $BAL->board_id, 'user_id' => Auth::id()]);
        return redirect(`/digibord/${$BAL->board_id}`);
    }

}
