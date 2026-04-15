<?php

namespace App\Http\Controllers;

use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected GroqService $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * API endpoint para enviar preguntas al chatbot
     */
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|min:3|max:1000',
        ], [
            'question.required' => 'Por favor ingresa una pregunta',
            'question.min' => 'La pregunta debe tener al menos 3 caracteres',
            'question.max' => 'La pregunta no puede exceder 1000 caracteres',
        ]);

        try {
            $question = $request->input('question');

            Log::info('Chat API called', [
                'question' => $question,
            ]);

            $response = $this->groqService->askDatabase($question);

            Log::info('Chat API response', [
                'success' => $response['success'] ?? false,
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Chat API error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage(),
            ], 500);
        }
    }
}
