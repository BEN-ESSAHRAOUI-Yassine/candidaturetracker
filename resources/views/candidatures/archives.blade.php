<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidatures archivées') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $candidature->poste }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Archivée le — {{ $candidature->deleted_at ? \Carbon\Carbon::parse($candidature->deleted_at)->format('d/m/Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <form action="{{ route('candidatures.restore', $candidature->id) }}" method="POST" onsubmit="return confirm('Restaurer cette candidature ?');" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Restaurer
                                    </button>
                                </form>
                                <form action="{{ route('candidatures.force-destroy', $candidature->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette candidature ? Cette action est irréversible.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer définitivement
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune candidature archivée</h3>
                        <p class="text-gray-500">Les candidatures que vous archivez apparaîtront ici.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('candidatures.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>