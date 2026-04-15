<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY');
        $this->model = env('GROQ_MODEL', 'mixtral-8x7b-32768');
    }

    /**
     * Enviar conversación completa con historial de mensajes
     * 
     * @param string $systemPrompt Prompt del sistema
     * @param array $historial Historial de mensajes anteriores
     * @param string $nuevoMensaje Nuevo mensaje del usuario
     */
    public function enviarConversacion(string $systemPrompt, array $historial, string $nuevoMensaje): array
    {
        try {
            // Construir array de mensajes para Groq
            $mensajes = [
                [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ],
            ];

            // Agregar historial de conversación (últimos 20 mensajes)
            foreach ($historial as $mensaje) {
                $mensajes[] = [
                    'role' => $mensaje['role'] === 'assistant' ? 'assistant' : 'user',
                    'content' => $mensaje['content'],
                ];
            }

            // Agregar nuevo mensaje del usuario
            $mensajes[] = [
                'role' => 'user',
                'content' => $nuevoMensaje,
            ];

            // Enviar a Groq
            $response = $this->sendToGroqConMensajes($mensajes);

            return [
                'success' => true,
                'response' => $response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Enviar pregunta al LLM de Groq y obtener respuesta (método antiguo, mantener por compatibilidad)
     */
    public function askDatabase(string $question): array
    {
        try {
            // Primero, obtener contexto de la BD
            $dbContext = $this->getDatabaseContext();

            // Crear prompt del sistema
            $systemPrompt = $this->buildSystemPrompt($dbContext);

            // Enviar pregunta a Groq
            $response = $this->sendToGroq($systemPrompt, $question);

            return [
                'success' => true,
                'response' => $response,
                'context' => $dbContext,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener contexto de la base de datos (esquema y datos)
     */
    protected function getDatabaseContext(): array
    {
        return [
            'tables' => $this->getTableInfo(),
            'sample_data' => $this->getSampleData(),
            'statistics' => $this->getBasicStatistics(),
        ];
    }

    /**
     * Obtener información de las tablas
     */
    protected function getTableInfo(): array
    {
        $tables = [];

        // Usuarios
        $tables['users'] = [
            'description' => 'Users registered in the system',
            'columns' => ['id', 'name', 'email', 'password', 'created_at', 'updated_at'],
        ];

        // Estudiantes
        $tables['estudiantes'] = [
            'description' => 'Student information',
            'columns' => ['id', 'nombre', 'apellido', 'email', 'cedula', 'fecha_nacimiento', 'telefono', 'direccion', 'created_at', 'updated_at'],
        ];

        // Materias
        $tables['materias'] = [
            'description' => 'Courses/subjects offered',
            'columns' => ['id', 'nombre', 'codigo', 'creditos', 'descripcion', 'profesor', 'horas_semana', 'created_at', 'updated_at'],
        ];

        // Inscripciones
        $tables['inscripcions'] = [
            'description' => 'Student enrollments in courses',
            'columns' => ['id', 'estudiante_id', 'materia_id', 'fecha_inscripcion', 'estado', 'promedio', 'created_at', 'updated_at'],
            'states' => ['activa', 'completada', 'cancelada'],
        ];

        // Calificaciones
        $tables['calificacions'] = [
            'description' => 'Grades and evaluations',
            'columns' => ['id', 'inscripcion_id', 'nota', 'tipo', 'fecha', 'observaciones', 'created_at', 'updated_at'],
            'types' => ['Parcial 1', 'Parcial 2', 'Parcial 3', 'Final', 'Trabajo Práctico'],
            'notes_range' => '0.00 to 5.00',
        ];

        // Audits
        $tables['audits'] = [
            'description' => 'System audit log - tracks all changes',
            'columns' => ['id', 'user_id', 'auditable_type', 'auditable_id', 'action', 'old_values', 'new_values', 'ip_address', 'user_agent', 'created_at'],
            'actions' => ['created', 'updated', 'deleted'],
        ];

        return $tables;
    }

    /**
     * Obtener datos de muestra - OPTIMIZADO para evitar superar límites de tokens
     */
    protected function getSampleData(): array
    {
        // Obtener conteos exactos de la BD
        $totalStudents = DB::table('estudiantes')->count();
        $totalCourses = DB::table('materias')->count();
        $totalEnrollments = DB::table('inscripcions')->count();
        $totalGrades = DB::table('calificacions')->count();
        $avgGrade = DB::table('calificacions')->avg('nota');

        // Solo obtener lista de nombres de estudiantes (SIN detalle de emails/cédulas)
        $allStudents = DB::table('estudiantes')
            ->select('nombre', 'apellido')
            ->orderBy('nombre')
            ->get();
        
        $studentsList = $allStudents->map(fn($s) => "{$s->nombre} {$s->apellido}")->toArray();
        
        // Solo nombres de materias
        $allCourses = DB::table('materias')
            ->select('nombre', 'codigo')
            ->orderBy('nombre')
            ->get();
        
        $coursesList = $allCourses->map(fn($c) => "{$c->nombre} ({$c->codigo})")->toArray();
        
        return [
            'total_students' => $totalStudents,
            'total_courses' => $totalCourses,
            'total_enrollments' => $totalEnrollments,
            'total_grades' => $totalGrades,
            'average_grade' => round($avgGrade ?? 0, 2),
            'all_students' => $studentsList,
            'all_courses' => $coursesList,
        ];
    }

    /**
     * Obtener estadísticas básicas
     */
    protected function getBasicStatistics(): array
    {
        $stats = DB::table('calificacions')
            ->selectRaw('
                COUNT(*) as total,
                ROUND(AVG(nota)::numeric, 2) as promedio,
                ROUND(MIN(nota)::numeric, 2) as minima,
                ROUND(MAX(nota)::numeric, 2) as maxima
            ')
            ->first();

        return (array) $stats;
    }

    /**
     * Construir prompt del sistema - MÁXIMAMENTE OPTIMIZADO
     */
    protected function buildSystemPrompt(array $context): string
    {
        $sampleData = json_encode($context['sample_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
Database assistant for university management system. Current data:
{$sampleData}

RULES:
1. Answer in Spanish, 1 line maximum
2. Use only numbers from data above
3. Answer directly, no explanations

Respond to user query:
PROMPT;
    }

    /**
     * Enviar a Groq con array de mensajes completo (para conversaciones)
     */
    protected function sendToGroqConMensajes(array $mensajes): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => $mensajes,
            'temperature' => 0.7,
            'max_tokens' => 2000,
            'top_p' => 0.9,
        ]);

        if ($response->failed()) {
            $body = $response->body();
            throw new \Exception('Error en API de Groq: ' . $body);
        }

        $data = $response->json();

        if (!isset($data['choices']) || !is_array($data['choices']) || count($data['choices']) === 0) {
            Log::error('Respuesta inesperada de Groq:', ['response' => $data]);
            throw new \Exception('Respuesta inválida de Groq: ' . json_encode($data));
        }

        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('Estructura de mensaje inválida:', ['choice' => $data['choices'][0]]);
            throw new \Exception('La respuesta de Groq no contiene el campo esperado');
        }

        return $data['choices'][0]['message']['content'];
    }

    /**
     * Enviar pregunta a Groq
     */
    protected function sendToGroq(string $systemPrompt, string $userQuestion): string
    {
        $mensajes = [
            [
                'role' => 'system',
                'content' => $systemPrompt,
            ],
            [
                'role' => 'user',
                'content' => $userQuestion,
            ],
        ];

        return $this->sendToGroqConMensajes($mensajes);
    }

    /**
     * Validar que la API key está configurada
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && $this->apiKey !== 'your-groq-api-key';
    }
}
