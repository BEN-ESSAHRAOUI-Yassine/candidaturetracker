<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('candidatures.index') }}" class="text-text-muted hover:text-neon-cyan transition p-1 -ml-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-mono font-bold text-lg text-text-primary">Archives</h2>
                <span class="font-mono text-[10px] text-text-dim bg-dark-elevated px-2 py-0.5 rounded border border-dark-border">{{ $candidatures->count() }} entrée(s)</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Terminal Header -->
        <div class="glass rounded-t-2xl border-b border-dark-border px-5 py-3 flex items-center gap-3">
            <div class="flex gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-red-400/50"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400/50"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-neon-green/50"></span>
            </div>
            <span class="font-mono text-[10px] text-text-dim">archives@tracker:~$</span>
            <span class="font-mono text-[10px] text-neon-cyan animate-typing max-w-[200px]">ls -la --archived</span>
        </div>

        <div class="glass rounded-b-2xl rounded-t-none p-5 font-mono text-sm space-y-0">
            @forelse ($candidatures as $candidature)
                @php
                    $pct = $candidature->priorite === 'high' ? '!' : ($candidature->priorite === 'medium' ? '!' : '');
                    $statusChar = match($candidature->statut) {
                        'to_review' => '?',
                        'interview_scheduled' => '>',
                        'offer_received' => '+',
                        'rejected' => '-',
                        'abandoned' => 'x',
                    };
                @endphp
                <div class="flex items-start gap-3 py-2.5 border-b border-dark-border last:border-0 group hover:bg-dark-elevated/30 px-2 -mx-2 rounded transition">
                    <span class="text-text-dim shrink-0 font-mono text-[10px] mt-0.5">
                        {{ $candidature->deleted_at ? \Carbon\Carbon::parse($candidature->deleted_at)->format('d/m') : '--/--' }}
                    </span>
                    <span class="text-text-dim shrink-0 font-mono">[{{ $statusChar }}]</span>
                    <div class="flex-1 min-w-0">
                        <span class="text-neon-cyan font-semibold">{{ $candidature->entreprise }}</span>
                        <span class="text-text-dim"> — </span>
                        <span class="text-text-muted">{{ $candidature->poste }}</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.5 rounded shrink-0
                        @switch($candidature->statut)
                            @case('to_review') text-yellow-400 bg-yellow-400/5 @break
                            @case('interview_scheduled') text-neon-cyan bg-neon-cyan/5 @break
                            @case('offer_received') text-neon-green bg-neon-green/5 @break
                            @case('rejected') text-red-400 bg-red-400/5 @break
                            @case('abandoned') text-gray-400 bg-gray-400/5 @break
                        @endswitch
                    ">{{ $candidature->statut_label }}</span>
                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity ml-2">
                        @can('update', $candidature)
                            <form action="{{ route('candidatures.restore', $candidature->id) }}" method="POST" onsubmit="return confirm('Restaurer cette candidature ?');" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-2 py-1 rounded bg-neon-cyan/10 border border-neon-cyan/30 text-neon-cyan hover:bg-neon-cyan/20 text-[10px] font-mono transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </form>
                        @endcan
                        @can('forceDelete', $candidature)
                            <form action="{{ route('candidatures.force-destroy', $candidature->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ? Cette action est irréversible.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 rounded bg-neon-orange/10 border border-neon-orange/30 text-neon-orange hover:bg-neon-orange/20 text-[10px] font-mono transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="text-text-dim font-mono text-xs mb-2">[INFO] Aucune candidature archivée</div>
                    <div class="text-text-dim font-mono text-xs">Les candidatures supprimées apparaîtront ici.</div>
                </div>
            @endforelse

            <div class="pt-3 mt-2 border-t border-dark-border flex items-center gap-2 text-[10px] text-text-dim font-mono">
                <span class="text-neon-green">●</span>
                <span>{{ $candidatures->count() }} entrée(s) ·</span>
                <span>[?] En attente · [>] Entretien · [+] Offre · [-] Refusé · [x] Abandonné</span>
            </div>
        </div>
    </div>
</x-app-layout>
