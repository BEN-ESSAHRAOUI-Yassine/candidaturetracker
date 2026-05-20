<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;
use App\Models\Candidature;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()
            ->candidatures()
            ->with(['entretiens', 'documents']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $candidatures = $query
            ->latest()
            ->get();

        return view('candidatures.index', compact('candidatures'));
    }

    public function create()
    {
        return view('candidatures.create');
    }

    public function store(StoreCandidatureRequest $request)
    {
        $candidature = auth()->user()
            ->candidatures()
            ->create($request->validated());

        if ($request->hasFile('document')) {

            $path = $request->file('document')
                ->store('documents', 'public');

            $candidature->documents()->create([
                'nom_fichier' => $request->file('document')->getClientOriginalName(),
                'chemin_stockage' => $path,
                'type_mime' => $request->file('document')->getMimeType()
            ]);
        }

        return redirect()
            ->route('candidatures.index')
            ->with('success', 'Candidature créée avec succès.');
    }

    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);

        $candidature->load(['entretiens','documents']);

        return view('candidatures.show', compact('candidature'));
    }

    public function edit(Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        return view('candidatures.edit', compact('candidature'));
    }

    public function update(UpdateCandidatureRequest $request,Candidature $candidature    )
    {
        $this->authorize('update', $candidature);

        $candidature->update($request->validated());

        if ($request->hasFile('document')) {

            $path = $request->file('document')
                ->store('documents', 'public');

            $candidature->documents()->create([
                'nom_fichier' => $request->file('document')->getClientOriginalName(),
                'chemin_stockage' => $path,
                'type_mime' => $request->file('document')->getMimeType()
            ]);
        }

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature modifiée.');
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);

        $candidature->delete();

        return redirect()
            ->route('candidatures.index')
            ->with('success', 'Candidature archivée.');
    }

    public function archives()
    {
        $candidatures = auth()->user()
            ->candidatures()
            ->onlyTrashed()
            ->latest()
            ->get();

        return view('candidatures.archives', compact('candidatures'));
    }

    public function restore($id)
    {
        $candidature = Candidature::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('update', $candidature);

        $candidature->restore();

        return redirect()
            ->route('candidatures.archives')
            ->with('success', 'Candidature restaurée.');
    }
}