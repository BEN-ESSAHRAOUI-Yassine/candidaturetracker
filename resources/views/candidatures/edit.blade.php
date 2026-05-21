<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier la candidature') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">{{ $candidature->entreprise }} — {{ $candidature->poste }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-md p-6 sm:p-8">
                <form method="POST" action="{{ route('candidatures.update', $candidature) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <x-input-label for="entreprise" value="Entreprise *" />
                            <x-text-input id="entreprise" name="entreprise" type="text" class="mt-1 block w-full" :value="old('entreprise', $candidature->entreprise)" required />
                            <x-input-error :messages="$errors->get('entreprise')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="poste" value="Poste *" />
                            <x-text-input id="poste" name="poste" type="text" class="mt-1 block w-full" :value="old('poste', $candidature->poste)" required />
                            <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="offre_url" value="URL de l'offre" />
                            <x-text-input id="offre_url" name="offre_url" type="url" class="mt-1 block w-full" :value="old('offre_url', $candidature->offre_url)" placeholder="https://..." />
                            <x-input-error :messages="$errors->get('offre_url')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="statut" value="Statut *" />
                            <select id="statut" name="statut" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
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
                            <select id="priorite" name="priorite" required class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                <option value="high" {{ old('priorite', $candidature->priorite) == 'high' ? 'selected' : '' }}>Haute</option>
                                <option value="medium" {{ old('priorite', $candidature->priorite) == 'medium' ? 'selected' : '' }}>Moyenne</option>
                                <option value="low" {{ old('priorite', $candidature->priorite) == 'low' ? 'selected' : '' }}>Faible</option>
                            </select>
                            <x-input-error :messages="$errors->get('priorite')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date_candidature" value="Date de candidature *" />
                            <x-text-input id="date_candidature" name="date_candidature" type="date" class="mt-1 block w-full" :value="old('date_candidature', $candidature->date_candidature)" required />
                            <x-input-error :messages="$errors->get('date_candidature')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="document" value="Ajouter un document" />
                            <input id="document" name="document" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg shadow-sm" />
                            <x-input-error :messages="$errors->get('document')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">{{ old('notes', $candidature->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('candidatures.show', $candidature) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Annuler
                        </a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                            Mettre à jour
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>