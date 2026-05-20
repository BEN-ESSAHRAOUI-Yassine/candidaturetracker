<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        $this->authorize('view', $document->candidature);

        return Storage::disk('public')
            ->download(
                $document->chemin_stockage,
                $document->nom_fichier
            );
    }

    public function destroy(Document $document)
    {
        $this->authorize('update', $document->candidature);

        Storage::disk('public')
            ->delete($document->chemin_stockage);

        $document->delete();

        return redirect()
            ->back()
            ->with('success', 'Document supprimé.');
    }
}