<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('candidatures.show', $candidature) }}" class="text-text-muted hover:text-neon-cyan transition p-1 -ml-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-mono font-bold text-lg text-text-primary">Modifier la candidature</h2>
                <p class="font-mono text-sm text-text-muted">{{ $candidature->entreprise }} — {{ $candidature->poste }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-2 mb-6 font-mono text-xs">
            <span class="text-neon-cyan">01</span>
            <span class="text-text-dim">—</span>
            <span class="text-text-muted">Informations</span>
            <span class="text-text-dim">·</span>
            <span class="text-text-dim">02 Détails</span>
            <span class="text-text-dim">·</span>
            <span class="text-text-dim">03 Document</span>
        </div>

        <div class="glass rounded-2xl p-6 sm:p-8 animate-fade-up">
            <form method="POST" action="{{ route('candidatures.update', $candidature) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <div>
                        <div class="flex items-center gap-2 mb-5">
                            <span class="w-6 h-6 rounded-lg bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center font-mono text-[10px] text-neon-cyan font-bold">1</span>
                            <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Informations</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-2">
                                <x-input-label for="entreprise" value="Entreprise *" />
                                <x-text-input id="entreprise" name="entreprise" type="text" class="mt-1.5 block w-full" :value="old('entreprise', $candidature->entreprise)" required />
                                <x-input-error :messages="$errors->get('entreprise')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="poste" value="Poste *" />
                                <x-text-input id="poste" name="poste" type="text" class="mt-1.5 block w-full" :value="old('poste', $candidature->poste)" required />
                                <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="offre_url" value="URL de l'offre" />
                                <x-text-input id="offre_url" name="offre_url" type="url" class="mt-1.5 block w-full" :value="old('offre_url', $candidature->offre_url)" placeholder="https://..." />
                                <x-input-error :messages="$errors->get('offre_url')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dark-border">
                        <div class="flex items-center gap-2 mb-5">
                            <span class="w-6 h-6 rounded-lg bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center font-mono text-[10px] text-neon-cyan font-bold">2</span>
                            <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Détails</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input-label for="statut" value="Statut *" />
                                <select id="statut" name="statut" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                                    <option value="to_review" {{ old('statut', $candidature->statut) == 'to_review' ? 'selected' : '' }}>En attente</option>
                                    <option value="interview_scheduled" {{ old('statut', $candidature->statut) == 'interview_scheduled' ? 'selected' : '' }}>Entretien planifié</option>
                                    <option value="offer_received" {{ old('statut', $candidature->statut) == 'offer_received' ? 'selected' : '' }}>Offre reçue</option>
                                    <option value="rejected" {{ old('statut', $candidature->statut) == 'rejected' ? 'selected' : '' }}>Refusé</option>
                                    <option value="abandoned" {{ old('statut', $candidature->statut) == 'abandoned' ? 'selected' : '' }}>Abandonné</option>
                                </select>
                                <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="priorite" value="Priorité *" />
                                <select id="priorite" name="priorite" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                                    <option value="high" {{ old('priorite', $candidature->priorite) == 'high' ? 'selected' : '' }}>Haute</option>
                                    <option value="medium" {{ old('priorite', $candidature->priorite) == 'medium' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="low" {{ old('priorite', $candidature->priorite) == 'low' ? 'selected' : '' }}>Faible</option>
                                </select>
                                <x-input-error :messages="$errors->get('priorite')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date_candidature" value="Date de candidature *" />
                                <x-text-input id="date_candidature" name="date_candidature" type="date" class="mt-1.5 block w-full" :value="old('date_candidature', $candidature->date_candidature)" required />
                                <x-input-error :messages="$errors->get('date_candidature')" class="mt-2" />
                            </div>
                            <div></div>
                            <div class="sm:col-span-2">
                                <x-input-label for="notes" value="Notes" />
                                <textarea id="notes" name="notes" rows="4" class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary placeholder-[#555] focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">{{ old('notes', $candidature->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dark-border">
                        <div class="flex items-center gap-2 mb-5">
                            <span class="w-6 h-6 rounded-lg bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center font-mono text-[10px] text-neon-cyan font-bold">3</span>
                            <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Document</h3>
                        </div>
                        <div>
                            <x-input-label for="document" value="Ajouter un document" />
                            <div class="mt-1.5 relative">
                                <input id="document" name="document" type="file"
                                       class="block w-full font-mono text-xs text-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-mono file:text-xs file:font-semibold file:bg-neon-cyan/10 file:text-neon-cyan hover:file:bg-neon-cyan/20 border border-dark-border bg-dark-surface rounded-lg shadow-sm" />
                            </div>
                            <x-input-error :messages="$errors->get('document')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-dark-border">
                    <a href="{{ route('candidatures.show', $candidature) }}" class="inline-flex items-center px-4 py-2 bg-dark-surface border border-dark-border rounded-lg font-mono text-xs text-text-muted uppercase tracking-wider hover:text-text-primary hover:border-neon-cyan/30 transition">
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
