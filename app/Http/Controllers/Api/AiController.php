<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroqService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    protected GroqService $groq;

    public function __construct(GroqService $groq)
    {
        $this->groq = $groq;
    }

    public function recommend(Request $request)
    {
        $query = $request->input('query', '');

        $system = "You are a library recommendation engine. Given the user's query, suggest up to 5 books with short reasons. If possible, prefer books from the provided catalog. Return the response as a short bullet list.";

        $user = "Query: {$query}";

        $resp = $this->groq->chatWithContext($system, $user);

        return response()->json($resp);
    }

    public function summarize(Request $request)
    {
        $text = $request->input('text', '');

        $prompt = "Ringkas teks berikut menjadi 2-3 kalimat yang jelas dalam bahasa Indonesia:\n\n" . $text;

        $resp = $this->groq->complete($prompt);

        return response()->json($resp);
    }

    public function chat(Request $request)
    {
        $message = $request->input('message', '');

        $system = "You are a helpful library assistant. Answer concisely and suggest books when appropriate.";

        $resp = $this->groq->chatWithContext($system, $message);

        return response()->json($resp);
    }
}
