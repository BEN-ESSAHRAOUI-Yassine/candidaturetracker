<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('candidatures.index') }}" class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalCandidatures }}</p>
                            <p class="text-sm text-gray-500">Total candidatures</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('candidatures.index', ['statut' => 'to_review']) }}" class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">{{ $enAttente }}</p>
                            <p class="text-sm text-gray-500">En attente</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('candidatures.index', ['statut' => 'interview_scheduled']) }}" class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">{{ $entretiensPlanifies }}</p>
                            <p class="text-sm text-gray-500">Entretiens planifiés</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('candidatures.index', ['statut' => 'offer_received']) }}" class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">{{ $offresRecues }}</p>
                            <p class="text-sm text-gray-500">Offres reçues</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par statut</h3>
                    @php
                        $statutLabels = [
                            'to_review' => 'En attente',
                            'interview_scheduled' => 'Entretien planifié',
                            'offer_received' => 'Offre reçue',
                            'rejected' => 'Refusé',
                            'abandoned' => 'Abandonné',
                        ];
                        $statutColors = [
                            'to_review' => 'bg-yellow-100 text-yellow-800',
                            'interview_scheduled' => 'bg-blue-100 text-blue-800',
                            'offer_received' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'abandoned' => 'bg-gray-100 text-gray-800',
                        ];
                        $statutBarColors = [
                            'to_review' => 'bg-yellow-400',
                            'interview_scheduled' => 'bg-blue-400',
                            'offer_received' => 'bg-green-400',
                            'rejected' => 'bg-red-400',
                            'abandoned' => 'bg-gray-400',
                        ];
                        $maxStatut = max($statistiquesParStatut->toArray() ?: [1]);
                    @endphp
                    <div class="space-y-3">
                        @foreach ($statutLabels as $key => $label)
                            @php $count = $statistiquesParStatut->get($key, 0); @endphp
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statutColors[$key] }}">
                                        {{ $label }}
                                    </span>
                                    <span class="font-medium text-gray-700">{{ $count }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="{{ $statutBarColors[$key] }} h-2 rounded-full transition-all" style="width: {{ $maxStatut > 0 ? ($count / $maxStatut) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Dernières candidatures</h3>
                        <a href="{{ route('candidatures.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
                    </div>
                    @forelse ($candidaturesRecent as $candidature)
                        <a href="{{ route('candidatures.show', $candidature) }}" class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 -mx-2 px-2 rounded-lg transition">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $candidature->entreprise }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $candidature->poste }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium shrink-0 ml-2
                                @switch($candidature->statut)
                                    @case('to_review') bg-yellow-100 text-yellow-800 @break
                                    @case('interview_scheduled') bg-blue-100 text-blue-800 @break
                                    @case('offer_received') bg-green-100 text-green-800 @break
                                    @case('rejected') bg-red-100 text-red-800 @break
                                    @case('abandoned') bg-gray-100 text-gray-800 @break
                                @endswitch
                            ">
                                {{ $candidature->statut_label }}
                            </span>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-6">Aucune candidature pour le moment.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Prochains entretiens</h3>
                @forelse ($prochainsEntretiens as $entretien)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $entretien->candidature->entreprise }}</p>
                                <p class="text-xs text-gray-500">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium
                                        @switch($entretien->type)
                                            @case('telephone') bg-blue-100 text-blue-800 @break
                                            @case('technique') bg-purple-100 text-purple-800 @break
                                            @case('rh') bg-green-100 text-green-800 @break
                                            @case('final') bg-orange-100 text-orange-800 @break
                                        @endswitch
                                    ">{{ $entretien->type_label }}</span>
                                    {{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('candidatures.show', $entretien->candidature) }}" class="text-sm text-blue-600 hover:text-blue-800 shrink-0 ml-2">Voir</a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-6">Aucun entretien à venir.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>