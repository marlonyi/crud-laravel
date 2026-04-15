<!-- Floating Chat Widget -->
<div id="chatWidget" class="chat-widget">
    <!-- Botón flotante -->
    <button id="chatToggle" class="chat-toggle" title="Chat con IA">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span id="unreadBadge" class="unread-badge" style="display: none;">0</span>
    </button>

    <!-- Panel del chat -->
    <div id="chatPanel" class="chat-panel">
        <div class="chat-header">
            <div class="header-left">
                <h3>🤖 Asistente IA</h3>
            </div>
            <div class="header-right">
                <button id="clearHistoryBtn" class="btn-clear-history" title="Limpiar historial">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
                <button id="chatClose" class="btn-close" title="Cerrar">×</button>
            </div>
        </div>

        <!-- Área de mensajes -->
        <div class="chat-messages-container" id="chatMessagesContainer">
            <div class="message system-message">
                <div class="message-content">
                    ¡Hola! 👋 Soy tu asistente de base de datos. Puedo ayudarte con preguntas sobre:<br><br>
                    • <strong>Estudiantes</strong> - información, promedios, rendimiento<br>
                    • <strong>Materias</strong> - cursos, profesores, inscritos<br>
                    • <strong>Calificaciones</strong> - notas, estadísticas, distribución<br>
                    • <strong>Inscripciones</strong> - estados, actividad reciente<br>
                    • <strong>Auditoría</strong> - cambios recientes en el sistema<br><br>
                    ¿En qué puedo ayudarte?
                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="chatLoader" class="chat-loader" style="display: none;">
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Área de input -->
        <div class="chat-input-wrapper">
            <form id="chatWidgetForm" class="chat-input-form">
                <input
                    type="text"
                    id="chatWidgetInput"
                    class="chat-input"
                    placeholder="Escribe tu pregunta..."
                    autocomplete="off"
                />
                <button type="submit" class="btn-send" id="chatWidgetSendBtn" title="Enviar mensaje">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Chat Widget Styles */
    .chat-widget {
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
        z-index: 9999;
    }

    .chat-toggle {
        position: relative;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 24px;
    }

    .chat-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .chat-toggle:active {
        transform: scale(0.95);
    }

    .unread-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(255, 71, 87, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Chat Panel */
    .chat-panel {
        position: absolute;
        bottom: 80px;
        left: 0;
        width: 420px;
        height: 600px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .chat-panel.open {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    /* Chat Header */
    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .header-left h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .header-right {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-clear-history {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-clear-history:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .btn-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        line-height: 1;
    }

    .btn-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    /* Messages Container */
    .chat-messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: #f8f9fa;
    }

    .message {
        display: flex;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.user-message {
        justify-content: flex-end;
    }

    .message.system-message {
        justify-content: flex-start;
    }

    .message-content {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
        word-wrap: break-word;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .user-message .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .system-message .message-content {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
    }

    .message-time {
        font-size: 11px;
        color: #999;
        margin-top: 4px;
        text-align: right;
    }

    .user-message .message-time {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Input Wrapper */
    .chat-input-wrapper {
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        background: white;
    }

    .chat-input-form {
        display: flex;
        gap: 10px;
    }

    .chat-input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }

    .chat-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .chat-input::placeholder {
        color: #999;
    }

    .btn-send {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-send:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-send:active {
        transform: scale(0.95);
    }

    .btn-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Typing Indicator */
    .chat-loader {
        display: flex;
        justify-content: flex-start;
        padding: 12px 20px;
        background: #f8f9fa;
    }

    .typing-indicator {
        display: flex;
        gap: 6px;
        padding: 12px 16px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #667eea;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.7;
        }
        30% {
            transform: translateY(-10px);
            opacity: 1;
        }
    }

    /* Estilos responsivos */
    @media (max-width: 768px) {
        .chat-widget {
            bottom: 15px;
            left: 15px;
        }

        .chat-panel {
            width: calc(100vw - 30px);
            height: 70vh;
            bottom: 80px;
            left: 0;
            right: 0;
            margin: 0 auto;
        }

        .message-content {
            max-width: 90%;
        }
    }

    /* Scrollbar personalizado */
    .chat-messages-container::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-messages-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .chat-messages-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Sugerencias de preguntas */
    .question-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .suggestion-btn {
        background: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 16px;
        padding: 6px 12px;
        font-size: 12px;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
    }

    .suggestion-btn:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
</style>

<script>
    // Chat Widget JavaScript
    const chatWidget = {
        toggle: document.getElementById('chatToggle'),
        panel: document.getElementById('chatPanel'),
        closeBtn: document.getElementById('chatClose'),
        clearHistoryBtn: document.getElementById('clearHistoryBtn'),
        form: document.getElementById('chatWidgetForm'),
        input: document.getElementById('chatWidgetInput'),
        sendBtn: document.getElementById('chatWidgetSendBtn'),
        messagesContainer: document.getElementById('chatMessagesContainer'),
        loader: document.getElementById('chatLoader'),
        unreadBadge: document.getElementById('unreadBadge'),
        
        sessionId: null,
        messageHistory: [],
        isOpen: false,

        init() {
            this.toggle.addEventListener('click', () => this.toggleChat());
            this.closeBtn.addEventListener('click', () => this.close());
            this.clearHistoryBtn.addEventListener('click', () => this.clearHistory());
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            this.input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.form.dispatchEvent(new Event('submit'));
                }
            });

            // Cargar historial al inicializar
            this.loadHistory();
        },

        async loadHistory() {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) return;

                const response = await fetch('/api/chat/history', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const data = await response.json();
                
                if (data.success && data.data.messages.length > 0) {
                    this.sessionId = data.data.session_id;
                    this.messageHistory = data.data.messages;
                    
                    // Limpiar mensajes excepto el de bienvenida
                    this.messagesContainer.innerHTML = '';
                    
                    // Agregar mensajes del historial
                    data.data.messages.forEach(msg => {
                        this.addMessage(msg.content, msg.role === 'user' ? 'user' : 'system', false);
                    });
                }
            } catch (error) {
                console.error('Error cargando historial:', error);
            }
        },

        async clearHistory() {
            if (!confirm('¿Estás seguro de que deseas limpiar todo el historial de conversación?')) {
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) return;

                const response = await fetch('/api/chat/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ session_id: this.sessionId }),
                });

                const data = await response.json();
                
                if (data.success) {
                    // Limpiar mensajes visibles (excepto bienvenida)
                    this.messagesContainer.innerHTML = `
                        <div class="message system-message">
                            <div class="message-content">
                                ¡Hola! 👋 Soy tu asistente de base de datos. Puedo ayudarte con preguntas sobre:<br><br>
                                • <strong>Estudiantes</strong> - información, promedios, rendimiento<br>
                                • <strong>Materias</strong> - cursos, profesores, inscritos<br>
                                • <strong>Calificaciones</strong> - notas, estadísticas, distribución<br>
                                • <strong>Inscripciones</strong> - estados, actividad reciente<br>
                                • <strong>Auditoría</strong> - cambios recientes en el sistema<br><br>
                                ¿En qué puedo ayudarte?
                            </div>
                        </div>
                    `;
                    this.messageHistory = [];
                    this.sessionId = null;
                }
            } catch (error) {
                console.error('Error limpiando historial:', error);
            }
        },

        toggleChat() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },

        open() {
            this.panel.classList.add('open');
            this.isOpen = true;
            this.input.focus();
            this.unreadBadge.style.display = 'none';
            
            // Scroll al final
            setTimeout(() => {
                this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
            }, 100);
        },

        close() {
            this.panel.classList.remove('open');
            this.isOpen = false;
        },

        async handleSubmit(e) {
            e.preventDefault();

            const question = this.input.value.trim();
            if (!question) return;

            // Agregar mensaje del usuario
            this.addMessage(question, 'user');
            this.input.value = '';

            // Mostrar loader
            this.loader.style.display = 'flex';
            this.sendBtn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    throw new Error('Token CSRF no encontrado');
                }

                const response = await fetch('/api/chat/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ 
                        question,
                        session_id: this.sessionId,
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    const errorMsg = errorData.error || `Error del servidor (${response.status})`;
                    throw new Error(errorMsg);
                }

                const data = await response.json();

                if (data.success && data.response) {
                    this.addMessage(data.response, 'system');
                    
                    // Guardar session_id
                    if (data.session_id) {
                        this.sessionId = data.session_id;
                    }
                    
                    // Mostrar badge si el chat está cerrado
                    if (!this.isOpen) {
                        this.showUnreadBadge();
                    }
                } else if (data.error) {
                    this.addMessage(`❌ Error: ${data.error}`, 'system');
                } else {
                    this.addMessage('❌ Error: Respuesta inválida del servidor', 'system');
                }
            } catch (error) {
                console.error('Error en el chat:', error);
                this.addMessage(`❌ Error de red: ${error.message}`, 'system');
            } finally {
                this.loader.style.display = 'none';
                this.sendBtn.disabled = false;
                this.input.focus();
            }
        },

        addMessage(content, type = 'system', animate = true) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}-message`;
            if (animate) {
                messageDiv.style.animation = 'fadeIn 0.3s ease-out';
            }

            const contentWrapper = document.createElement('div');
            contentWrapper.className = 'message-content-wrapper';

            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';

            if (!content) {
                content = '(Sin respuesta)';
            }

            // Formateo de markdown básico
            let formatted = String(content)
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/`(.*?)`/g, '<code style="background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 4px; font-size: 13px;">$1</code>')
                .replace(/•/g, '•')
                .replace(/\n/g, '<br>');

            contentDiv.innerHTML = formatted;
            contentWrapper.appendChild(contentDiv);

            // Agregar timestamp
            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.textContent = new Date().toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            contentWrapper.appendChild(timeDiv);

            messageDiv.appendChild(contentWrapper);
            this.messagesContainer.appendChild(messageDiv);
            
            // Auto-scroll al final
            setTimeout(() => {
                this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
            }, 50);
        },

        showUnreadBadge() {
            const unreadCount = this.messageHistory.filter(m => m.role === 'assistant').length;
            if (unreadCount > 0 && !this.isOpen) {
                this.unreadBadge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                this.unreadBadge.style.display = 'flex';
            }
        },
    };

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', () => chatWidget.init());
</script>
