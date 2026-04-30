<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        $this->baseUrl = 'https://api.groq.com/openai/v1';
        $this->model = config('services.groq.model', 'openai/gpt-oss-20b');
    }

    /**
     * Send a chat completion request to Groq API
     */
    public function chat(array $messages, array $options = []): array
    {
        $payload = array_merge([
            'model' => $this->model,
            'messages' => $messages,
        ], $options);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', $payload);

            if ($response->failed()) {
                Log::error('Groq API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => $this->parseErrorResponse($response),
                ];
            }

            $data = $response->json();

            return [
                'success' => true,
                'content' => $data['choices'][0]['message']['content'] ?? '',
                'usage' => $data['usage'] ?? [],
                'raw' => $data,
            ];
        } catch (\Exception $e) {
            Log::error('Groq API exception', ['exception' => $e->getMessage()]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Simple text completion
     */
    public function complete(string $prompt, array $options = []): array
    {
        $messages = [
            ['role' => 'user', 'content' => $prompt],
        ];

        return $this->chat($messages, $options);
    }

    /**
     * Generate a response with system context
     */
    public function chatWithContext(string $systemPrompt, string $userMessage, array $options = []): array
    {
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userMessage],
        ];

        return $this->chat($messages, $options);
    }

    /**
     * List available models
     */
    public function listModels(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/models');

            if ($response->failed()) {
                return [
                    'success' => false,
                    'error' => $this->parseErrorResponse($response),
                ];
            }

            return [
                'success' => true,
                'models' => $response->json()['data'] ?? [],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Parse error response from Groq API
     */
    protected function parseErrorResponse($response): string
    {
        $errorBody = $response->json();

        return $errorBody['error']['message'] ??
               $errorBody['message'] ??
               'Unknown error occurred';
    }

    /**
     * Set the model to use
     */
    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get the current model
     */
    public function getModel(): string
    {
        return $this->model;
    }
}
