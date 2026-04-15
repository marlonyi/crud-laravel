# 🤖 Database AI Chat - Configuración y Uso

## 📋 Descripción

El **Database AI Chat** es un chatbot inteligente basado en LLM que aparece como una **burbuja flotante** en la **esquina inferior izquierda** de todas las páginas autenticadas. **Responde completamente en español** y permite hacer preguntas sobre la base de datos de estudiantes, materias, calificaciones e inscripciones. Utiliza la API de **Groq** para responder preguntas en lenguaje natural.

## 🚀 Características

- ✅ **Burbuja flotante** - Disponible en todas las páginas
- ✅ **Abrir/Cerrar** - Click en el botón para mostrar/ocultar
- ✅ Preguntas en lenguaje natural (Español e Inglés)
- ✅ Respuestas contextuales basadas en datos reales de la BD
- ✅ Procesamiento rápido con Groq Mixtral 8x7b
- ✅ Interfaz moderna y responsiva
- ✅ Soporte móvil/tableta
- ✅ Información sobre estudiantes, materias, calificaciones y auditoría

## ⚙️ Configuración

### 1. Obtener API Key de Groq

1. Ve a [https://console.groq.com](https://console.groq.com)
2. Crea una cuenta (si no tienes)
3. Ve a **API Keys** en el dashboard
4. Copia tu API Key

### 2. Configurar en tu proyecto

Abre el archivo `.env` y reemplaza:

```env
GROQ_API_KEY=your-groq-api-key
```

Con tu API Key real:

```env
GROQ_API_KEY=gsk_abc123xyz...
```

### 3. Reiniciar el servidor (opcional)

Si el servidor Laravel está corriendo:

```bash
# Presiona Ctrl+C para detener
# Luego reinicia con:
composer run dev
```

## 📖 Cómo Usar

### Acceder al Chat

1. **Inicia sesión** en http://127.0.0.1:8000
2. Verás una **burbuja púrpura** en la **esquina inferior izquierda** de la pantalla
3. **Haz click** en la burbuja para abrir el chat
4. **Escribe tu pregunta en español** y presiona Enter o click en el botón de enviar
5. **Haz click en la X** para cerrar el chat

### Ejemplos de Preguntas

#### Preguntas sobre Estudiantes
- "¿Cuántos estudiantes hay en el sistema?"
- "¿Cuál es el promedio general de todos los estudiantes?"
- "¿Qué estudiantes tienen bajo rendimiento?"
- "¿Cuál es el email del estudiante con ID 5?"

#### Preguntas sobre Materias
- "¿Cuáles son las materias más inscritas?"
- "¿Cuántos créditos tiene la materia MAT101?"
- "¿Quién es el profesor de Matemáticas?"
- "¿Qué materias ofrece el profesor Juan Pérez?"

#### Preguntas sobre Calificaciones
- "¿Cuál es el promedio de calificaciones?"
- "¿Cuántos estudiantes tienen notas menores a 3.0?"
- "¿Cuál es la distribución de calificaciones?"
- "¿Cuál es la nota más alta en el sistema?"

#### Preguntas sobre Inscripciones
- "¿Cuántas inscripciones activas hay?"
- "¿Qué materias tiene inscrito el estudiante 1?"
- "¿Cuántos estudiantes hay en cada materia?"
- "¿Hay inscripciones sin calificaciones aún?"

#### Preguntas sobre Auditoría
- "¿Cuáles fueron los últimos cambios en el sistema?"
- "¿Qué cambios hizo el usuario 1?"
- "¿Qué se cambió en el estudiante 5?"
- "¿Cuántas acciones se registraron hoy?"

## 🔄 Cómo Funciona

```
┌──────────────────────┐
│  Burbuja Flotante    │
│  (esquina inferior   │
│   derecha)           │
└──────────┬───────────┘
           │
           ▼ (Click en la burbuja)
┌──────────────────────┐
│   Chat Panel abre    │
│   hacia arriba desde │
│   la burbuja         │
└──────────┬───────────┘
           │
           ▼ (Usuario escribe pregunta)
┌──────────────────────┐
│   ChatController     │
│   valida la pregunta │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   GroqService        │
│   - Obtiene contexto │
│   - Construye prompt │
│   - Envía a Groq API │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   Groq LLM           │
│   (Mixtral 8x7b)     │
│   Procesa pregunta   │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│   Respuesta en la    │
│   burbuja del chat   │
└──────────────────────┘
```

## 📊 Contexto que el AI Entiende

El chatbot tiene acceso a información sobre:

### Tablas
- **usuarios** (users) - Usuarios registrados
- **estudiantes** (estudiantes) - Información de estudiantes
- **materias** (materias) - Cursos/asignaturas
- **inscripciones** (inscripcions) - Registros de inscripción
- **calificaciones** (calificacions) - Notas y evaluaciones
- **auditoría** (audits) - Log de cambios en el sistema

### Estadísticas
- Total de estudiantes, materias, inscripciones y calificaciones
- Promedio general de calificaciones
- Notas mínimas y máximas
- Distribución de calificaciones

## 🛠️ Integración en tu Aplicación

### Ubicación de los Archivos

```
app/
├── Services/
│   └── GroqService.php              ← Lógica del chatbot
└── Http/
    └── Controllers/
        └── ChatController.php       ← Controlador API

resources/views/
├── components/
│   └── chat-widget.blade.php        ← Burbuja flotante
└── layouts/
    ├── app.blade.php                ← Layout principal
    └── modern.blade.php             ← Layout del dashboard

config/
└── services.php                     ← Configuración de Groq
```

### Rutas disponibles

```
POST /api/chat/ask      → Enviar pregunta (API endpoint)
```

### Ejemplo de request API

```bash
curl -X POST http://127.0.0.1:8000/api/chat/ask \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: $(csrf-token)" \
  -d '{
    "question": "¿Cuántos estudiantes hay?"
  }'
```

### Response

```json
{
  "success": true,
  "response": "Hay 15 estudiantes registrados en el sistema..."
}
```

## 🔐 Seguridad

- ✅ Requiere autenticación (middleware auth)
- ✅ Protección CSRF token
- ✅ Validación de input
- ✅ La API key se almacena en .env (no en git)
- ✅ Las consultas son leídas (SELECT), sin modificación de datos

## 📝 Límites y Limitaciones

- **Longitud máxima de pregunta:** 1000 caracteres
- **Tokens máximos por respuesta:** 2000
- **Temperatura:** 0.7 (respuestas moderadamente creativas)
- **Modelos soportados:** Groq Mixtral 8x7b (configurable)

## 🐛 Solución de Problemas

### "API key is not configured"
- Verifica que `GROQ_API_KEY` esté en `.env`
- Asegúrate que el valor no sea `your-groq-api-key`
- Reinicia el servidor

### "Network error" o "Groq API error"
- Verifica tu conexión a internet
- Comprueba que tu API key es válida en [console.groq.com](https://console.groq.com)
- Revisa que tu cuota no esté agotada

### Las respuestas no son precisas
- Las respuestas se basan en el contexto de BD que se envía
- Trata de ser más específico en tus preguntas
- El modelo Mixtral es muy bueno pero puede tener alucinaciones ocasionales

## 📚 Recursos

- [Documentación de Groq](https://console.groq.com/docs)
- [Modelos soportados por Groq](https://console.groq.com/docs/speech-text)
- [API Reference](https://console.groq.com/docs/api)

## 🚀 Mejoras Futuras

- [ ] Guardar historial de chat en BD
- [ ] Exportar conversaciones a PDF
- [ ] Múltiples temas de color para la burbuja
- [ ] Respuestas en múltiples idiomas con mejor traducción
- [ ] Gráficos generados automáticamente basados en datos
- [ ] Análisis de preguntas frecuentes
- [ ] Integración con webhooks para notificaciones
- [ ] Contador de mensajes sin leer en la burbuja
- [ ] Sugerencias de preguntas populares

---

**Versión:** 1.0  
**Última actualización:** 15 de Abril de 2026

## 📞 Soporte

Si tienes problemas con el chatbot, revisa la sección de **Solución de Problemas** o consulta la documentación oficial de Groq en [https://console.groq.com/docs](https://console.groq.com/docs)
