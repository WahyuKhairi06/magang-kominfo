@php
    $chatbotSetting = \Illuminate\Support\Facades\DB::table('chatbot_settings')->first();
    $aiName = $chatbotSetting->ai_name ?? 'Asisten Puskesmas';
    $puskesmasName = $chatbotSetting->puskesmas_display_name ?? 'Puskesmas Marunggi';
    $defaultGreeting = "Halo! Saya adalah **" . $aiName . "**, asisten virtual resmi Puskesmas **" . $puskesmasName . "**. Saya siap membantu Anda mendapatkan informasi seputar layanan Puskesmas **" . $puskesmasName . "**.\n\nSebagai AI Assistant yang dikembangkan membantu masyarakat mencari informasi resmi seputar Puskesmas **" . $puskesmasName . "**. Saya bukan manusia dan bukan tenaga medis, sehingga tidak dapat melakukan diagnosis penyakit atau memberikan resep obat.\n\nAda yang bisa saya bantu terkait layanan Puskesmas **" . $puskesmasName . "**?";
    $greeting = $chatbotSetting->greeting_message ?? $defaultGreeting;
    $primaryColor = $chatbotSetting->primary_color ?? '#2D6A4F';
    $logoChatbot = isset($chatbotSetting->logo_chatbot) && $chatbotSetting->logo_chatbot ? asset($chatbotSetting->logo_chatbot) : null;
    $chatbotStatus = $chatbotSetting->status ?? 'active';

    if (!function_exists('getContrastColorWidget')) {
        function getContrastColorWidget($hexColor) {
            $hexColor = str_replace('#', '', $hexColor);
            if (strlen($hexColor) == 3) {
                $hexColor = str_repeat(substr($hexColor,0,1), 2) . str_repeat(substr($hexColor,1,1), 2) . str_repeat(substr($hexColor,2,1), 2);
            }
            $r = hexdec(substr($hexColor, 0, 2));
            $g = hexdec(substr($hexColor, 2, 2));
            $b = hexdec(substr($hexColor, 4, 2));
            $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
            return ($yiq >= 128) ? '#0f172a' : '#ffffff'; // slate-900 or white
        }
    }
    $primaryTextColor = getContrastColorWidget($primaryColor);
@endphp

@if($chatbotStatus !== 'inactive')
{{-- Style Injection --}}
<style>
    .chat-widget-primary { background-color: {{ $primaryColor }} !important; color: {{ $primaryTextColor }} !important; }
    .chat-widget-primary-text { color: {{ $primaryColor }} !important; }
    .chat-widget-primary-text-contrast { color: {{ $primaryTextColor }} !important; }
    .chat-widget-primary-bg-10 { background-color: {{ $primaryColor }}1a !important; }
    .chat-widget-primary-border { border-color: {{ $primaryColor }} !important; }
    .chat-widget-send-btn:hover { background-color: {{ $primaryColor }}dd !important; }
    
    #chatbot-widget-input:focus {
        border-color: {{ $primaryColor }} !important;
        box-shadow: 0 0 0 2px {{ $primaryColor }}40 !important;
    }

    /* Custom thin scrollbar */
    .chatbot-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .chatbot-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .chatbot-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(156, 163, 175, 0.3);
        border-radius: 9999px;
    }
    .chatbot-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: rgba(156, 163, 175, 0.5);
    }
</style>

<!-- ================= CHATBOT WIDGET CONTAINER ================= -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 pointer-events-none">
    
    <!-- Tooltip / Nudge message -->
    <div id="chatbot-widget-tooltip" class="bg-white text-slate-800 border border-slate-100 shadow-2xl px-4 py-3 rounded-2xl text-xs font-semibold mr-2 max-w-xs transition-all duration-500 opacity-0 scale-95 origin-bottom-right translate-y-2 flex items-center gap-2">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
        </span>
        <span>Ada yang bisa {{ $aiName }} bantu?</span>
    </div>

    <!-- Floating Action Button (FAB) -->
    <button id="chatbot-widget-fab" class="w-14 h-14 rounded-full flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 relative group pointer-events-auto chat-widget-primary focus:outline-none" title="Tanya Asisten Virtual">
        <span id="chatbot-fab-icon" class="material-symbols-outlined text-2xl transition-transform duration-300 group-hover:rotate-6" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full animate-pulse shadow-sm"></span>
    </button>
</div>

<!-- Chat Window Pop-up -->
<div id="chatbot-widget-panel" class="fixed bottom-24 right-6 w-96 max-w-[calc(100vw-3rem)] h-[530px] max-h-[70vh] bg-white rounded-2xl shadow-2xl border border-slate-150 flex flex-col z-50 transition-all duration-300 transform scale-90 translate-y-4 opacity-0 pointer-events-none overflow-hidden">
    
    <!-- Header -->
    <div class="px-4 py-3 flex items-center justify-between shadow-sm chat-widget-primary">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-black/10 flex items-center justify-center overflow-hidden shrink-0">
                @if($logoChatbot)
                    <img src="{{ $logoChatbot }}" alt="{{ $aiName }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-lg chat-widget-primary-text-contrast" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                @endif
            </div>
            <div>
                <h4 class="font-bold text-xs leading-tight chat-widget-primary-text-contrast">{{ $aiName }}</h4>
                <p class="text-[9px] opacity-90 chat-widget-primary-text-contrast flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-300 animate-pulse"></span> Online
                </p>
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            <!-- Clear Chat -->
            <button id="chatbot-widget-clear" class="p-1 hover:bg-black/10 rounded transition-colors text-white focus:outline-none" title="Bersihkan Percakapan">
                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>
            <!-- Maximize -->
            <a href="{{ route('chat') }}" class="p-1 hover:bg-black/10 rounded transition-colors text-white flex items-center focus:outline-none" title="Tampilan Penuh">
                <span class="material-symbols-outlined text-[18px]">open_in_full</span>
            </a>
            <!-- Close -->
            <button id="chatbot-widget-close" class="p-1 hover:bg-black/10 rounded transition-colors text-white focus:outline-none" title="Tutup">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    </div>

    <!-- Message Display Area -->
    <div id="chatbot-widget-messages" class="flex-grow overflow-y-auto p-4 space-y-4 bg-slate-50/50 chatbot-scrollbar">
        <!-- Messages will be populated by JS -->
    </div>

    <!-- Input Area -->
    <div class="p-3 bg-white border-t border-slate-100">
        <form id="chatbot-widget-form" class="flex items-center gap-2">
            <input 
                type="text" 
                id="chatbot-widget-input"
                class="w-full bg-slate-50 border-transparent focus:border-slate-350 focus:bg-white focus:ring-0 rounded-full px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition-colors"
                placeholder="Ketik pesan..."
                autocomplete="off"
            >
            <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center hover:opacity-90 active:scale-95 shadow transition-all shrink-0 chat-widget-primary chat-widget-send-btn focus:outline-none" title="Kirim">
                <span class="material-symbols-outlined text-[18px] ml-0.5 chat-widget-primary-text-contrast">send</span>
            </button>
        </form>
    </div>

</div>

<!-- ================= CHATBOT LOGIC ================= -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fab = document.getElementById('chatbot-widget-fab');
        const panel = document.getElementById('chatbot-widget-panel');
        const closeBtn = document.getElementById('chatbot-widget-close');
        const clearBtn = document.getElementById('chatbot-widget-clear');
        const form = document.getElementById('chatbot-widget-form');
        const input = document.getElementById('chatbot-widget-input');
        const messagesContainer = document.getElementById('chatbot-widget-messages');
        const tooltip = document.getElementById('chatbot-widget-tooltip');
        const STORAGE_KEY = 'puskesmas_chatbot_messages';
        const aiName = @json($aiName);
        const puskesmasName = @json($puskesmasName);
        const logoChatbot = @json($logoChatbot);
        const primaryColor = @json($primaryColor);
        const greeting = @json(nl2br(e($greeting))).replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\*([^\*]+)\*/g, '<em>$1</em>');

        let isOpen = false;

        // Welcome message content
        const getWelcomeMessage = () => `${greeting}`;

        // Render functions
        const createMessageHTML = (sender, text) => {
            if (sender === 'user') {
                return `
                    <div class="flex items-start gap-2.5 flex-row-reverse animate-fade-in-up" style="animation-duration: 0.25s">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 chat-widget-primary shadow-sm text-xs">
                            <span class="material-symbols-outlined text-sm chat-widget-primary-text-contrast">person</span>
                        </div>
                        <div class="rounded-2xl rounded-tr-none px-4 py-2.5 shadow-sm max-w-[80%] chat-widget-primary break-words text-xs leading-relaxed">
                            <p>${text}</p>
                        </div>
                    </div>
                `;
            } else {
                const avatarHtml = logoChatbot
                    ? `<img src="${logoChatbot}" alt="${aiName}" class="w-full h-full object-cover">`
                    : `<span class="material-symbols-outlined chat-widget-primary-text text-[15px]">smart_toy</span>`;

                return `
                    <div class="flex items-start gap-2.5 animate-fade-in-up" style="animation-duration: 0.25s">
                        <div class="w-7 h-7 rounded-full chat-widget-primary-bg-10 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                            ${avatarHtml}
                        </div>
                        <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none px-4 py-2.5 shadow-sm max-w-[80%] break-words text-xs leading-relaxed text-slate-700">
                            <p>${text}</p>
                        </div>
                    </div>
                `;
            }
        };

        const createTypingIndicatorHTML = () => {
            const avatarHtml = logoChatbot
                ? `<img src="${logoChatbot}" alt="${aiName}" class="w-full h-full object-cover">`
                : `<span class="material-symbols-outlined chat-widget-primary-text text-[15px]">smart_toy</span>`;

            return `
                <div id="chatbot-widget-typing" class="flex items-start gap-2.5">
                    <div class="w-7 h-7 rounded-full chat-widget-primary-bg-10 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                        ${avatarHtml}
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                        <div class="flex gap-1">
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0s"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.15s"></div>
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>
                    </div>
                </div>
            `;
        };

        const loadMessages = () => {
            messagesContainer.innerHTML = '';
            const history = sessionStorage.getItem(STORAGE_KEY);
            
            if (history) {
                try {
                    const parsed = JSON.parse(history);
                    if (parsed && parsed.length > 0) {
                        parsed.forEach(msg => {
                            messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML(msg.sender, msg.text));
                        });
                        scrollToBottom();
                        return;
                    }
                } catch(e) {
                    console.error('Failed parsing chat history:', e);
                }
            }

            // Fallback default message
            messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML('bot', getWelcomeMessage()));
            scrollToBottom();
        };

        const saveMessage = (sender, text) => {
            let history = [];
            const raw = sessionStorage.getItem(STORAGE_KEY);
            if (raw) {
                try {
                    history = JSON.parse(raw);
                } catch(e) {}
            }
            history.push({ sender, text });
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(history));
        };

        const scrollToBottom = () => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        };

        // UI Event Handlers
        const toggleWidget = () => {
            isOpen = !isOpen;
            if (isOpen) {
                // Open panel
                panel.classList.remove('opacity-0', 'scale-90', 'translate-y-4', 'pointer-events-none');
                panel.classList.add('opacity-100', 'scale-100', 'translate-y-0', 'pointer-events-auto');
                
                // Hide tooltip if open
                hideTooltip();

                // Focus input and reload
                loadMessages();
                setTimeout(() => input.focus(), 100);
            } else {
                // Close panel
                panel.classList.add('opacity-0', 'scale-90', 'translate-y-4', 'pointer-events-none');
                panel.classList.remove('opacity-100', 'scale-100', 'translate-y-0', 'pointer-events-auto');
            }
        };

        const hideTooltip = () => {
            if (tooltip) {
                tooltip.classList.add('opacity-0', 'scale-95', 'translate-y-2');
                tooltip.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            }
        };

        // FAB Click
        fab.addEventListener('click', toggleWidget);
        closeBtn.addEventListener('click', () => { if (isOpen) toggleWidget(); });

        // Clear Chat Click
        clearBtn.addEventListener('click', () => {
            if (confirm('Bersihkan riwayat percakapan?')) {
                sessionStorage.removeItem(STORAGE_KEY);
                loadMessages();
            }
        });

        // Tooltip slide out nudge
        setTimeout(() => {
            if (tooltip && !sessionStorage.getItem('chatbot_widget_tooltip_shown')) {
                tooltip.classList.remove('opacity-0', 'scale-95', 'translate-y-2');
                tooltip.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                sessionStorage.setItem('chatbot_widget_tooltip_shown', 'true');
                
                // Auto hide tooltip after 6s
                setTimeout(hideTooltip, 6000);
            }
        }, 3000);

        // Form Submit
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = input.value.trim();
            if (!text) return;

            // Render & save user message
            messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML('user', text));
            saveMessage('user', text);
            input.value = '';
            scrollToBottom();

            // Show typing indicator
            messagesContainer.insertAdjacentHTML('beforeend', createTypingIndicatorHTML());
            scrollToBottom();

            // Send AJAX
            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: text })
            })
            .then(res => {
                if (!res.ok) throw new Error('API request failed');
                return res.json();
            })
            .then(data => {
                // Remove typing indicator
                const typingEl = document.getElementById('chatbot-widget-typing');
                if (typingEl) typingEl.remove();

                if (data.status === 'success') {
                    messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML('bot', data.answer));
                    saveMessage('bot', data.answer);
                } else {
                    const errMsg = "Maaf, terjadi kesalahan: " + (data.message || "Error");
                    messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML('bot', errMsg));
                    saveMessage('bot', errMsg);
                }
                scrollToBottom();
            })
            .catch(err => {
                const typingEl = document.getElementById('chatbot-widget-typing');
                if (typingEl) typingEl.remove();

                const errMsg = "Maaf, gagal terhubung ke asisten virtual saat ini. Silakan coba kembali.";
                messagesContainer.insertAdjacentHTML('beforeend', createMessageHTML('bot', errMsg));
                saveMessage('bot', errMsg);
                scrollToBottom();
            });
        });
    });
</script>
@endif
