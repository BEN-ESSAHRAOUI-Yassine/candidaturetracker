<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="font-mono font-bold text-lg text-text-primary">Mes candidatures</h2>
                <span class="font-mono text-[10px] text-text-dim bg-dark-elevated px-2 py-0.5 rounded border border-dark-border">{{ $candidatures->count() }} dossier(s)</span>
            </div>
            <a href="{{ route('candidatures.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan uppercase tracking-wider hover:bg-neon-cyan/20 hover:border-neon-cyan/50 shadow-glow-sm transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filter Panel -->
        <div class="lg:w-64 shrink-0">
            <div class="glass rounded-2xl p-5 lg:sticky lg:top-24">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-mono text-xs text-text-muted uppercase tracking-widest">Filtres</h3>
                    @if (request()->has('statut') || request()->has('priorite'))
                        <a href="{{ route('candidatures.index') }}" class="font-mono text-[10px] text-neon-orange hover:text-neon-orange/80 transition">Réinitialiser</a>
                    @endif
                </div>
                <form method="GET" action="{{ route('candidatures.index') }}" class="space-y-4">
                    <div>
                        <x-input-label for="statut" value="Statut" />
                        <select name="statut" id="statut" class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                            <option value="">Tous</option>
                            <option value="to_review" {{ request('statut') == 'to_review' ? 'selected' : '' }}>En attente</option>
                            <option value="interview_scheduled" {{ request('statut') == 'interview_scheduled' ? 'selected' : '' }}>Entretien planifié</option>
                            <option value="offer_received" {{ request('statut') == 'offer_received' ? 'selected' : '' }}>Offre reçue</option>
                            <option value="rejected" {{ request('statut') == 'rejected' ? 'selected' : '' }}>Refusé</option>
                            <option value="abandoned" {{ request('statut') == 'abandoned' ? 'selected' : '' }}>Abandonné</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="priorite" value="Priorité" />
                        <select name="priorite" id="priorite" class="mt-1.5 block w-full border-dark-border bg-dark-surface text-text-primary focus:border-neon-cyan/50 focus:ring-neon-cyan/30 rounded-lg shadow-sm font-mono text-sm">
                            <option value="">Toutes</option>
                            <option value="high" {{ request('priorite') == 'high' ? 'selected' : '' }}>Haute</option>
                            <option value="medium" {{ request('priorite') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="low" {{ request('priorite') == 'low' ? 'selected' : '' }}>Faible</option>
                        </select>
                    </div>
                    <x-primary-button class="w-full justify-center">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrer
                    </x-primary-button>
                </form>

                <div class="mt-5 pt-5 border-t border-dark-border">
                    <p class="font-mono text-[10px] text-text-dim uppercase tracking-widest mb-2">Légende statuts</p>
                    <div class="space-y-1.5">
                        <span class="flex items-center gap-2 font-mono text-[10px] text-text-muted"><span class="status-dot bg-yellow-400"></span> En attente</span>
                        <span class="flex items-center gap-2 font-mono text-[10px] text-text-muted"><span class="status-dot bg-neon-cyan"></span> Entretien</span>
                        <span class="flex items-center gap-2 font-mono text-[10px] text-text-muted"><span class="status-dot bg-neon-green"></span> Offre</span>
                        <span class="flex items-center gap-2 font-mono text-[10px] text-text-muted"><span class="status-dot bg-red-400"></span> Refusé</span>
                        <span class="flex items-center gap-2 font-mono text-[10px] text-text-muted"><span class="status-dot bg-gray-500"></span> Abandonné</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission Cards -->
        <div class="flex-1 min-w-0 space-y-3">
            @forelse ($candidatures as $candidature)
                @php
                    $borderColor = match($candidature->statut) {
                        'to_review' => 'border-l-yellow-400',
                        'interview_scheduled' => 'border-l-neon-cyan',
                        'offer_received' => 'border-l-neon-green',
                        'rejected' => 'border-l-red-400',
                        'abandoned' => 'border-l-gray-500',
                        default => 'border-l-dark-border',
                    };
                    $priorityColor = match($candidature->priorite) {
                        'high' => 'text-neon-orange border-neon-orange/30',
                        'medium' => 'text-yellow-400 border-yellow-400/30',
                        'low' => 'text-gray-400 border-gray-400/30',
                        default => 'text-gray-400 border-gray-400/30',
                    };
                @endphp
                <div class="glass rounded-2xl border-l-2 {{ $borderColor }} p-5 glass-hover animate-fade-up group"
                     style="animation-delay: {{ $loop->index * 0.04 }}s">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-mono text-base font-semibold text-text-primary group-hover:text-neon-cyan transition-colors truncate">
                                    {{ $candidature->entreprise }}
                                </h3>
                                <span class="font-mono text-[10px] text-text-dim bg-dark-elevated px-2 py-0.5 rounded">
                                    #{{ $candidature->id }}
                                </span>
                            </div>
                            <p class="font-mono text-sm text-text-muted mt-0.5">{{ $candidature->poste }}</p>
                            <div class="flex items-center gap-3 mt-2 flex-wrap">
                                <span class="flex items-center gap-1.5 font-mono text-xs">
                                    <span class="status-dot
                                        @switch($candidature->statut)
                                            @case('to_review') bg-yellow-400 @break
                                            @case('interview_scheduled') bg-neon-cyan @break
                                            @case('offer_received') bg-neon-green @break
                                            @case('rejected') bg-red-400 @break
                                            @case('abandoned') bg-gray-400 @break
                                        @endswitch
                                    "></span>
                                    <span class="
                                        @switch($candidature->statut)
                                            @case('to_review') text-yellow-400 @break
                                            @case('interview_scheduled') text-neon-cyan @break
                                            @case('offer_received') text-neon-green @break
                                            @case('rejected') text-red-400 @break
                                            @case('abandoned') text-gray-400 @break
                                        @endswitch
                                    ">{{ $candidature->statut_label }}</span>
                                </span>
                                <span class="inline-flex items-center gap-1 font-mono text-[10px] {{ $priorityColor }} border px-1.5 py-0.5 rounded">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        @switch($candidature->priorite)
                                            @case('high') bg-neon-orange @break
                                            @case('medium') bg-yellow-400 @break
                                            @case('low') bg-gray-400 @break
                                        @endswitch
                                    "></span>
                                    {{ $candidature->priorite_label }}
                                </span>
                                <span class="font-mono text-[10px] text-text-dim">
                                    {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <a href="{{ route('candidatures.show', $candidature) }}"
                               class="inline-flex items-center px-3 py-2 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg text-xs font-mono text-neon-cyan hover:bg-neon-cyan/20 transition">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir
                            </a>
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
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-dark-surface border border-dark-border rounded-lg text-xs font-mono text-neon-orange hover:bg-neon-orange/5 hover:border-neon-orange/30 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass rounded-2xl p-12 text-center animate-fade-up">
                    <svg class="w-16 h-16 mx-auto text-text-dim mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="font-mono text-base font-medium text-text-muted mb-2">Aucune candidature</h3>
                    <p class="font-mono text-xs text-text-dim mb-6">Commencez par créer votre première candidature.</p>
                    <a href="{{ route('candidatures.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan uppercase tracking-wider hover:bg-neon-cyan/20 hover:border-neon-cyan/50 shadow-glow-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouvelle candidature
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
