<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $candidature->entreprise }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $candidature->poste }}</p>
            </div>
            <div class="flex items-center gap-2">
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
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 rounded-xl px-6 py-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Entreprise</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $candidature->entreprise }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Poste</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $candidature->poste }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Statut</dt>
                        <dd class="mt-1">
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
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Priorité</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($candidature->priorite)
                                    @case('high') bg-red-100 text-red-800 @break
                                    @case('medium') bg-yellow-100 text-yellow-800 @break
                                    @case('low') bg-gray-100 text-gray-600 @break
                                @endswitch
                            ">
                                {{ $candidature->priorite_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date de candidature</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</dd>
                    </div>
                    @if ($candidature->offre_url)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">URL de l'offre</dt>
                            <dd class="mt-1">
                                <a href="{{ $candidature->offre_url }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline inline-flex items-center gap-1">
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
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Notes</dt>
                        <dd class="text-sm text-gray-900 whitespace-pre-wrap">{{ $candidature->notes }}</dd>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Entretiens</h3>
                </div>

                @forelse ($candidature->entretiens as $entretien)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($entretien->type)
                                        @case('telephone') bg-blue-100 text-blue-800 @break
                                        @case('technique') bg-purple-100 text-purple-800 @break
                                        @case('rh') bg-green-100 text-green-800 @break
                                        @case('final') bg-orange-100 text-orange-800 @break
                                    @endswitch
                                ">
                                    {{ $entretien->type_label }}
                                </span>
                                <span class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y H:i') }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @switch($entretien->resultat)
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('positive') bg-green-100 text-green-800 @break
                                        @case('negative') bg-red-100 text-red-800 @break
                                    @endswitch
                                ">
                                    {{ $entretien->resultat_label }}
                                </span>
                            </div>
                            @if ($entretien->notes_preparation)
                                <p class="text-xs text-gray-500 mt-1">{{ $entretien->notes_preparation }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 ml-4 shrink-0">
                            <a href="{{ route('entretiens.edit', $entretien) }}" class="text-sm text-blue-600 hover:text-blue-800">Modifier</a>
                            <form action="{{ route('entretiens.destroy', $entretien) }}" method="POST" onsubmit="return confirm('Supprimer cet entretien ?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 py-4 text-center">Aucun entretien planifié.</p>
                @endforelse

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Ajouter un entretien</h4>
                    <form method="POST" action="{{ route('entretiens.store', $candidature) }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <x-input-label for="type" value="Type *" />
                            <select id="type" name="type" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                <option value="telephone">Téléphone</option>
                                <option value="technique">Technique</option>
                                <option value="rh">RH</option>
                                <option value="final">Final</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="date_entretien" value="Date *" />
                            <x-text-input id="date_entretien" name="date_entretien" type="datetime-local" class="mt-1 block w-full" :value="old('date_entretien')" required />
                            <x-input-error :messages="$errors->get('date_entretien')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="resultat" value="Résultat *" />
                            <select id="resultat" name="resultat" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                <option value="pending">En attente</option>
                                <option value="positive">Positif</option>
                                <option value="negative">Négatif</option>
                            </select>
                            <x-input-error :messages="$errors->get('resultat')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="notes_preparation" value="Notes de préparation" />
                            <textarea id="notes_preparation" name="notes_preparation" rows="2" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('notes_preparation') }}</textarea>
                            <x-input-error :messages="$errors->get('notes_preparation')" class="mt-2" />
                        </div>
                        <div class="sm:col-span-2 flex justify-end">
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-xs">
                                + Ajouter l'entretien
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Documents</h3>
                @forelse ($candidature->documents as $document)
                    <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <svg class="w-8 h-8 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $document->nom_fichier }}</p>
                                <p class="text-xs text-gray-500">{{ $document->type_mime }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4 shrink-0">
                            <a href="{{ route('documents.download', $document) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Télécharger
                            </a>
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <p class="text-sm text-gray-500">Aucun document attaché.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
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