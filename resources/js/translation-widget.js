/**
 * Translation Helper
 * Provides translation functionality with a chat icon UI
 */

console.log('Translation widget script loaded!');

class TranslationWidget {
    constructor() {
        this.isOpen = false;
        this.selectedText = '';
        this.init();
    }

    init() {
        this.createWidget();
        this.attachEventListeners();
    }

    createWidget() {
        const widgetHTML = `
            <div id="translation-widget" class="fixed bottom-4 right-4 z-50">
                <!-- Chat Button -->
                <button id="translation-btn" class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-full p-3 shadow-lg transition duration-200 flex items-center justify-center w-14 h-14" title="Translate selected text">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </button>

                <!-- Translation Modal -->
                <div id="translation-modal" class="hidden absolute bottom-20 right-0 w-96 bg-white rounded-lg shadow-xl border border-gray-200 p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Translate to Tagalog</h3>
                        <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-1">
                        <textarea id="translation-input" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none" rows="5" maxlength="5000" placeholder="Enter text to translate (words, phrases, or sentences)..."></textarea>
                        <div class="flex justify-between items-center mt-1 mb-2">
                            <span class="text-xs text-gray-400">Supports single words, phrases, and full sentences</span>
                            <span id="char-count" class="text-xs text-gray-400">0 / 5000</span>
                        </div>
                    </div>

                    <button id="translate-btn" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded transition duration-200 mb-3 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        Translate
                    </button>

                    <div id="translation-result" class="hidden bg-emerald-50 border border-emerald-200 rounded p-3 text-sm max-h-40 overflow-y-auto">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-gray-600 font-medium">Translation:</p>
                            <button id="copy-btn" class="text-emerald-600 hover:text-emerald-800 text-xs flex items-center gap-1" title="Copy translation">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy
                            </button>
                        </div>
                        <p id="translation-output" class="text-emerald-900 font-semibold leading-relaxed"></p>
                    </div>

                    <div id="translation-loading" class="hidden flex items-center justify-center py-3">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-emerald-600"></div>
                        <span class="ml-2 text-sm text-gray-600">Translating...</span>
                    </div>

                    <div id="translation-error" class="hidden bg-red-50 border border-red-200 rounded p-3 text-sm text-red-800"></div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', widgetHTML);
    }

    attachEventListeners() {
        const btn = document.getElementById('translation-btn');
        const modal = document.getElementById('translation-modal');
        const closeBtn = document.getElementById('close-modal');
        const translateBtn = document.getElementById('translate-btn');
        const input = document.getElementById('translation-input');
        const charCount = document.getElementById('char-count');
        const copyBtn = document.getElementById('copy-btn');

        // Toggle modal
        btn.addEventListener('click', () => {
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                input.focus();
                this.updateCharCount();
            }
        });

        // Close modal
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Translate on button click
        translateBtn.addEventListener('click', () => {
            this.performTranslation();
        });

        // Update character count on input
        input.addEventListener('input', () => {
            this.updateCharCount();
        });

        // Translate on Enter key (Shift+Enter for new line)
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.performTranslation();
            }
        });

        // Get selected text on page
        document.addEventListener('mouseup', () => {
            this.selectedText = window.getSelection().toString().trim();
            if (this.selectedText) {
                input.value = this.selectedText;
                this.updateCharCount();
            }
        });

        // Copy translation to clipboard
        copyBtn.addEventListener('click', () => {
            const output = document.getElementById('translation-output').textContent;
            if (output) {
                navigator.clipboard.writeText(output).then(() => {
                    // Show brief feedback
                    const originalText = copyBtn.innerHTML;
                    copyBtn.innerHTML = `
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Copied!
                    `;
                    setTimeout(() => {
                        copyBtn.innerHTML = originalText;
                    }, 2000);
                });
            }
        });
    }

    updateCharCount() {
        const input = document.getElementById('translation-input');
        const charCount = document.getElementById('char-count');
        const length = input.value.length;
        charCount.textContent = `${length} / 5000`;

        // Change color if near limit
        if (length > 4500) {
            charCount.classList.remove('text-gray-400');
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
            charCount.classList.add('text-gray-400');
        }
    }

    performTranslation() {
        const input = document.getElementById('translation-input');
        const text = input.value.trim();

        if (!text) {
            this.showError('Please enter text to translate');
            return;
        }

        this.showLoading();

        fetch('/api/translate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                text: text,
                target_language: 'tl'
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.showResult(data.translated);
                } else {
                    this.showError(data.error || 'Translation failed');
                }
            })
            .catch(error => {
                console.error('Translation error:', error);
                this.showError('Error translating text');
            });
    }

    showLoading() {
        document.getElementById('translation-result').classList.add('hidden');
        document.getElementById('translation-error').classList.add('hidden');
        document.getElementById('translation-loading').classList.remove('hidden');
    }

    showResult(translated) {
        document.getElementById('translation-loading').classList.add('hidden');
        document.getElementById('translation-error').classList.add('hidden');
        document.getElementById('translation-output').textContent = translated;
        document.getElementById('translation-result').classList.remove('hidden');
    }

    showError(message) {
        document.getElementById('translation-loading').classList.add('hidden');
        document.getElementById('translation-result').classList.add('hidden');
        document.getElementById('translation-error').textContent = message;
        document.getElementById('translation-error').classList.remove('hidden');
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new TranslationWidget();
});
