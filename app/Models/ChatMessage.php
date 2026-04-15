<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'role',
        'content',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: mensajes de una sesión específica
     */
    public function scopeDeSesion(Builder $query, string $sessionId): Builder
    {
        return $query->where('session_id', $sessionId)
            ->orderBy('created_at', 'asc');
    }

    /**
     * Scope: mensajes de un usuario
     */
    public function scopeDeUsuario(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope: mensajes recientes
     */
    public function scopeRecientes(Builder $query, int $limit = 50): Builder
    {
        return $query->latest('created_at')->limit($limit);
    }

    /**
     * Scope: filtrar por rol
     */
    public function scopePorRol(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: mensajes del usuario (role = 'user')
     */
    public function scopeDelUsuario(Builder $query): Builder
    {
        return $query->where('role', 'user');
    }

    /**
     * Scope: respuestas del asistente (role = 'assistant')
     */
    public function scopeDelAsistente(Builder $query): Builder
    {
        return $query->where('role', 'assistant');
    }

    /**
     * Obtener historial de conversación formateado para el LLM
     */
    public static function getHistorialParaLLM(string $sessionId, int $limiteMensajes = 20): array
    {
        return self::deSesion($sessionId)
            ->recientes($limiteMensajes)
            ->get()
            ->map(function (ChatMessage $mensaje) {
                return [
                    'role' => $mensaje->role,
                    'content' => $mensaje->content,
                ];
            })
            ->toArray();
    }

    /**
     * Crear un mensaje de usuario
     */
    public static function crearMensajeUsuario(string $sessionId, string $contenido, ?int $userId = null, ?array $metadata = null): self
    {
        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'user',
            'content' => $contenido,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Crear un mensaje del asistente
     */
    public static function crearMensajeAsistente(string $sessionId, string $contenido, ?int $userId = null, ?array $metadata = null): self
    {
        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'assistant',
            'content' => $contenido,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Crear un mensaje del sistema
     */
    public static function crearMensajeSistema(string $sessionId, string $contenido, ?int $userId = null, ?array $metadata = null): self
    {
        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'system',
            'content' => $contenido,
            'metadata' => $metadata,
        ]);
    }
}
