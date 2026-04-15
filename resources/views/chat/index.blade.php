@extends('layouts.app')

@section('title', 'Database Chat AI')

@section('content')
<div class="container-fluid p-0 h-100">
    <div class="page-header animate-fade-in-up">
        <div>
            <h1 class="page-title">🤖 Database AI Chat</h1>
            <p class="page-subtitle">Ask questions about students, courses, and grades</p>
        </div>
    </div>

    <div class="chat-container">
        <!-- Chat Messages Area -->
        <div class="chat-messages" id="chatMessages">
            <div class="message system-message">
                <div class="message-content">
                    <strong>AI Assistant:</strong> Hello! I'm your database AI assistant. I can help you with questions about students, courses, grades, and enrollment data. What would you like to know?
                </div>
            </div>
        </div>

        <!-- Chat Input Area -->
        <div class="chat-input-area">
            @if(!$isConfigured)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>⚠️ Configuration Required:</strong> GROQ_API_KEY is not set in .env file. 
                    <br>Please add your Groq API key to continue.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="chatForm" class="d-flex gap-2">
                <input 
                    type="text" 
                    id="questionInput" 
                    class="form-control" 
                    placeholder="Ask something... (e.g., 'How many students do we have?', 'What's the average grade?')"
                    {{ !$isConfigured ? 'disabled' : '' }}
                    autocomplete="off"
                />
                <button 
                    type="submit" 
                    class="btn btn-primary"
                    id="sendBtn"
                    {{ !$isConfigured ? 'disabled' : '' }}
                >
                    <span id="sendBtnText">Send</span>
                    <span id="sendBtnLoader" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 200px);
        gap: 20px;
        padding: 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .message {
        display: flex;
        animation: fadeIn 0.3s ease-in;
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
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 8px;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .user-message .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 2px;
    }

    .system-message .message-content {
        background: #f0f0f0;
        color: #333;
        border-bottom-left-radius: 2px;
    }

    .system-message.loading .message-content {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .system-message.loading .spinner-border {
        width: 16px;
        height: 16px;
    }

    .chat-input-area {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-input-area form {
        display: flex;
        gap: 10px;
    }

    .chat-input-area input {
        border: 2px solid #e0e0e0;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .chat-input-area input:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .chat-input-area button {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 100px;
    }

    .chat-input-area button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .message-timestamp {
        font-size: 12px;
        color: #999;
        margin-top: 4px;
    }

    .error-message {
        color: #dc3545;
        padding: 12px;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        margin-top: 10px;
    }

    code {
        background: #f5f5f5;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const questionInput = document.getElementById('questionInput');
    const sendBtn = document.getElementById('sendBtn');
    const sendBtnText = document.getElementById('sendBtnText');
    const sendBtnLoader = document.getElementById('sendBtnLoader');

    // Enviar pregunta
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const question = questionInput.value.trim();
        if (!question) return;

        // Agregar mensaje del usuario
        addMessage(question, 'user');
        questionInput.value = '';
        questionInput.focus();

        // Mostrar loader
        sendBtn.disabled = true;
        sendBtnText.style.display = 'none';
        sendBtnLoader.style.display = 'inline-block';

        try {
            const response = await fetch('/api/chat/ask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ question }),
            });

            const data = await response.json();

            if (data.success) {
                addMessage(data.response, 'system');
            } else {
                addMessage(`❌ Error: ${data.error}`, 'system', true);
            }
        } catch (error) {
            addMessage(`❌ Network error: ${error.message}`, 'system', true);
        } finally {
            sendBtn.disabled = false;
            sendBtnText.style.display = 'inline';
            sendBtnLoader.style.display = 'none';
        }
    });

    // Agregar mensaje al chat
    function addMessage(content, type = 'system', isError = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        
        // Formatear el contenido (soporte básico para Markdown)
        let formattedContent = content
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');

        contentDiv.innerHTML = formattedContent;
        
        if (isError) {
            contentDiv.classList.add('error-message');
        }

        messageDiv.appendChild(contentDiv);

        const timestamp = document.createElement('div');
        timestamp.className = 'message-timestamp';
        timestamp.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        messageDiv.appendChild(timestamp);

        chatMessages.appendChild(messageDiv);

        // Scroll al último mensaje
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Soporte para Enter para enviar (Shift+Enter para nueva línea)
    questionInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    // Focus en el input al cargar
    questionInput.focus();
</script>
@endsection
