<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostMediaResource;
use App\Models\PostMedia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMediaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Supprimer un média
     */
    public function destroy(PostMedia $media): RedirectResponse
    {
        // Le model se charge de supprimer le fichier via l'event boot
        $media->delete();

        return back()->with('success', 'Média supprimé avec succès.');
    }

    /**
     * Changer l'ordre des médias (drag & drop)
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'medias' => 'required|array',
            'medias.*' => 'integer|exists:post_medias,id',
        ]);

        try {
            foreach ($validated['medias'] as $index => $mediaId) {
                PostMedia::findOrFail($mediaId)->update(['display_order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ordre des médias mis à jour.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'ordre.',
            ], 500);
        }
    }

    /**
     * Télécharger un média
     */
    public function download(PostMedia $media): StreamedResponse
    {
        if (!Storage::exists($media->path)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::download($media->path, $media->original_name);
    }

    /**
     * API: Lister les médias d'un article
     */
    public function list(Request $request, int $postId)
    {
        $medias = PostMedia::where('post_id', $postId)
            ->ordered()
            ->get();

        return response()->json(PostMediaResource::collection($medias));
    }
}
