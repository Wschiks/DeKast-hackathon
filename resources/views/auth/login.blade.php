<x-guest-layout>
    <h1 class="text-xl font-semibold text-center mb-6">Login</h1>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        <input type="hidden" name="barcode" id="barcode-field">

        <div class="flex justify-center gap-3">
            @for ($i = 0; $i < 4; $i++)
                <input
                    type="text"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="1"
                    class="digit-box w-32 h-14 text-center text-2xl border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500"
                    autocomplete="off"
                >
            @endfor
        </div>

        @error('barcode')
        <p class="text-sm text-red-600 text-center mt-4">{{ $message }}</p>
        @enderror

        <div class="mt-6 flex justify-center">
            <x-primary-button>Inloggen</x-primary-button>
        </div>
    </form>

    <script>
        const boxes = document.querySelectorAll('.digit-box');
        const hidden = document.getElementById('barcode-field');
        const form = document.getElementById('login-form');

        boxes.forEach((box, index) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/[^0-9]/g, '');
                if (box.value && index < boxes.length - 1) {
                    boxes[index + 1].focus();
                }
            });

            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && index > 0) {
                    boxes[index - 1].focus();
                }
            });

            box.addEventListener('paste', (e) => {
                e.preventDefault();
                const digits = (e.clipboardData.getData('text').match(/\d/g) || []).slice(0, 4);
                digits.forEach((d, i) => { if (boxes[i]) boxes[i].value = d; });
                boxes[Math.min(digits.length, boxes.length - 1)].focus();
            });
        });

        form.addEventListener('submit', () => {
            hidden.value = Array.from(boxes).map(b => b.value).join('');
        });

        boxes[0].focus();
    </script>
</x-guest-layout>
