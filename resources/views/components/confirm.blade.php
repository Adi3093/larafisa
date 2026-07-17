<div x-data="{
    isOpen: false,
    isConfirmed: false,
    isProcessing: false,
    title: '',
    message: '',
    confirmText: '',
    actionTarget: '',
    confirmBtnClass: 'bg-amber-600',

    open(detail) {
        this.title = detail.title || 'Konfirmasi';
        this.message = detail.message || 'Apakah Anda yakin?';
        this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
        this.actionTarget = detail.target;

        if (detail.theme === 'danger') {
            this.confirmBtnClass = 'bg-red-600 hover:bg-red-700 focus:ring-red-300 shadow-red-600/30';
        } else if (detail.theme === 'emerald') {
            this.confirmBtnClass = 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-300 shadow-emerald-600/30';
        } else {
            this.confirmBtnClass = 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-300 shadow-amber-600/30';
        }

        this.isConfirmed = false;
        this.isProcessing = false;
        this.isOpen = true;
    },
    close() {
        if (this.isProcessing) return;
        this.isOpen = false;
    },
    confirm() {
        this.isProcessing = true;
        this.isConfirmed = true;
        setTimeout(() => {
            if (this.actionTarget) {
                document.getElementById(this.actionTarget).submit();
            }
            this.isOpen = false;
        }, 800);
    }
}" x-show="isOpen" x-cloak @open-confirm.window="open($event.detail)" style="z-index: 999999;"
    class="fixed inset-0 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/60 backdrop-blur-sm">

    <div x-show="isOpen" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
        class="relative p-4 w-full max-w-md z-10">

        <div
            class="relative bg-white border border-amber-200 rounded-3xl shadow-2xl p-6 md:p-8 text-center overflow-hidden">

            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-full -z-10"></div>

            <button type="button" @click="close()" :disabled="isProcessing"
                class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-amber-50 hover:text-amber-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6" />
                </svg>
            </button>

            <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                <div x-show="!isConfirmed" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-50"
                    class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2 ring-red-100">
                        <svg class="text-red-500 w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>

                <div x-show="isConfirmed" x-transition:enter="transition ease-out duration-500 delay-100"
                    x-transition:enter-start="opacity-0 scale-0 rotate-[-45deg]"
                    x-transition:enter-end="opacity-100 scale-100 rotate-0"
                    class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm ring-2 ring-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-600" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M10.5 15.25A.74.74 0 0 1 10 15l-3-3a.75.75 0 0 1 1-1l2.47 2.47L19 5a.75.75 0 0 1 1-1l-9 9a.74.74 0 0 1-.5.25Z" />
                            <path fill="currentColor"
                                d="M12 21a9 9 0 0 1-7.87-4.66a8.67 8.67 0 0 1-1.07-3.41a9 9 0 0 1 4.6-8.81a8.67 8.67 0 0 1 3.41-1.07a8.86 8.86 0 0 1 3.55.34a.75.75 0 1 1-.43 1.43a7.62 7.62 0 0 0-3-.28a7.43 7.43 0 0 0-2.84.89a7.5 7.5 0 0 0-2.2 1.84a7.42 7.42 0 0 0-1.64 5.51a7.43 7.43 0 0 0 .89 2.84a7.5 7.5 0 0 0 1.84 2.2a7.42 7.42 0 0 0 5.51 1.64a7.43 7.43 0 0 0 2.84-.89a7.5 7.5 0 0 0 2.2-1.84a7.42 7.42 0 0 0 1.64-5.51a.75.75 0 1 1 1.57-.15a9 9 0 0 1-4.61 8.81A8.67 8.67 0 0 1 12.93 21H12Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <h3 class="mb-2 text-xl md:text-2xl font-black text-amber-950" x-text="title"></h3>
            <p class="mb-8 text-sm text-gray-500 font-medium leading-relaxed" x-text="message"></p>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-center gap-3 w-full">
                <button type="button" @click="close()" :disabled="isProcessing"
                    class="w-full sm:w-auto text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-100 font-bold rounded-xl text-sm px-6 py-3 transition shadow-sm">
                    Batal
                </button>
                <button type="button" @click="confirm()" :disabled="isProcessing" :class="confirmBtnClass"
                    class="w-full sm:w-auto text-white focus:ring-4 focus:outline-none font-bold rounded-xl text-sm px-6 py-3 transition shadow-md flex items-center justify-center gap-2">
                    <span x-text="confirmText"></span>
                    <svg x-show="isProcessing && !isConfirmed" class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
