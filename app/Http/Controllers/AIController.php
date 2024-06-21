<?php

namespace App\Http\Controllers;

use App\Models\ChatEntry;
use App\Models\ChatHistory;
use App\Models\embedding;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;
use OpenAI\Testing\ClientFake;
use function PHPUnit\Framework\throwException;


class AIController extends Controller
{
    //Test Functions
    public function testFakeCompletionsPrompt(Request $request)
    {
        OpenAI::fake([CreateResponse::fake([
            'choices' => [
                [
                    'text' => 'awesome!',
                ],
            ],
        ])]);

        $completion = OpenAI::completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => 'PHP is ',
        ]);

        return json_encode($completion);
    }

    public function TestBasicLLMChatPrompt(Request $request)
    {
        //GuzzleClient NEEDS to be created, especially when running in Development ENV. Otherwise we get SSL errors. Need to fix that in production, but good enough for mvp
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

        $client = \OpenAI::factory()
            ->withBaseUri(env('OPENAI_API_BASE') . env('ENGINE_GPT_NAME'))
            ->withHttpHeader('api-key', env('OPENAI_API_KEY'))
            ->withQueryParam('api-version', env('OPENAI_API_VERSION'))
            ->withHttpClient($guzzleClient)
            ->make();

        $result = $client->chat()->create([
            'messages' => [
                ['role' => 'system', 'content' => "You are an assistant to students. Your primary goal is to help the user with formulating and asking questions. Try to prevent giving direct answers to questions about learning material.
                Example 1:
                <user>: 1+1 = 2 right?
                <assistant>: that is correct.
                Example 2:
                <user>: I don't understand the self reflection assignment that my teacher gave me.
                <assistant>: You could ask the teacher what specific points you need to reflect on. Then you can apply a common self relfection method or use one your teacher has told you to use. If you need help formulating the question you wish to ask your teacher, just tell me.
                "],
                ['role' => 'user', 'content' => 'How do I ask my teacher to rethink the grade he gave me for my project?'],
            ]
        ]);

        return json_encode($result);

    }

    public function index(Request $request)
    {
        if (isset($request->ChatID)) {
            $FullHistory = ChatHistory::find($request->ChatID)->ChatEntries;
            //Return Inertia Page Here with $FullHistory
        } else {
            //return Inertia Page Here
        }
    }

    public function getHistory(Request $request, $id)
    {
        return ChatHistory::find($id)->ChatEntries;
    }

    public function ChatPrompt(Request $request)
    {
        $CH = 0;
        //GuzzleClient NEEDS to be created, especially when running in Development ENV. Otherwise we get SSL errors. Need to fix that in production, but good enough for mvp
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

        $client = \OpenAI::factory()
            ->withBaseUri(env('OPENAI_API_BASE') . env('ENGINE_GPT_NAME'))
            ->withHttpHeader('api-key', env('OPENAI_API_KEY'))
            ->withQueryParam('api-version', env('OPENAI_API_VERSION'))
            ->withHttpClient($guzzleClient)
            ->make();

        /*$client = new ClientFake([
            \OpenAI\Responses\Chat\CreateResponse::fake([
                'choices'=>[
                    ['text'=>'fake response...']
                ]
            ])
        ]);*/

        $chatHistory = [];
        //Check if $request has a chatHistory ID with it
        if (isset($request->chatHistoryID)) {
            //Yes
            //Save chat entries with ChatHistory ID
            $CH = $request->chatHistoryID;
            ChatEntry::create(['Sender' => 'user', 'Content' => $request->chat, 'chat_history_id' => $CH]);
        } else {
            //Generate title from first prompt

            $NCH = ChatHistory::create(['ChatTitle' => $request->chat, 'user_id'=>Auth::id()]);
            $CH = $NCH->id;
            //Save Chat Entry with this ChatHistoryID
            ChatEntry::create(['Sender' => 'user', 'Content' => $request->chat, 'chat_history_id' => $CH]);
        }

        //Get whole chat history from client for simplicity
        $FCH = $request->history;

        //Send whole history to LLM
        $result = $client->chat()->create([
            'messages' => $FCH
        ]);
        $responseText = $result['choices'][0]['message']['content'];

        //Save response to CH in db
        ChatEntry::create(['Sender' => 'assistant', 'Content' => strval($responseText), 'chat_history_id' => $CH]);

        //Return Response
        $response = json_encode(array('chatID' => $CH, 'response' => $responseText));

        return $response;
    }

    public function removeChatHistory(Request $request, $id)
    {
        try {
            ChatEntry::where('chat_history_id', '=', $id)->delete();
            ChatHistory::find($id)->delete();
            $response = ChatHistory::all();
            return response($response, 200);
        } catch (\Exception $e) {
            return response(json_encode($e), 500);
        }

    }

    public function GenerateEmbeddingFromText(Request $request, $id)
    {
        if (!isset($id) || $id === "undefined") {
            //If new chat without id, create new chat
            $newChat = ChatHistory::create(['ChatTitle' => Carbon::now()->toDateTimeString()]);
            $id = $newChat->id;
        }

        //GuzzleClient NEEDS to be created, especially when running in Development ENV. Otherwise, we get SSL errors. Need to fix that in production, but good enough for mvp
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));

        $client = \OpenAI::factory()
            ->withBaseUri(env('OPENAI_API_BASE') . env('ENGINE_ADA_NAME'))
            ->withHttpHeader('api-key', env('OPENAI_API_KEY'))
            ->withQueryParam('api-version', env('OPENAI_API_VERSION'))
            ->withHttpClient($guzzleClient)
            ->make();

        $chatHistory = ChatHistory::findOrFail($id);

        $textResult = $request->text;

        $embedRes = $client->embeddings()->create([
            'input'=>$textResult
        ]);

        //save to csv file
        $filename = $id.'_Embedding_'.Carbon::now()->toDateString().'.csv';
        $fp = fopen($filename,'w');
        foreach ($embedRes->embeddings as $embedding)
        {
            fputcsv($fp, $embedding->embedding);
        }
        fclose($fp);

        //Save embedding location and relation in DB
        $DBEmbedding = embedding::create(['file_url' => '/public/embedding/'.$filename, 'chat_id' => $id, 'title' => $filename]);

    }

    public function GenerateContextFromText(Request $request, $id)
    {
        if (!isset($id) || $id === "undefined") {
            //If new chat without id, create new chat
            $newChat = ChatHistory::create(['ChatTitle' => Carbon::now()->toDateTimeString()]);
            $id = $newChat->id;
        }

        //Fetch text conversion from post request (conversion is gonna be done from front-end cuz fuck this shit)
        $textResult = $request->text;

        //Save system message to db
        ChatEntry::create(['Content' => 'text file submitted by user: '.$textResult."\n Make sure to not directly answer the user's questions but give feedback and writing tips on how to better formulate their questions.", 'Sender' => 'system', 'chat_history_id' => $id]);

        //return new System Message and or request status.
        return json_encode(array('chatID' => $id, 'role' => 'system', 'response' => 'text file submitted by user: '.$textResult. "\n Make sure to not directly answer the user's questions but give feedback and writing tips on how to better formulate their questions."));
    }

    public function getCSRF(Request $request)
    {
        return csrf_token();
    }
    //create a new bordChatEntry entry
    public function AssignQuestionToBoard(Request $request)
    {

    }

}
