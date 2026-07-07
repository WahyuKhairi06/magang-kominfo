@include('navbar')

<!-- ================= CHATBOT SECTION ================= -->
<section class="min-h-screen bg-slate-50 pt-28 pb-12 flex flex-col items-center">
    
    <!-- HEADER -->
    <div class="w-full max-w-4xl px-4 md:px-6 mb-6">
        <div class="text-center reveal-up">
            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-primary mb-3">
                <span class="w-6 h-px bg-primary"></span> Asisten Virtual Terpadu
            </span>
            <h1 class="font-serif text-3xl md:text-4xl text-secondary mb-3">Chat Bot Puskesmas</h1>
            <p class="text-muted text-sm max-w-xl mx-auto">
                Silakan tanyakan informasi seputar layanan kesehatan, jadwal dokter, atau panduan pengaduan. Asisten virtual kami siap membantu Anda 24/7.
            </p>
        </div>
    </div>

    <!-- CHAT INTERFACE -->
    <div class="w-full max-w-4xl px-4 md:px-6 flex-grow flex flex-col reveal-up">
        <div class="flex-grow flex flex-col bg-white rounded-2xl shadow-sm border border-border overflow-hidden h-[600px] max-h-[70vh]">
            
            <!-- Chat Area -->
            <div id="chat-messages" class="flex-grow overflow-y-auto p-6 space-y-6 bg-slate-50/50">
                
                <!-- Bot Message (Welcome) -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">smart_toy</span>
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                        <p class="text-secondary text-[15px] leading-relaxed">
                            Halo! Saya adalah Asisten Virtual Puskesmas Marunggi. Ada yang bisa saya bantu hari ini?
                        </p>
                    </div>
                </div>

                <!-- Example User Message -->
                <div class="flex items-start gap-4 flex-row-reverse">
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-white text-[20px]">person</span>
                    </div>
                    <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                        <p class="text-[15px] leading-relaxed">
                            Jam berapa layanan poli gigi buka besok?
                        </p>
                    </div>
                </div>

                <!-- Example Bot Response -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">smart_toy</span>
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%]">
                        <p class="text-secondary text-[15px] leading-relaxed">
                            Layanan Poli Gigi buka setiap hari <strong>Senin - Sabtu</strong> mulai pukul <strong>08.00 WIB hingga 14.00 WIB</strong>. Pastikan Anda membawa kartu berobat atau BPJS Kesehatan saat mendaftar.
                        </p>
                    </div>
                </div>
                
                <!-- Typing Indicator (Hidden by default) -->
                <div id="typing-indicator" class="hidden items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">smart_toy</span>
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
                        class="w-full bg-surface border-transparent focus:border-primary focus:ring-0 rounded-full px-5 py-3.5 text-[15px] text-secondary placeholder-muted transition-colors"
                        placeholder="Ketik pertanyaan Anda di sini..."
                        autocomplete="off"
                    >
                    <button type="submit" class="w-12 h-12 rounded-full bg-primary text-white hover:bg-secondary transition-all shadow-md flex items-center justify-center shrink-0" title="Kirim Pesan">
                        <span class="material-symbols-outlined ml-1">send</span>
                    </button>
                </form>
            </div>
            
        </div>
        <div class="text-center mt-4">
            <p class="text-[11px] text-muted font-medium">Asisten virtual AI ini dapat membuat kesalahan. Harap periksa kembali informasi medis atau hubungi petugas kami secara langsung.</p>
        </div>
    </div>

</section>

@include('footer')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const typingIndicator = document.getElementById('typing-indicator');

        // Fungsi untuk scroll ke bawah
        const scrollToBottom = () => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };

        // Fungsi menambahkan pesan pengguna
        const addUserMessage = (text) => {
            const html = `
                <div class="flex items-start gap-4 flex-row-reverse animate-fade-in-up" style="animation-duration: 0.3s">
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-white text-[20px]">person</span>
                    </div>
                    <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%] break-words">
                        <p class="text-[15px] leading-relaxed">${text}</p>
                    </div>
                </div>
            `;
            chatMessages.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
        };

        // Fungsi menambahkan pesan bot
        const addBotMessage = (text) => {
            const html = `
                <div class="flex items-start gap-4 animate-fade-in-up" style="animation-duration: 0.3s">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary text-[20px]">smart_toy</span>
                    </div>
                    <div class="bg-white border border-border rounded-2xl rounded-tl-sm px-5 py-3.5 shadow-sm max-w-[85%] sm:max-w-[75%] break-words">
                        <p class="text-secondary text-[15px] leading-relaxed">${text}</p>
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

            // 1. Tampilkan pesan user
            addUserMessage(message);
            chatInput.value = '';
            
            // 2. Pindahkan typing indicator ke paling bawah & tampilkan
            chatMessages.appendChild(typingIndicator);
            typingIndicator.classList.remove('hidden');
            typingIndicator.classList.add('flex');
            scrollToBottom();

            // 3. Simulasi balasan bot (Bisa dihubungkan dengan API backend nanti)
            setTimeout(() => {
                addBotMessage("Maaf, saat ini saya sedang dalam tahap pengembangan dan belum dapat merespons pertanyaan Anda secara real-time. Silakan gunakan menu Pengaduan atau hubungi nomor telepon kami.");
            }, 1500);
        });
    });
</script>
