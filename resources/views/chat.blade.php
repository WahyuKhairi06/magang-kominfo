@include('navbar')

@php
    // Ambil setting chatbot (fallback ke default jika belum ada)
    $aiName = $chatbotSetting->ai_name ?? 'Asisten Puskesmas';
    $puskesmasName = $chatbotSetting->puskesmas_display_name ?? 'Puskesmas Marunggi';
    $greeting = $chatbotSetting->greeting_message ?? 'Halo! Saya adalah Asisten Virtual Puskesmas. Ada yang bisa saya bantu hari ini?';
    $primaryColor = $chatbotSetting->primary_color ?? '#1e6b4d';
    $logoChatbot = isset($chatbotSetting->logo_chatbot) && $chatbotSetting->logo_chatbot ? asset($chatbotSetting->logo_chatbot) : null;
    $chatbotStatus = $chatbotSetting->status ?? 'active';

    // Helper untuk menentukan warna teks contrast (hitam/putih) berdasarkan primary color
    function getContrastColor($hexColor) {
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
    $primaryTextColor = getContrastColor($primaryColor);
@endphp

{{-- Inject dynamic primary color from chatbot_settings --}}
<style>
    .chat-primary { background-color: {{ $primaryColor }}; color: {{ $primaryTextColor }}; }
    .chat-primary-text { color: {{ $primaryColor }}; }
    .chat-primary-text-contrast { color: {{ $primaryTextColor }}; }
    .chat-primary-bg-10 { background-color: {{ $primaryColor }}1a; }
    .chat-primary-border { border-color: {{ $primaryColor }}; }
    .chat-send-btn:hover { background-color: {{ $primaryColor }}dd; }
    #chat-input:focus {
        border-color: {{ $primaryColor }} !important;
        box-shadow: 0 0 0 2px {{ $primaryColor }}40 !important;
    }
</style>

<!-- ================= CHATBOT SECTION ================= -->
<section class="min-h-screen bg-slate-50 pt-28 pb-12 flex flex-col items-center">
    
    @if($chatbotStatus === 'inactive')
    {{-- Chatbot Nonaktif --}}
    <div class="w-full max-w-4xl px-4 md:px-6 flex-grow flex flex-col items-center justify-center">
        <div class="text-center py-16">
            <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-slate-400 text-4xl">smart_toy</span>
            </div>
            <h2 class="text-2xl font-bold text-slate-700 mb-2">Chatbot Sedang Tidak Aktif</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto">
                Layanan asisten virtual {{ $puskesmasName }} sedang dalam pemeliharaan. Silakan coba beberapa saat lagi atau hubungi kami langsung.
            </p>
        </div>
    </div>
    @else

    <!-- HEADER -->
    <div class="w-full max-w-4xl px-4 md:px-6 mb-6">
        <div class="text-center reveal-up">
            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] mb-3 chat-primary-text">
                <span class="w-6 h-px chat-primary"></span> Asisten Virtual Terpadu
            </span>
            <h1 class="font-serif text-3xl md:text-4xl chat-primary-text mb-3">{{ $aiName }}</h1>
            <p class="text-muted text-sm max-w-xl mx-auto">
                Silakan tanyakan informasi seputar layanan kesehatan, jadwal dokter, atau panduan pengaduan. Asisten virtual {{ $puskesmasName }} siap membantu Anda 24/7.
            </p>
        </div>
    </div>

    <!-- CHAT INTERFACE -->
    <div class="w-full max-w-4xl px-4 md:px-6 flex-grow flex flex-col reveal-up">
        <div class="flex-grow flex flex-col bg-white rounded-2xl shadow-sm border border-border overflow-hidden h-[600px] max-h-[70vh]">
            
            {{-- Chat Header Bar --}}
            <div class="px-5 py-3 flex items-center gap-3 chat-primary">
                <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center overflow-hidden">
                    @if($logoChatbot)
                        <img src="{{ $logoChatbot }}" alt="{{ $aiName }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-lg chat-primary-text-contrast" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm leading-tight chat-primary-text-contrast">{{ $aiName }}</h4>
                    <p class="text-[10px] opacity-80 chat-primary-text-contrast">{{ $puskesmasName }}</p>
                </div>
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-300 animate-pulse shadow-sm"></span>
                    <span class="text-[10px] font-medium chat-primary-text-contrast">Online</span>
                </span>
            </div>

            <!-- Chat Area -->
            <div id="chat-messages" class="flex-grow overflow-y-auto p-6 space-y-6 bg-slate-50/50">
                
                <!-- Bot Message (Welcome) -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full chat-primary-bg-10 flex items-center justify-center shrink-0 overflow-hidden">
                        @if($logoChatbot)
                            <img src="{{ $logoChatbot }}" alt="{{ $aiName }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined chat-primary-text text-[20px]">smart_toy</span>
                        @endif
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                        <p class="text-slate-700 text-[15px] leading-relaxed">
                            {{ $greeting }}
                        </p>
                    </div>
                </div>

                <!-- Example User Message -->
                <div class="flex items-start gap-4 flex-row-reverse">
                    <div class="w-10 h-10 rounded-full chat-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px] chat-primary-text-contrast">person</span>
                    </div>
                    <div class="rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%] chat-primary">
                        <p class="text-[15px] leading-relaxed chat-primary-text-contrast">
                            Jam berapa layanan poli gigi buka besok?
                        </p>
                    </div>
                </div>

                <!-- Example Bot Response -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full chat-primary-bg-10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined chat-primary-text text-[20px]">smart_toy</span>
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                        <p class="text-slate-700 text-[15px] leading-relaxed">
                            Layanan Poli Gigi buka setiap hari <strong>Senin - Sabtu</strong> mulai pukul <strong>08.00 WIB hingga 14.00 WIB</strong>. Pastikan Anda membawa kartu berobat atau BPJS Kesehatan saat mendaftar.
                        </p>
                    </div>
                </div>
                
                <!-- Typing Indicator (Hidden by default) -->
                <div id="typing-indicator" class="hidden items-center gap-4">
                    <div class="w-10 h-10 rounded-full chat-primary-bg-10 flex items-center justify-center shrink-0 overflow-hidden">
                        @if($logoChatbot)
                            <img src="{{ $logoChatbot }}" alt="{{ $aiName }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined chat-primary-text text-[20px]">smart_toy</span>
                        @endif
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-4 shadow-sm">
                        <div class="flex gap-1.5">
                            <div class="w-2 h-2 rounded-full bg-muted animate-bounce" style="animation-delay: 0s"></div>
                            <div class="w-2 h-2 rounded-full bg-muted animate-bounce" style="animation-delay: 0.15s"></div>
                            <div class="w-2 h-2 rounded-full bg-muted animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-border">
                <form id="chat-form" class="relative flex items-center gap-3">
                    <button type="button" class="w-10 h-10 rounded-full text-muted hover:bg-surface hover:text-secondary transition-colors flex items-center justify-center shrink-0" title="Lampirkan File (Opsional)">
                        <span class="material-symbols-outlined">attach_file</span>
                    </button>
                    <input 
                        type="text" 
                        id="chat-input"
                        class="w-full bg-surface border-transparent focus:ring-0 rounded-full px-5 py-3.5 text-[15px] text-slate-800 placeholder-muted transition-colors"
                        style="--tw-ring-color: {{ $primaryColor }}40;"
                        placeholder="Ketik pertanyaan Anda di sini..."
                        autocomplete="off"
                    >
                    <button type="submit" class="w-12 h-12 rounded-full hover:opacity-90 transition-all shadow-md flex items-center justify-center shrink-0 chat-primary chat-send-btn" title="Kirim Pesan">
                        <span class="material-symbols-outlined ml-1 chat-primary-text-contrast">send</span>
                    </button>
                </form>
            </div>
            
        </div>
        <div class="text-center mt-4">
            <p class="text-[11px] text-muted font-medium">Asisten virtual AI ini dapat membuat kesalahan. Harap periksa kembali informasi medis atau hubungi petugas kami secara langsung.</p>
        </div>
    </div>

    @endif

</section>

@include('footer')

<script>
    // Pass chatbot config to JS for dynamic bot messages
    const CHATBOT_CONFIG = {
        aiName: @json($aiName),
        primaryColor: @json($primaryColor),
        logoChatbot: @json($logoChatbot),
    };

    document.addEventListener('DOMContentLoaded', () => {
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');

        if (!chatForm || !chatInput || !chatMessages) return; // Guard for inactive state

        // Scroll to bottom
        const scrollToBottom = () => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };

        // Add user message
        const addUserMessage = (text) => {
            const html = `
                <div class="flex items-start gap-4 flex-row-reverse animate-fade-in-up" style="animation-duration: 0.3s">
                    <div class="w-10 h-10 rounded-full chat-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px] chat-primary-text-contrast">person</span>
                    </div>
                    <div class="rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%] chat-primary break-words">
                        <p class="text-[15px] leading-relaxed chat-primary-text-contrast">${text}</p>
                    </div>
                </div>
            `;
            chatMessages.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        };

        // Add bot message
        const addBotMessage = (text) => {
            const avatarHtml = CHATBOT_CONFIG.logoChatbot
                ? `<img src="${CHATBOT_CONFIG.logoChatbot}" alt="${CHATBOT_CONFIG.aiName}" class="w-full h-full object-cover">`
                : `<span class="material-symbols-outlined chat-primary-text text-[20px]">smart_toy</span>`;

            const html = `
                <div class="flex items-start gap-4 animate-fade-in-up" style="animation-duration: 0.3s">
                    <div class="w-10 h-10 rounded-full chat-primary-bg-10 flex items-center justify-center shrink-0 overflow-hidden">
                        ${avatarHtml}
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%] break-words">
                        <p class="text-slate-700 text-[15px] leading-relaxed">${text}</p>
                    </div>
                </div>
            `;
            typingIndicator.classList.remove('flex');
            typingIndicator.classList.add('hidden');
            chatMessages.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        };

        // Handle Submit
        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            addUserMessage(message);
            chatInput.value = '';
            
            chatMessages.appendChild(typingIndicator);
            typingIndicator.classList.remove('hidden');
            typingIndicator.classList.add('flex');
            scrollToBottom();

            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    addBotMessage(data.answer);
                } else {
                    addBotMessage("Maaf, terjadi kesalahan: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                addBotMessage("Maaf, gagal terhubung ke asisten virtual saat ini. Silakan coba beberapa saat lagi.");
            });
        });
    });
</script>
