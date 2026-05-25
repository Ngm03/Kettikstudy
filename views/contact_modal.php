<!-- Contact Modal -->
<div id="contact-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0" id="contact-modal-backdrop" onclick="closeContactModal()"></div>
    
    <!-- Modal Content -->
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 mx-4" id="contact-modal-content">
        <!-- Header -->
        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-b border-blue-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Связь со специалистом</h3>
            <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-full hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-8">
            <p class="text-gray-600 mb-6">Пожалуйста, выберите наиболее удобный для вас способ связи:</p>
            
            <div class="space-y-4">
                <!-- Option 1: AI (Fast) -->
                <button onclick="contactViaAI()" class="w-full group relative flex flex-col p-5 border-2 border-blue-500 rounded-2xl bg-blue-50/50 hover:bg-blue-50 transition-all duration-200 shadow-sm hover:shadow-md text-left cursor-pointer">
                    <div class="flex items-center justify-between mb-2 w-full">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shadow-inner shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="font-bold text-gray-900 text-lg">Быстрый вопрос AI-эксперту</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold whitespace-nowrap">
                            Ответ за 2 сек
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 ml-13 pl-13">Моментальный подбор вуза, расчет шансов и ответы на вопросы без ожидания.</p>
                </button>
                
                <!-- Option 2: Human (Slow) -->
                <button onclick="contactViaManager()" class="w-full group flex flex-col p-5 border border-gray-200 rounded-2xl hover:border-gray-300 hover:bg-gray-50 transition-all duration-200 text-left cursor-pointer">
                    <div class="flex items-center justify-between mb-2 w-full">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 group-hover:text-gray-700 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <span class="font-semibold text-gray-700">Заказать звонок менеджера</span>
                        </div>
                        <span class="text-xs text-gray-400 font-medium whitespace-nowrap">
                            Ожидание: ~2-3 часа
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 ml-13 pl-13">Оставьте контакты, и наш специалист свяжется с вами в порядке очереди.</p>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openContactModal(e) {
    if(e) e.preventDefault();
    const modal = document.getElementById('contact-modal');
    const backdrop = document.getElementById('contact-modal-backdrop');
    const content = document.getElementById('contact-modal-content');
    
    modal.classList.remove('hidden');
    // Trigger reflow
    void modal.offsetWidth;
    
    backdrop.classList.remove('opacity-0');
    backdrop.classList.add('opacity-100');
    
    content.classList.remove('opacity-0', 'scale-95');
    content.classList.add('opacity-100', 'scale-100');
}

function closeContactModal() {
    const backdrop = document.getElementById('contact-modal-backdrop');
    const content = document.getElementById('contact-modal-content');
    
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    
    content.classList.remove('opacity-100', 'scale-100');
    content.classList.add('opacity-0', 'scale-95');
    
    setTimeout(() => {
        document.getElementById('contact-modal').classList.add('hidden');
    }, 300);
}

function contactViaAI() {
    closeContactModal();
    const chatBtn = document.querySelector('#chat-toggle-btn');
    if (chatBtn) {
        const widget = document.getElementById('chat-widget');
        if (widget && !widget.classList.contains('open')) {
            chatBtn.click();
        }
    }
}

function contactViaManager() {
    closeContactModal();
    const chatBtn = document.querySelector('#chat-toggle-btn');
    if (chatBtn) {
        const widget = document.getElementById('chat-widget');
        if (widget && !widget.classList.contains('open')) {
            chatBtn.click();
        }
        setTimeout(() => {
            const input = document.getElementById('chat-input');
            const sendBtn = document.getElementById('chat-send');
            if (input && sendBtn) {
                input.value = "Хочу поговорить с менеджером";
                sendBtn.click();
            }
        }, 500);
    }
}
</script>
