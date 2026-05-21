<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier l\'entretien') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $entretien->candidature->entreprise }} — {{ $entretien->candidature->poste }}
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">
                <form method="POST" action="{{ route('entretiens.update', $entretien) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type" value="Type *" />
                            <select id="type" name="type" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                <option value="telephone" {{ old('type', $entretien->type) == 'telephone' ? 'selected' : '' }}>Téléphone</option>
                                <option value="technique" {{ old('type', $entretien->type) == 'technique' ? 'selected' : '' }}>Technique</option>
                                <option value="rh" {{ old('type', $entretien->type) == 'rh' ? 'selected' : '' }}>RH</option>
                                <option value="final" {{ old('type', $entretien->type) == 'final' ? 'selected' : '' }}>Final</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date_entretien" value="Date *" />
                            <x-text-input id="date_entretien" name="date_entretien" type="datetime-local" class="mt-1 block w-full" :value="old('date_entretien', $entretien->date_entretien ? \Carbon\Carbon::parse($entretien->date_entretien)->format('Y-m-d\TH:i') : '')" required />
                            <x-input-error :messages="$errors->get('date_entretien')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="resultat" value="Résultat *" />
                            <select id="resultat" name="resultat" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                <option value="pending" {{ old('resultat', $entretien->resultat) == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="positive" {{ old('resultat', $entretien->resultat) == 'positive' ? 'selected' : '' }}>Positif</option>
                                <option value="negative" {{ old('resultat', $entretien->resultat) == 'negative' ? 'selected' : '' }}>Négatif</option>
                            </select>
                            <x-input-error :messages="$errors->get('resultat')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="notes_preparation" value="Notes de préparation" />
                            <textarea id="notes_preparation" name="notes_preparation" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">{{ old('notes_preparation', $entretien->notes_preparation) }}</textarea>
                            <x-input-error :messages="$errors->get('notes_preparation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('candidatures.show', $entretien->candidature) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Annuler
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                            Mettre à jour
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>