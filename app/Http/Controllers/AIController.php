<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;


class AIController extends Controller
{
    public function testFakePrompt(Request $request)
    {
        OpenAI::fake([CreateResponse::fake([
            'choices'=> [
                [
                    'text'=>'awesome',
                ],
            ],
        ])]);

        $completion = OpenAI::completions()->create([
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => 'PHP is ',
        ]);

        return $completion;

    }
}
