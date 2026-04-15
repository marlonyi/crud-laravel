<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Estudiante;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatService
{
    protected GroqService $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * Obtener o crear ID de sesión para el usuario actual
     */
    public function obtenerSesionId(): string
    {
        $user = Auth::user();
        
        if ($user) {
            // Usar un ID de sesión basado en el usuario y la fecha actual
            return 'user_' . $user->id . '_' . now()->format('Y-m-d');
        }

        // Para usuarios no autenticados, usar session_id
        return session()->getId();
    }

    /**
     * Enviar pregunta al chatbot con contexto de conversación
     */
    public function enviarPregunta(string $pregunta, ?string $sessionId = null): array
    {
        $sessionId = $sessionId ?? $this->obtenerSesionId();
        $userId = Auth::id();

        try {
            // 1. Guardar mensaje del usuario
            ChatMessage::crearMensajeUsuario($sessionId, $pregunta, $userId, [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // 2. Obtener historial de conversación
            $historial = ChatMessage::getHistorialParaLLM($sessionId, 20);

            // 3. Obtener contexto completo de la base de datos
            $contextoBD = $this->obtenerContextoBaseDatos();

            // 4. Construir prompt del sistema con contexto
            $promptSistema = $this->construirPromptSistema($contextoBD);

            // 5. Verificar que Groq está configurado
            if (!$this->groqService->isConfigured()) {
                return [
                    'success' => false,
                    'error' => 'La API key de Groq no está configurada. Verifica tu archivo .env',
                ];
            }

            // 6. Enviar a Groq con historial y contexto
            $respuestaGroq = $this->groqService->enviarConversacion(
                $promptSistema,
                $historial,
                $pregunta
            );

            if (!$respuestaGroq['success']) {
                return $respuestaGroq;
            }

            // 7. Guardar respuesta del asistente
            ChatMessage::crearMensajeAsistente(
                $sessionId,
                $respuestaGroq['response'],
                $userId,
                [
                    'contexto_usado' => true,
                    'mensajes_historial' => count($historial),
                ]
            );

            return [
                'success' => true,
                'response' => $respuestaGroq['response'],
                'session_id' => $sessionId,
            ];

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ChatService error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Error al procesar la pregunta: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener historial de chat de la sesión actual
     */
    public function obtenerHistorialSesion(?string $sessionId = null, int $limite = 50): array
    {
        $sessionId = $sessionId ?? $this->obtenerSesionId();

        $mensajes = ChatMessage::deSesion($sessionId)
            ->recientes($limite)
            ->with('user:id,name')
            ->get()
            ->map(function (ChatMessage $mensaje) {
                return [
                    'id' => $mensaje->id,
                    'role' => $mensaje->role,
                    'content' => $mensaje->content,
                    'created_at' => $mensaje->created_at->toIso8601String(),
                    'created_at_human' => $mensaje->created_at->diffForHumans(),
                ];
            });

        return [
            'session_id' => $sessionId,
            'messages' => $mensajes,
            'total' => $mensajes->count(),
        ];
    }

    /**
     * Limpiar historial de la sesión actual
     */
    public function limpiarHistorial(?string $sessionId = null): bool
    {
        $sessionId = $sessionId ?? $this->obtenerSesionId();

        ChatMessage::where('session_id', $sessionId)->delete();

        return true;
    }

    /**
     * Obtener contexto completo de la base de datos
     */
    protected function obtenerContextoBaseDatos(): array
    {
        return [
            'estadisticas_generales' => $this->obtenerEstadisticasGenerales(),
            'estudiantes' => $this->obtenerContextoEstudiantes(),
            'materias' => $this->obtenerContextoMaterias(),
            'inscripciones' => $this->obtenerContextoInscripciones(),
            'calificaciones' => $this->obtenerContextoCalificaciones(),
            'auditoria' => $this->obtenerContextoAuditoria(),
        ];
    }

    /**
     * Obtener estadísticas generales del sistema
     */
    protected function obtenerEstadisticasGenerales(): array
    {
        $totalEstudiantes = Estudiante::count();
        $totalMaterias = Materia::count();
        $totalInscripciones = Inscripcion::count();
        $totalCalificaciones = Calificacion::count();
        
        $promedioGeneral = Calificacion::avg('nota');
        $notaMinima = Calificacion::min('nota');
        $notaMaxima = Calificacion::max('nota');

        // Calificaciones por rango
        $excelentes = Calificacion::where('nota', '>=', 4.5)->count();
        $muyBuenas = Calificacion::whereBetween('nota', [4.0, 4.49])->count();
        $buenas = Calificacion::whereBetween('nota', [3.5, 3.99])->count();
        $suficientes = Calificacion::whereBetween('nota', [3.0, 3.49])->count();
        $bajoRendimiento = Calificacion::where('nota', '<', 3.0)->count();

        return [
            'total_estudiantes' => $totalEstudiantes,
            'total_materias' => $totalMaterias,
            'total_inscripciones' => $totalInscripciones,
            'total_calificaciones' => $totalCalificaciones,
            'promedio_general' => round($promedioGeneral ?? 0, 2),
            'nota_minima' => round($notaMinima ?? 0, 2),
            'nota_maxima' => round($notaMaxima ?? 0, 2),
            'distribucion' => [
                'excelente_45_50' => $excelentes,
                'muy_bueno_40_44' => $muyBuenas,
                'bueno_35_39' => $buenas,
                'suficiente_30_34' => $suficientes,
                'desaprobado_0_29' => $bajoRendimiento,
            ],
        ];
    }

    /**
     * Obtener contexto de estudiantes
     */
    protected function obtenerContextoEstudiantes(): array
    {
        try {
            // Lista de estudiantes con información básica
            $estudiantes = Estudiante::select('id', 'nombre', 'apellido', 'email', 'cedula')
                ->orderBy('nombre')
                ->get()
                ->map(function ($estudiante) {
                    $promedio = $estudiante->promedioGeneral();
                    return [
                        'id' => $estudiante->id,
                        'nombre_completo' => $estudiante->nombre_completo,
                        'email' => $estudiante->email,
                        'cedula' => $estudiante->cedula,
                        'promedio_general' => $promedio,
                    ];
                });

            // Estudiantes con mejor promedio
            $mejoresPromedios = Estudiante::select([
                    'estudiantes.id',
                    'estudiantes.nombre',
                    'estudiantes.apellido',
                ])
                ->join('inscripcions', 'estudiantes.id', '=', 'inscripcions.estudiante_id')
                ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
                ->groupBy('estudiantes.id', 'estudiantes.nombre', 'estudiantes.apellido')
                ->orderByRaw('AVG(calificacions.nota) DESC')
                ->limit(10)
                ->get()
                ->map(function ($estudiante) {
                    $promedio = DB::table('inscripcions')
                        ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
                        ->where('inscripcions.estudiante_id', $estudiante->id)
                        ->avg('calificacions.nota');
                    
                    return [
                        'nombre_completo' => "{$estudiante->nombre} {$estudiante->apellido}",
                        'promedio' => round($promedio ?? 0, 2),
                    ];
                });

            // Estudiantes con bajo rendimiento
            $bajoRendimiento = Estudiante::select([
                    'estudiantes.id',
                    'estudiantes.nombre',
                    'estudiantes.apellido',
                ])
                ->join('inscripcions', 'estudiantes.id', '=', 'inscripcions.estudiante_id')
                ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
                ->groupBy('estudiantes.id', 'estudiantes.nombre', 'estudiantes.apellido')
                ->havingRaw('AVG(calificacions.nota) < ?', [3.0])
                ->orderByRaw('AVG(calificacions.nota) ASC')
                ->limit(10)
                ->get()
                ->map(function ($estudiante) {
                    $promedio = DB::table('inscripcions')
                        ->join('calificacions', 'inscripcions.id', '=', 'calificacions.inscripcion_id')
                        ->where('inscripcions.estudiante_id', $estudiante->id)
                        ->avg('calificacions.nota');
                    
                    return [
                        'nombre_completo' => "{$estudiante->nombre} {$estudiante->apellido}",
                        'promedio' => round($promedio ?? 0, 2),
                    ];
                });

            return [
                'lista' => $estudiantes,
                'mejores_promedios' => $mejoresPromedios,
                'bajo_rendimiento' => $bajoRendimiento,
            ];
        } catch (\Exception $e) {
            return [
                'lista' => [],
                'mejores_promedios' => [],
                'bajo_rendimiento' => [],
            ];
        }
    }

    /**
     * Obtener contexto de materias
     */
    protected function obtenerContextoMaterias(): array
    {
        $materias = Materia::select('id', 'nombre', 'codigo', 'profesor', 'creditos')
            ->orderBy('nombre')
            ->get()
            ->map(function ($materia) {
                $inscritos = Inscripcion::where('materia_id', $materia->id)->count();
                $promedio = Calificacion::join('inscripcions', 'calificacions.inscripcion_id', '=', 'inscripcions.id')
                    ->where('inscripcions.materia_id', $materia->id)
                    ->avg('calificacions.nota');
                
                return [
                    'id' => $materia->id,
                    'nombre' => $materia->nombre,
                    'codigo' => $materia->codigo,
                    'profesor' => $materia->profesor,
                    'creditos' => $materia->creditos,
                    'total_inscritos' => $inscritos,
                    'promedio_notas' => round($promedio ?? 0, 2),
                ];
            });

        // Materias más populares
        $materiasPopulares = Materia::select([
                'materias.id',
                'materias.nombre',
                'materias.codigo',
            ])
            ->join('inscripcions', 'materias.id', '=', 'inscripcions.materia_id')
            ->groupBy('materias.id', 'materias.nombre', 'materias.codigo')
            ->orderByRaw('COUNT(inscripcions.id) DESC')
            ->limit(10)
            ->get()
            ->map(function ($materia) {
                return [
                    'nombre' => $materia->nombre,
                    'codigo' => $materia->codigo,
                    'inscritos' => DB::table('inscripcions')->where('materia_id', $materia->id)->count(),
                ];
            });

        // Profesores y sus materias
        $profesores = Materia::select('profesor')
            ->selectRaw('COUNT(*) as total_materias')
            ->selectRaw('STRING_AGG(nombre, \', \') as materias')
            ->groupBy('profesor')
            ->orderByDesc('total_materias')
            ->get();

        return [
            'lista' => $materias,
            'mas_populares' => $materiasPopulares,
            'profesores' => $profesores,
        ];
    }

    /**
     * Obtener contexto de inscripciones
     */
    protected function obtenerContextoInscripciones(): array
    {
        $inscripcionesActivas = Inscripcion::where('estado', 'activa')->count();
        $inscripcionesCompletadas = Inscripcion::where('estado', 'completada')->count();
        $inscripcionesCanceladas = Inscripcion::where('estado', 'cancelada')->count();

        // Inscripciones recientes
        $inscripcionesRecientes = Inscripcion::with(['estudiante', 'materia'])
            ->latest('fecha_inscripcion')
            ->limit(10)
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'estudiante' => $inscripcion->estudiante->nombre_completo,
                    'materia' => $inscripcion->materia->nombre . ' (' . $inscripcion->materia->codigo . ')',
                    'estado' => $inscripcion->estado,
                    'fecha' => $inscripcion->fecha_inscripcion->format('Y-m-d'),
                ];
            });

        // Inscripciones sin calificaciones
        $sinCalificaciones = Inscripcion::where('estado', 'activa')
            ->whereDoesntHave('calificaciones')
            ->with(['estudiante', 'materia'])
            ->limit(10)
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'estudiante' => $inscripcion->estudiante->nombre_completo,
                    'materia' => $inscripcion->materia->nombre,
                    'fecha_inscripcion' => $inscripcion->fecha_inscripcion->format('Y-m-d'),
                ];
            });

        return [
            'totales_por_estado' => [
                'activa' => $inscripcionesActivas,
                'completada' => $inscripcionesCompletadas,
                'cancelada' => $inscripcionesCanceladas,
            ],
            'recientes' => $inscripcionesRecientes,
            'sin_calificaciones' => $sinCalificaciones,
        ];
    }

    /**
     * Obtener contexto de calificaciones
     */
    protected function obtenerContextoCalificaciones(): array
    {
        try {
            // Calificaciones por tipo
            $porTipoRaw = Calificacion::selectRaw('tipo, COUNT(*) as total, ROUND(AVG(nota)::numeric, 2) as promedio')
                ->groupBy('tipo')
                ->get();
            
            $porTipo = [];
            foreach ($porTipoRaw as $item) {
                $porTipo[$item->tipo] = [
                    'total' => $item->total,
                    'promedio' => $item->promedio,
                ];
            }

            // Calificaciones por materia
            $porMateria = Calificacion::join('inscripcions', 'calificacions.inscripcion_id', '=', 'inscripcions.id')
                ->join('materias', 'inscripcions.materia_id', '=', 'materias.id')
                ->select('materias.nombre', 'materias.codigo')
                ->selectRaw('COUNT(*) as total, ROUND(AVG(calificacions.nota)::numeric, 2) as promedio, ROUND(MIN(calificacions.nota)::numeric, 2) as minima, ROUND(MAX(calificacions.nota)::numeric, 2) as maxima')
                ->groupBy('materias.id', 'materias.nombre', 'materias.codigo')
                ->orderByDesc('promedio')
                ->limit(20)
                ->get();

            return [
                'por_tipo' => $porTipo,
                'por_materia' => $porMateria,
            ];
        } catch (\Exception $e) {
            return [
                'por_tipo' => [],
                'por_materia' => [],
            ];
        }
    }

    /**
     * Obtener contexto de auditoría
     */
    protected function obtenerContextoAuditoria(): array
    {
        try {
            // Acciones recientes
            $accionesRecientes = Audit::latest()
                ->limit(10)
                ->get()
                ->map(function ($audit) {
                    return [
                        'usuario_id' => $audit->user_id ?? 'Sistema',
                        'accion' => $audit->action,
                        'entidad' => class_basename($audit->auditable_type) . ' #' . $audit->auditable_id,
                        'fecha' => $audit->created_at->diffForHumans(),
                    ];
                });

            // Totales por acción
            $porAccionRaw = Audit::selectRaw('action, COUNT(*) as total')
                ->groupBy('action')
                ->get();
            
            $porAccion = [];
            foreach ($porAccionRaw as $item) {
                $porAccion[$item->action] = $item->total;
            }

            return [
                'acciones_recientes' => $accionesRecientes,
                'totales_por_accion' => $porAccion,
            ];
        } catch (\Exception $e) {
            return [
                'acciones_recientes' => [],
                'totales_por_accion' => [],
            ];
        }
    }

    /**
     * Construir prompt del sistema con contexto completo
     */
    protected function construirPromptSistema(array $contexto): string
    {
        $estadisticas = json_encode($contexto['estadisticas_generales'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $estudiantes = json_encode($contexto['estudiantes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $materias = json_encode($contexto['materias'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $inscripciones = json_encode($contexto['inscripciones'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $calificaciones = json_encode($contexto['calificaciones'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $auditoria = json_encode($contexto['auditoria'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
Eres un asistente experto en análisis de datos académicos de un sistema de gestión universitaria.
SIEMPRE debes responder en ESPAÑOL de manera clara y concisa.

## DATOS ACTUALES DEL SISTEMA (INFORMACIÓN REAL Y ACTUALIZADA)

### ESTADÍSTICAS GENERALES:
{$estadisticas}

### ESTUDIANTES:
{$estudiantes}

### MATERIAS:
{$materias}

### INSCRIPCIONES:
{$inscripciones}

### CALIFICACIONES:
{$calificaciones}

### AUDITORÍA:
{$auditoria}

## INSTRUCCIONES IMPORTANTES:
1. Responde SIEMPRE en español
2. Sé CONCISO y directo (máximo 2-3 líneas para respuestas simples)
3. Usa EXCLUSIVAMENTE los datos proporcionados arriba
4. Para conteos, usa los números exactos de las estadísticas
5. Para búsquedas de estudiantes, busca en la lista de estudiantes
6. Para búsquedas de materias, busca en la lista de materias
7. Si algo NO está en los datos, responde "No tengo esa información disponible"
8. Para comparaciones o análisis complejos, usa los datos de calificaciones e inscripciones
9. Puedes dar recomendaciones basadas en los datos disponibles
10. Si te piden un listado, preséntalo de forma organizada

## CAPACIDADES:
- Contar estudiantes, materias, inscripciones, calificaciones
- Mostrar promedios, notas mínimas y máximas
- Identificar estudiantes con bajo/alto rendimiento
- Mostrar materias más/menos populares
- Analizar distribución de calificaciones
- Ver estado de inscripciones
- Mostrar actividad reciente del sistema
- Responder preguntas específicas sobre estudiantes o materias

Ahora responde de manera concisa y útil en español.
PROMPT;
    }
}
