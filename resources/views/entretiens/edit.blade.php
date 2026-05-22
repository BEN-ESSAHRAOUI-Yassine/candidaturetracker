<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('candidatures.show', $entretien->candidature) }}" class="text-text-muted hover:text-neon-cyan transition p-1 -ml-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-mono font-bold text-lg text-text-primary">Modifier l'entretien</h2>
                <p class="font-mono text-sm text-text-muted">{{ $entretien->candidature->entreprise }} — {{ $entretien->candidature->poste }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="glass rounded-2xl p-6 sm:p-8 animate-fade-up">
            <form method="POST" action="{{ route('entretiens.update', $entretien) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="type" value="Type *" />
                        <select id="type" name="type" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                            <option value="telephone" {{ old('type', $entretien->type) == 'telephone' ? 'selected' : '' }}>Téléphone</option>
                            <option value="technique" {{ old('type', $entretien->type) == 'technique' ? 'selected' : '' }}>Technique</option>
                            <option value="rh" {{ old('type', $entretien->type) == 'rh' ? 'selected' : '' }}>RH</option>
                            <option value="final" {{ old('type', $entretien->type) == 'final' ? 'selected' : '' }}>Final</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="date_entretien" value="Date *" />
                        <x-text-input id="date_entretien" name="date_entretien" type="datetime-local" class="mt-1.5 block w-full" :value="old('date_entretien', $entretien->date_entretien ? \Carbon\Carbon::parse($entretien->date_entretien)->format('Y-m-d\TH:i') : '')" required />
                        <x-input-error :messages="$errors->get('date_entretien')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="resultat" value="Résultat *" />
                        <select id="resultat" name="resultat" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                            <option value="pending" {{ old('resultat', $entretien->resultat) == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="positive" {{ old('resultat', $entretien->resultat) == 'positive' ? 'selected' : '' }}>Positif</option>
                            <option value="negative" {{ old('resultat', $entretien->resultat) == 'negative' ? 'selected' : '' }}>Négatif</option>
                        </select>
                        <x-input-error :messages="$errors->get('resultat')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="notes_preparation" value="Notes de préparation" />
                        <textarea id="notes_preparation" name="notes_preparation" rows="4" class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary placeholder-[#555] focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">{{ old('notes_preparation', $entretien->notes_preparation) }}</textarea>
                        <x-input-error :messages="$errors->get('notes_preparation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-dark-border">
                    <a href="{{ route('candidatures.show', $entretien->candidature) }}" class="inline-flex items-center px-4 py-2 bg-dark-surface border border-dark-border rounded-lg font-mono text-xs text-text-muted uppercase tracking-wider hover:text-text-primary hover:border-neon-cyan/30 transition">
                        Annuler
                    </a>
                    <x-primary-button>
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Mettre à jour
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
