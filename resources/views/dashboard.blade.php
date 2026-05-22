<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-neon-green animate-pulse-glow"></span>
                    <span class="font-mono text-xs text-neon-green uppercase tracking-wider">Système opérationnel</span>
                </div>
                <span class="text-text-dim">|</span>
                <span class="font-mono text-xs text-text-dim" id="live-clock"></span>
            </div>
            <a href="{{ route('candidatures.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan uppercase tracking-wider hover:bg-neon-cyan/20 hover:border-neon-cyan/50 shadow-glow-sm transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle candidature
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @php
            $gaugeMax = max($totalCandidatures, 1);
            $gaugeData = [
                ['value' => $totalCandidatures, 'max' => $gaugeMax, 'label' => 'Total candidatures', 'color' => '#00d4ff', 'href' => route('candidatures.index')],
                ['value' => $enAttente, 'max' => $gaugeMax, 'label' => 'En attente', 'color' => '#eab308', 'href' => route('candidatures.index', ['statut' => 'to_review'])],
                ['value' => $entretiensPlanifies, 'max' => $gaugeMax, 'label' => 'Entretiens', 'color' => '#00d4ff', 'href' => route('candidatures.index', ['statut' => 'interview_scheduled'])],
                ['value' => $offresRecues, 'max' => $gaugeMax, 'label' => 'Offres reçues', 'color' => '#00e676', 'href' => route('candidatures.index', ['statut' => 'offer_received'])],
            ];
            $radius = 36;
            $circumference = 2 * pi() * $radius;
        @endphp

        <!-- Gauge Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($gaugeData as $i => $g)
                @php
                    $pct = $g['value'] / $g['max'];
                    $offset = $circumference - ($pct * $circumference);
                @endphp
                <a href="{{ $g['href'] }}"
                   class="glass rounded-2xl p-5 glass-hover animate-fade-up animate-fade-up-d{{ $i + 1 }} group">
                    <div class="flex items-center gap-4">
                        <div class="relative shrink-0">
                            <svg class="w-20 h-20 gauge-ring" viewBox="0 0 84 84">
                                <circle cx="42" cy="42" r="{{ $radius }}"
                                        stroke="rgba(255,255,255,0.04)" stroke-width="5"/>
                                <circle cx="42" cy="42" r="{{ $radius }}"
                                        stroke="{{ $g['color'] }}" stroke-width="5"
                                        stroke-dasharray="{{ $circumference }}"
                                        stroke-dashoffset="{{ $circumference }}"
                                        style="--target: {{ $offset }};"
                                        class="animate-ring"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="font-mono text-xl font-bold" style="color: {{ $g['color'] }}">{{ $g['value'] }}</span>
                            </div>
                        </div>
                        <div class="min-w-0">
                            <p class="font-mono text-xs text-text-muted group-hover:text-text-primary transition-colors">{{ $g['label'] }}</p>
                            <p class="font-mono text-[10px] text-text-dim mt-0.5">
                                {{ $g['max'] > 0 ? round($pct * 100) : 0 }}% du total
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Middle: Status Radar + Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Status Distribution -->
            <div class="lg:col-span-2 glass rounded-2xl p-6 animate-fade-up animate-fade-up-d5">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-mono text-xs text-text-muted uppercase tracking-widest">Répartition par statut</h3>
                    <span class="font-mono text-[10px] text-text-dim">{{ $totalCandidatures }} au total</span>
                </div>
                @php
                    $statutLabels = [
                        'to_review' => 'En attente',
                        'interview_scheduled' => 'Entretien planifié',
                        'offer_received' => 'Offre reçue',
                        'rejected' => 'Refusé',
                        'abandoned' => 'Abandonné',
                    ];
                    $statutColors = [
                        'to_review' => ['dot' => 'bg-yellow-400', 'bar' => 'bg-yellow-400', 'text' => 'text-yellow-400'],
                        'interview_scheduled' => ['dot' => 'bg-neon-cyan', 'bar' => 'bg-neon-cyan', 'text' => 'text-neon-cyan'],
                        'offer_received' => ['dot' => 'bg-neon-green', 'bar' => 'bg-neon-green', 'text' => 'text-neon-green'],
                        'rejected' => ['dot' => 'bg-red-400', 'bar' => 'bg-red-400', 'text' => 'text-red-400'],
                        'abandoned' => ['dot' => 'bg-gray-500', 'bar' => 'bg-gray-500', 'text' => 'text-gray-400'],
                    ];
                    $total = max($totalCandidatures, 1);
                @endphp
                <div class="space-y-3">
                    @foreach ($statutLabels as $key => $label)
                        @php $count = $statistiquesParStatut->get($key, 0); @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="flex items-center gap-2 font-mono text-xs text-text-muted">
                                    <span class="status-dot {{ $statutColors[$key]['dot'] }}"></span>
                                    {{ $label }}
                                </span>
                                <span class="flex items-center gap-2">
                                    <span class="font-mono text-xs text-text-primary">{{ $count }}</span>
                                    <span class="font-mono text-[10px] text-text-dim w-8 text-right">{{ round(($count / $total) * 100) }}%</span>
                                </span>
                            </div>
                            <div class="w-full bg-dark-elevated rounded-full h-2 overflow-hidden">
                                <div class="{{ $statutColors[$key]['bar'] }} h-2 rounded-full transition-all duration-1000"
                                     style="width: {{ ($count / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="glass rounded-2xl p-6 animate-fade-up animate-fade-up-d5">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-mono text-xs text-text-muted uppercase tracking-widest">Activité récente</h3>
                    <a href="{{ route('candidatures.index') }}" class="font-mono text-[10px] text-neon-cyan hover:text-neon-cyan/80 transition">Voir tout</a>
                </div>
                <div class="space-y-0">
                    @forelse ($candidaturesRecent as $candidature)
                        @php
                            $daysAgo = now()->diffInDays($candidature->created_at);
                            $timeAgo = $daysAgo == 0 ? "Aujourd'hui" : ($daysAgo == 1 ? 'Hier' : "Il y a {$daysAgo}j");
                        @endphp
                        <a href="{{ route('candidatures.show', $candidature) }}" class="flex items-start gap-3 py-3 {{ !$loop->last ? 'border-b border-dark-border' : '' }} group">
                            <div class="relative mt-1">
                                <span class="status-dot block
                                    @switch($candidature->statut)
                                        @case('to_review') bg-yellow-400 @break
                                        @case('interview_scheduled') bg-neon-cyan @break
                                        @case('offer_received') bg-neon-green @break
                                        @case('rejected') bg-red-400 @break
                                        @case('abandoned') bg-gray-400 @break
                                    @endswitch
                                "></span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-mono text-sm text-text-primary group-hover:text-neon-cyan transition-colors truncate">{{ $candidature->entreprise }}</p>
                                <p class="font-mono text-xs text-text-muted truncate">{{ $candidature->poste }}</p>
                            </div>
                            <span class="font-mono text-[10px] text-text-dim shrink-0 mt-0.5">{{ $timeAgo }}</span>
                        </a>
                    @empty
                        <p class="font-mono text-xs text-text-muted text-center py-8">Aucune activité</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Interviews with Countdown -->
        <div class="glass rounded-2xl p-6 animate-fade-up animate-fade-up-d6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <h3 class="font-mono text-xs text-text-muted uppercase tracking-widest">Prochains entretiens</h3>
                    <span class="font-mono text-[10px] text-text-dim bg-dark-elevated px-2 py-0.5 rounded">{{ $prochainsEntretiens->count() }} planifiés</span>
                </div>
            </div>

            @forelse ($prochainsEntretiens as $entretien)
                @php
                    $date = \Carbon\Carbon::parse($entretien->date_entretien);
                    $now = now();
                    $diffDays = $now->diffInDays($date, false);
                    $diffHours = $now->diffInHours($date, false);
                    $isPast = $diffDays < 0;
                    $countdownText = $isPast ? 'Passé' : ($diffDays > 0 ? "J-{$diffDays}" : ($diffHours > 0 ? "Dans {$diffHours}h" : "Aujourd'hui"));
                    $urgencyClass = $isPast ? 'bg-gray-500/10 text-gray-400' : ($diffDays <= 2 && !$isPast ? 'bg-neon-orange/10 text-neon-orange' : 'bg-neon-cyan/10 text-neon-cyan');
                @endphp
                <div class="flex items-center gap-4 py-4 {{ !$loop->last ? 'border-b border-dark-border' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <span class="w-3 h-3 rounded-full {{ $isPast ? 'bg-gray-500' : 'bg-neon-cyan' }} {{ $isPast ? '' : 'animate-pulse-glow' }}"></span>
                        @if (!$loop->last)
                            <div class="w-px flex-1 bg-dark-border mt-1"></div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-mono text-sm font-medium text-text-primary">{{ $entretien->candidature->entreprise }}</span>
                            <span class="font-mono text-xs text-neon-cyan bg-neon-cyan/5 px-2 py-0.5 rounded
                                @switch($entretien->type)
                                    @case('telephone') text-neon-cyan bg-neon-cyan/5 @break
                                    @case('technique') text-purple-400 bg-purple-500/10 @break
                                    @case('rh') text-neon-green bg-neon-green/5 @break
                                    @case('final') text-neon-orange bg-neon-orange/5 @break
                                @endswitch
                            ">{{ $entretien->type_label }}</span>
                        </div>
                        <p class="font-mono text-xs text-text-muted mt-0.5">{{ $entretien->candidature->poste }}</p>
                        <p class="font-mono text-[10px] text-text-dim mt-0.5">{{ $date->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="shrink-0 text-right">
                        <span class="countdown-badge {{ $urgencyClass }}">{{ $countdownText }}</span>
                        <br>
                        <a href="{{ route('candidatures.show', $entretien->candidature) }}" class="font-mono text-[10px] text-neon-cyan hover:text-neon-cyan/80 transition mt-1 inline-block">Voir →</a>
                    </div>
                </div>
            @empty
                <p class="font-mono text-xs text-text-muted text-center py-8">Aucun entretien à venir.</p>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const str = now.toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' })
                + ' ' + now.toLocaleTimeString('fr-FR');
            const el = document.getElementById('live-clock');
            if (el) el.textContent = str;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @endpush
</x-app-layout>
