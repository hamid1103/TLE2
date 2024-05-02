<?php

namespace App\Http\Controllers;

use App\Models\ChatEntry;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;


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
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));

        $client = \OpenAI::factory()
            ->withBaseUri(env('OPENAI_API_BASE').env('ENGINE_GPT_NAME'))
            ->withHttpHeader('api-key', env('OPENAI_API_KEY'))
            ->withQueryParam('api-version', env('OPENAI_API_VERSION'))
            ->withHttpClient($guzzleClient)
            ->make();

        $result = $client->chat()->create([
            'messages'=>[
                ['role'=>'system', 'content'=>"You are an assistant to students. Your primary goal is to help the user with formulating and asking questions. Try to prevent giving direct answers to questions about learning material.
                Example 1:
                <user>: 1+1 = 2 right?
                <assistant>: that is correct.
                Example 2:
                <user>: I don't understand the self reflection assignment that my teacher gave me.
                <assistant>: You could ask the teacher what specific points you need to reflect on. Then you can apply a common self relfection method or use one your teacher has told you to use. If you need help formulating the question you wish to ask your teacher, just tell me.
                "],
                ['role'=>'user', 'content'=>'How do I ask my teacher to rethink the grade he gave me for my project?'],
            ]
        ]);

        return json_encode($result);

    }

    public function index(Request $request)
    {
        //Inertia Render "Chat Page"
    }

    public function LoadChatHistory(Request $request)
    {
        //Find Chat History by ID
        //Inertia Render "Chat Page" with Chat History
    }

    public function ChatPrompt(Request $request)
    {
        //GuzzleClient NEEDS to be created, especially when running in Development ENV. Otherwise we get SSL errors. Need to fix that in production, but good enough for mvp
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));

        $client = \OpenAI::factory()
            ->withBaseUri(env('OPENAI_API_BASE').env('ENGINE_GPT_NAME'))
            ->withHttpHeader('api-key', env('OPENAI_API_KEY'))
            ->withQueryParam('api-version', env('OPENAI_API_VERSION'))
            ->withHttpClient($guzzleClient)
            ->make();

        $chatHistory = [];
        //Check if $request has a chatHistory ID with it
        if(isset($request->chatHistoryID))
        {
            //Yes
            //Save chat entries with ChatHistory ID
            ChatEntry::create(['Sender' => 'user', 'Content' => $request->chat, 'chat_history_id'=>$request->chatHistoryID]);
        }else{

            //If not, create one
            //Generate title from first prompt
            //Create ChatHistory
            //Save Chat Entry with this ChatHistoryID
        }
        //Send whole history to LLM
        //Return Response
    }

}
