<?php

namespace App\Http\Controllers;

use App\Models\BoardAssignmentLink;
use App\Models\Bord;
use App\Models\BordChatentry;
use App\Models\BordUser;
use App\Models\ChatEntry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DigibordController extends Controller
{
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function digibordList()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $boards = User::find(Auth::id())->boards()->get();
        return Inertia::render('DigibordList', ['boards' => $boards]);
    }

    public function digibord($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $Questions = Bord::find($id)->ChatEntries()->get();
        $boardRequest = BoardAssignmentLink::where(['board_id' => $id])->first();
        return Inertia::render('Digibord', ['board' => Bord::find($id), 'questions' => $Questions, 'boardRequest' => $boardRequest]);
    }

    public function fetchQuestionsByBoardID($id)
    {
        return BordChatentry::where(['bord_id' => $id])->get();
    }

    public function createBoard(Request $request): RedirectResponse
    {
        $newB = Bord::create(['Title' => $request->title]);
        BoardAssignmentLink::create(['board_id' => $newB->id, 'rngcode' => $newB->id . '' . $this->generateRandomString()]);
        BordUser::create(['bord_id' => $newB->id, 'user_id' => Auth::id()]);
        return redirect('/digibord/' . $newB->id);
    }

    public function JoinBoardWithCode(Request $request): RedirectResponse
    {

        $BoardAL = BoardAssignmentLink::where(['rngcode' => $request->code])->first();
        BordUser::create(['bord_id' => $BoardAL->board_id, 'user_id' => Auth::id()]);
        return redirect('/digibord/'.$BoardAL->board_id);
    }

    //Removes the BordChatEntry Entry, so it won't show up on the board anymore
    public function AnswerQuestion(Request $request)
    {

    }

    //ID refers to the boardAssignmentLink Model Entry ID using link
    //Assign user to board
    public function AssignBoard(Request $request, $id): RedirectResponse
    {
        if (!Auth()) {
            return redirect('/login');
        }
        $BAL = BoardAssignmentLink::find($id);
        BordUser::create(['bord_id' => $BAL->board_id, 'user_id' => Auth::id()]);
        return redirect(`/digibord/${$BAL->board_id}`);
    }

    public function ChatEntryToBoard(Request $request)
    {
        try{
            BordChatentry::create(['bord_id' => $request->boardID, 'chat_entry_id' => $request->chatEntryID]);
            return response("done", 200);
        }catch (\Exception $e){
            return response($e, 500);
        }
    }

}
