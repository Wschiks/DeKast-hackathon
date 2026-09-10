<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hoi {{ $sporter->naam }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="scanCard()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black text-center">
                    <button
                        @click="scan()"
                        :disabled="loading"
                        class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-gray-300 focus:outline-none disabled:opacity-50"
                    >
                        <span x-show="!loading">Scan kaart</span>
                        <span x-show="loading">Bezig met scannen...</span>
                    </button>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Abonnement</p>
                        <p class="font-medium">{{ $sporter->abonnement->type_naam }}</p>
                    </div>

                    <div class="text-right text-blue-500">
                        <p class="text-sm text-gray-500">Bezoeken</p>
                        <p class="font-medium" x-text="bezoekenLabel"></p>
                    </div>
                </div>
            </div>



            @if (! $sporter->geannuleerd)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <button
                            @click="showCancelConfirm = true"
                            class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none"
                        >
                            Annuleren
                        </button>
                    </div>
                </div>
            @endif

        </div>

        <!-- Popup: scan resultaat -->
        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @keydown.escape.window="showModal = false"
        >
            <div class="bg-white rounded-lg shadow-xl max-w-sm mx-4 p-6" @click.outside="showModal = false">
                <div class="text-center">
                    <template x-if="success">
                        <div>
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mt-4">Toegang verleend</h3>
                        </div>
                    </template>

                    <template x-if="!success">
                        <div>
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mt-4">Toegang geweigerd</h3>
                            <p class="text-sm text-gray-600 mt-2" x-text="message"></p>
                        </div>
                    </template>

                    <button
                        @click="showModal = false"
                        class="mt-6 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-800 hover:bg-gray-300"
                    >
                        Sluiten
                    </button>
                </div>
            </div>
        </div>

        <!-- Popup: annuleer bevestiging -->
        <div
            x-show="showCancelConfirm"
            x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            @keydown.escape.window="showCancelConfirm = false"
        >
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4 p-6" @click.outside="showCancelConfirm = false">
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-900">Weet u het zeker?</h3>
                    <p class="text-sm text-gray-600 mt-2">Dit annuleert uw abonnement.</p>

                    <div class="mt-6 flex justify-center gap-3">
                        <button
                            @click="cancelCard()"
                            :disabled="cancelLoading"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700 disabled:opacity-50"
                        >
                            <span x-show="!cancelLoading">Ja, verwijder</span>
                            <span x-show="cancelLoading">Bezig...</span>
                        </button>

                        <button
                            @click="showCancelConfirm = false"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-800 hover:bg-gray-300"
                        >
                            Nee, Annuleren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function scanCard() {
            return {
                loading: false,
                showModal: false,
                success: false,
                message: '',
                bezoekenLabel: @js($bezoeken['onbeperkt']
                    ? 'Bezoeken: ' . $bezoeken['aantal']
                    : 'Bezoeken ' . $bezoeken['aantal'] . ' / ' . $bezoeken['limiet']),

                showCancelConfirm: false,
                cancelLoading: false,

                async scan() {
                    this.loading = true;

                    try {
                        const response = await fetch('{{ route('scan.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        });

                        const data = await response.json();

                        this.success = data.toegestaan;
                        this.message = data.foutmelding ?? '';

                        this.bezoekenLabel = data.bezoeken.onbeperkt
                            ? 'Bezoeken: ' + data.bezoeken.aantal
                            : 'Bezoeken ' + data.bezoeken.aantal + ' / ' + data.bezoeken.limiet;

                        this.showModal = true;
                    } catch (e) {
                        this.success = false;
                        this.message = 'Er ging iets mis, probeer opnieuw.';
                        this.showModal = true;
                    } finally {
                        this.loading = false;
                    }
                },

                async cancelCard() {
                    this.cancelLoading = true;

                    try {
                        await fetch('{{ route('annulering.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        });

                        window.location.reload();
                    } catch (e) {
                        this.cancelLoading = false;
                        alert('Er ging iets mis, probeer opnieuw.');
                    }
                }
            }
        }
    </script>
</x-app-layout>
