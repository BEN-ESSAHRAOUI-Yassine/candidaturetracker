<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEntretienRequest;
use App\Http\Requests\UpdateEntretienRequest;
use App\Models\Candidature;
use App\Models\Entretien;

class EntretienController extends Controller
{
    public function store(
        StoreEntretienRequest $request,
        Candidature $candidature
    ) {
        $this->authorize('update', $candidature);

        $candidature->entretiens()->create(
            $request->validated()
        );

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Entretien ajouté.');
    }

    public function edit(Entretien $entretien)
    {
        $this->authorize('update', $entretien);

        return view('entretiens.edit', compact('entretien'));
    }

    public function update(
        UpdateEntretienRequest $request,
        Entretien $entretien
    ) {
        $this->authorize('update', $entretien);

        $entretien->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'candidatures.show',
                $entretien->candidature
            )
            ->with('success', 'Entretien modifié.');
    }

    public function destroy(Entretien $entretien)
    {
        $this->authorize('delete', $entretien);

        $candidature = $entretien->candidature;

        $entretien->delete();

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Entretien supprimé.');
    }
}