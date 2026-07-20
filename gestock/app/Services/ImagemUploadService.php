<?php

namespace App\Services;

use App\Models\ArquivoImagem;
use Illuminate\Http\UploadedFile;

class ImagemUploadService
{
    private string $basePath;

    public function __construct()
    {
        $this->basePath = base_path('ImagensUpload');
    }

    public function upload(UploadedFile $file, string $tipo, int $entidadeId): ArquivoImagem
    {
        $imagemAntiga = $this->buscar($tipo, $entidadeId);

        if ($imagemAntiga) {
            $caminhoAntigo = base_path($imagemAntiga->caminho);

            if (file_exists($caminhoAntigo)) {
                unlink($caminhoAntigo);
            }
        }

        $dir = "{$this->basePath}/{$tipo}";

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $extension = $this->resolveExtension($file);
        $filename = "{$entidadeId}.{$extension}";
        $filePath = "{$dir}/{$filename}";

        $mimeType = $file->getMimeType();
        $tamanho = $file->getSize();

        $file->move($dir, $filename);

        $hash = md5_file($filePath);
        $relativePath = "ImagensUpload/{$tipo}/{$filename}";

        $imagem = ArquivoImagem::updateOrCreate(
            ['tipo' => $tipo, 'entidade_id' => $entidadeId],
            [
                'nome_arquivo' => $filename,
                'caminho' => $relativePath,
                'mime_type' => $mimeType,
                'tamanho' => $tamanho,
                'hash' => $hash,
            ]
        );

        return $imagem;
    }

    public function buscar(string $tipo, int $entidadeId): ?ArquivoImagem
    {
        return ArquivoImagem::where('tipo', $tipo)
            ->where('entidade_id', $entidadeId)
            ->first();
    }

    public function delete(string $tipo, int $entidadeId): bool
    {
        $imagem = $this->buscar($tipo, $entidadeId);

        if (! $imagem) {
            return false;
        }

        $filePath = base_path($imagem->caminho);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return (bool) $imagem->delete();
    }

    private function resolveExtension(UploadedFile $file): string
    {
        return $file->getClientOriginalExtension()
            ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION)
                ?: 'jpg';
    }
}
