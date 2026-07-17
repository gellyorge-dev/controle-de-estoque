<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ImagemUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImagemUploadController extends Controller
{
    public function __construct(private readonly ImagemUploadService $service) {}

    public function upload(Request $request, string $tipo, int $entidadeId): RedirectResponse
    {
        $request->validate([
            'arquivo' => ['required', 'file', 'image'],
        ]);

        $this->service->upload($request->file('arquivo'), $tipo, $entidadeId);

        return back()->with('success', 'Imagem salva com sucesso.');
    }

    public function delete(string $tipo, int $entidadeId): RedirectResponse
    {
        $this->service->delete($tipo, $entidadeId);

        return back()->with('success', 'Imagem removida com sucesso.');
    }

    public function servir(string $tipo, int $entidadeId): BinaryFileResponse
    {
        $imagem = $this->service->buscar($tipo, $entidadeId);

        abort_unless($imagem, 404);

        $filePath = base_path($imagem->caminho);

        abort_unless(file_exists($filePath), 404);

        return response()->file($filePath);
    }
}
