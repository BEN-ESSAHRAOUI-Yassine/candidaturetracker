<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('candidatures.index') }}" class="text-text-muted hover:text-neon-cyan transition p-1 -ml-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="font-mono font-bold text-lg text-text-primary">{{ $candidature->entreprise }}</h2>
                    <span class="font-mono text-[10px] text-text-dim bg-dark-elevated px-2 py-0.5 rounded">#{{ $candidature->id }}</span>
                </div>
                <p class="font-mono text-sm text-text-muted mt-1 ml-8">{{ $candidature->poste }}</p>
            </div>
            <div class="flex items-center gap-2">
                @can('update', $candidature)
                    <a href="{{ route('candidatures.edit', $candidature) }}"
                       class="inline-flex items-center px-3 py-2 bg-dark-surface border border-dark-border rounded-lg text-xs font-mono text-text-muted hover:text-neon-cyan hover:border-neon-cyan/30 transition">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                @endcan
                @can('delete', $candidature)
                    <form action="{{ route('candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Archiver cette candidature ?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-dark-surface border border-dark-border rounded-lg text-xs font-mono text-neon-orange hover:bg-neon-orange/5 hover:border-neon-orange/30 transition">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Archiver
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div x-data="{ tab: 'info' }" class="space-y-6">
        @if (session('success'))
            <div class="bg-neon-green/5 border border-neon-green/20 text-neon-green rounded-xl px-5 py-3 font-mono text-sm animate-fade-up flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="glass rounded-2xl p-1.5 inline-flex">
            <button @click="tab = 'info'"
                    :class="tab === 'info' ? 'bg-neon-cyan/10 text-neon-cyan border border-neon-cyan/30' : 'text-text-muted hover:text-text-primary border border-transparent'"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl font-mono text-xs transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informations
            </button>
            <button @click="tab = 'timeline'"
                    :class="tab === 'timeline' ? 'bg-neon-cyan/10 text-neon-cyan border border-neon-cyan/30' : 'text-text-muted hover:text-text-primary border border-transparent'"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl font-mono text-xs transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Entretiens
                @if($candidature->entretiens->count() > 0)
                    <span class="bg-neon-cyan/20 text-neon-cyan text-[10px] px-1.5 py-0.5 rounded">{{ $candidature->entretiens->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'documents'"
                    :class="tab === 'documents' ? 'bg-neon-cyan/10 text-neon-cyan border border-neon-cyan/30' : 'text-text-muted hover:text-text-primary border border-transparent'"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl font-mono text-xs transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                Documents
                @if($candidature->documents->count() > 0)
                    <span class="bg-neon-cyan/20 text-neon-cyan text-[10px] px-1.5 py-0.5 rounded">{{ $candidature->documents->count() }}</span>
                @endif
            </button>
        </div>

        <!-- Tab: Info -->
        <div x-show="tab === 'info'" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-y-2" class="space-y-6">
            <div class="glass rounded-2xl p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Dossier {{ $candidature->entreprise }}</h3>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">Entreprise</dt>
                        <dd class="mt-1 font-mono text-sm text-text-primary">{{ $candidature->entreprise }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">Poste</dt>
                        <dd class="mt-1 font-mono text-sm text-text-primary">{{ $candidature->poste }}</dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">Statut</dt>
                        <dd class="mt-1">
                            <span class="flex items-center gap-1.5 font-mono text-sm
                                @switch($candidature->statut)
                                    @case('to_review') text-yellow-400 @break
                                    @case('interview_scheduled') text-neon-cyan @break
                                    @case('offer_received') text-neon-green @break
                                    @case('rejected') text-red-400 @break
                                    @case('abandoned') text-gray-400 @break
                                @endswitch
                            ">
                                <span class="status-dot
                                    @switch($candidature->statut)
                                        @case('to_review') bg-yellow-400 @break
                                        @case('interview_scheduled') bg-neon-cyan @break
                                        @case('offer_received') bg-neon-green @break
                                        @case('rejected') bg-red-400 @break
                                        @case('abandoned') bg-gray-400 @break
                                    @endswitch
                                "></span>
                                {{ $candidature->statut_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">Priorité</dt>
                        <dd class="mt-1">
                            <span class="flex items-center gap-1.5 font-mono text-sm
                                @switch($candidature->priorite)
                                    @case('high') text-neon-orange @break
                                    @case('medium') text-yellow-400 @break
                                    @case('low') text-gray-400 @break
                                @endswitch
                            ">
                                <span class="status-dot
                                    @switch($candidature->priorite)
                                        @case('high') bg-neon-orange @break
                                        @case('medium') bg-yellow-400 @break
                                        @case('low') bg-gray-400 @break
                                    @endswitch
                                "></span>
                                {{ $candidature->priorite_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">Date de candidature</dt>
                        <dd class="mt-1 font-mono text-sm text-text-primary">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</dd>
                    </div>
                    @if ($candidature->offre_url)
                        <div>
                            <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest">URL de l'offre</dt>
                            <dd class="mt-1">
                                <a href="{{ $candidature->offre_url }}" target="_blank" class="inline-flex items-center gap-1 font-mono text-sm text-neon-cyan hover:text-neon-cyan/80 transition">
                                    Voir l'offre
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
                @if ($candidature->notes)
                    <div class="mt-6 pt-6 border-t border-dark-border">
                        <dt class="font-mono text-[10px] text-text-muted uppercase tracking-widest mb-3">Notes</dt>
                        <dd class="font-mono text-sm text-text-primary whitespace-pre-wrap bg-dark-elevated/50 rounded-xl p-4">{{ $candidature->notes }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab: Timeline / Interviews -->
        <div x-show="tab === 'timeline'" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-y-2" class="space-y-6">
            <div class="glass rounded-2xl p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Entretiens</h3>
                    </div>
                </div>

                @forelse ($candidature->entretiens as $entretien)
                    @php
                        $date = \Carbon\Carbon::parse($entretien->date_entretien);
                        $now = now();
                        $diffDays = $now->diffInDays($date, false);
                        $isPast = $diffDays < 0;
                    @endphp
                    <div class="flex gap-4 {{ !$loop->last ? 'pb-6' : '' }}">
                        <div class="flex flex-col items-center">
                            <span class="w-3 h-3 rounded-full flex-shrink-0 {{ $isPast ? 'bg-gray-500' : 'bg-neon-cyan animate-pulse-glow' }}"></span>
                            @if (!$loop->last)
                                <div class="w-px flex-1 bg-gradient-to-b from-dark-border to-transparent mt-1"></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 pb-0">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono
                                        @switch($entretien->type)
                                            @case('telephone') bg-neon-cyan/10 text-neon-cyan @break
                                            @case('technique') bg-purple-500/10 text-purple-400 @break
                                            @case('rh') bg-neon-green/10 text-neon-green @break
                                            @case('final') bg-neon-orange/10 text-neon-orange @break
                                        @endswitch
                                    ">{{ $entretien->type_label }}</span>
                                    <span class="font-mono text-xs text-text-primary">{{ $date->format('d/m/Y H:i') }}</span>
                                    <span class="flex items-center gap-1 font-mono text-xs
                                        @switch($entretien->resultat)
                                            @case('pending') text-yellow-400 @break
                                            @case('positive') text-neon-green @break
                                            @case('negative') text-red-400 @break
                                        @endswitch
                                    ">
                                        <span class="status-dot
                                            @switch($entretien->resultat)
                                                @case('pending') bg-yellow-400 @break
                                                @case('positive') bg-neon-green @break
                                                @case('negative') bg-red-400 @break
                                            @endswitch
                                        "></span>
                                        {{ $entretien->resultat_label }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    @can('update', $entretien)
                                        <a href="{{ route('entretiens.edit', $entretien) }}" class="font-mono text-[10px] text-neon-cyan hover:text-neon-cyan/80 transition">Modifier</a>
                                    @endcan
                                    @can('delete', $entretien)
                                        <form action="{{ route('entretiens.destroy', $entretien) }}" method="POST" onsubmit="return confirm('Supprimer cet entretien ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-mono text-[10px] text-neon-orange hover:text-neon-orange/80 transition">Supprimer</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                            @if ($entretien->notes_preparation)
                                <p class="font-mono text-xs text-text-muted mt-2 bg-dark-elevated/30 rounded-lg p-3">{{ $entretien->notes_preparation }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-text-dim mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="font-mono text-xs text-text-muted">Aucun entretien planifié.</p>
                    </div>
                @endforelse

                <!-- Add Interview Form -->
                @can('update', $candidature)
                @if ($candidature->statut !== 'abandoned')
                    <div class="mt-6 pt-6 border-t border-dark-border">
                        <h4 class="font-mono text-xs text-text-primary uppercase tracking-wider mb-4">Ajouter un entretien</h4>
                        <form method="POST" action="{{ route('entretiens.store', $candidature) }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <x-input-label for="type" value="Type *" />
                                <select id="type" name="type" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                                    <option value="telephone">Téléphone</option>
                                    <option value="technique">Technique</option>
                                    <option value="rh">RH</option>
                                    <option value="final">Final</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date_entretien" value="Date *" />
                                <x-text-input id="date_entretien" name="date_entretien" type="datetime-local" class="mt-1.5 block w-full" :value="old('date_entretien')" required />
                                <x-input-error :messages="$errors->get('date_entretien')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="resultat" value="Résultat *" />
                                <select id="resultat" name="resultat" required class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                                    <option value="pending">En attente</option>
                                    <option value="positive">Positif</option>
                                    <option value="negative">Négatif</option>
                                </select>
                                <x-input-error :messages="$errors->get('resultat')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="notes_preparation" value="Notes de préparation" />
                                <textarea id="notes_preparation" name="notes_preparation" rows="2" class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary placeholder-[#555] focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">{{ old('notes_preparation') }}</textarea>
                                <x-input-error :messages="$errors->get('notes_preparation')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2 flex justify-end">
                                <x-primary-button>
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajouter l'entretien
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
                @endcan
            </div>
        </div>

        <!-- Tab: Documents -->
        <div x-show="tab === 'documents'" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-y-2" class="space-y-6">
            <div class="glass rounded-2xl p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </div>
                    <h3 class="font-mono text-sm text-text-primary uppercase tracking-wider">Documents</h3>
                </div>

                @forelse ($candidature->documents as $document)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-dark-border' : '' }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-dark-elevated border border-dark-border flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-mono text-sm font-medium text-text-primary truncate">{{ $document->nom_fichier }}</p>
                                <p class="font-mono text-xs text-text-muted">{{ $document->type_mime }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4 shrink-0">
                            @can('view', $document->candidature)
                                <a href="{{ route('documents.download', $document) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-dark-surface border border-dark-border rounded-lg text-xs font-mono text-text-muted hover:text-neon-cyan hover:border-neon-cyan/30 transition">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Télécharger
                                </a>
                            @endcan
                            @can('update', $document->candidature)
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-mono text-[10px] text-neon-orange hover:text-neon-orange/80 transition">Supprimer</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-text-dim mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <p class="font-mono text-xs text-text-muted">Aucun document attaché.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
