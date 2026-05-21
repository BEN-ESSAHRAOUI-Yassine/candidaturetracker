<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes candidatures') }}
            </h2>
            <a href="{{ route('candidatures.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Nouvelle candidature
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('candidatures.index') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <x-input-label for="statut" value="Statut" />
                        <select name="statut" id="statut" class="mt-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
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
                        <select name="priorite" id="priorite" class="mt-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="">Toutes</option>
                            <option value="high" {{ request('priorite') == 'high' ? 'selected' : '' }}>Haute</option>
                            <option value="medium" {{ request('priorite') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="low" {{ request('priorite') == 'low' ? 'selected' : '' }}>Faible</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                            Filtrer
                        </x-primary-button>
                        @if (request()->has('statut') || request()->has('priorite'))
                            <a href="{{ route('candidatures.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                @forelse ($candidatures as $candidature)
                    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 hover:shadow-lg transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        {{ $candidature->entreprise }}
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @switch($candidature->priorite)
                                            @case('high') bg-red-100 text-red-800 @break
                                            @case('medium') bg-yellow-100 text-yellow-800 @break
                                            @case('low') bg-gray-100 text-gray-600 @break
                                        @endswitch
                                    ">
                                        {{ $candidature->priorite_label }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $candidature->poste }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Candidature du {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('candidatures.show', $candidature) }}" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir
                                </a>
                                <a href="{{ route('candidatures.edit', $candidature) }}" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </a>
                                <form action="{{ route('candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Archiver cette candidature ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                        Archiver
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune candidature</h3>
                        <p class="text-gray-500 mb-6">Commencez par créer votre première candidature.</p>
                        <a href="{{ route('candidatures.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Nouvelle candidature
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>