<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioSistemaRequest;
use App\Http\Requests\UpdateUsuarioSistemaRequest;
use App\Models\UsuarioSistema;
use App\Services\ArquivoImagemService;
use App\Services\ImagemUploadService;
use App\Services\PerfilUsuarioService;
use App\Services\UsuarioSistemaService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioSistemaController extends Controller
{
    public function __construct(
        private readonly UsuarioSistemaService $service,
        private readonly PerfilUsuarioService $perfilService,
        private readonly ArquivoImagemService $imagemService,
        private readonly ImagemUploadService $imagemUploadService,
    ) {}

    public function index(): View
    {
        $usuarios = $this->service->paginate(50);
        $imagens = $this->imagemService->all();

        return view('usuarios-sistema.index', compact('usuarios', 'imagens'));
    }

    public function editLoggedUser(): View
    {
        $usuario = Auth::user();

        return view('perfil-usuario.index', compact('usuario'));
    }

    public function create(): View
    {
        $perfis = $this->perfilService->all();
        $imagens = $this->imagemService->all();

        return view('usuarios-sistema.create', compact('perfis', 'imagens'));
    }

    public function edit(int $id): View
    {
        $usuario = $this->service->findOrFail($id);
        $perfis = $this->perfilService->all();
        $imagens = $this->imagemService->all();

        return view('usuarios-sistema.create', compact('usuario', 'perfis', 'imagens'));
    }

    public function store(StoreUsuarioSistemaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['senha_usuario'] = bcrypt($data['senha_usuario']);

        if ($request->hasFile('arquivo')) {
            $usuario = $this->service->create($data);
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'perfil', $usuario->id);
            $usuario->update(['arquivo_imagem_id' => $imagem->id]);
        } else {
            $this->service->create($data);
        }

        return redirect()->route('usuarios-sistema.index');
    }

    public function update(UpdateUsuarioSistemaRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $usuario = $this->service->findOrFail($id);

        if (! empty($data['senha_usuario'])) {
            $data['senha_usuario'] = bcrypt($data['senha_usuario']);
        } else {
            unset($data['senha_usuario']);
        }

        $data['ativo'] = $request->boolean('ativo');

        if (! $data['ativo']) {
            $erro = $this->checkSelfDeactivation($id) ?? $this->checkLastAdminActive($id, $usuario->perfil_usuario_id);
            if ($erro) {
                return redirect()->route('usuarios-sistema.edit', $id)->with('error', $erro);
            }
        }

        if ($request->hasFile('arquivo')) {
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'perfil', $id);
            $data['arquivo_imagem_id'] = $imagem->id;
        }

        $this->service->update($id, $data);

        return redirect()->route('usuarios-sistema.index');
    }

    public function toggleActive(int $id): RedirectResponse
    {
        $usuario = $this->service->findOrFail($id);
        $novoStatus = ! $usuario->ativo;

        if (! $novoStatus) {
            $erro = $this->checkSelfDeactivation($id) ?? $this->checkLastAdminActive($id, $usuario->perfil_usuario_id);
            if ($erro) {
                return redirect()->route('usuarios-sistema.index')->with('error', $erro);
            }
        }

        $this->service->update($id, ['ativo' => $novoStatus]);

        return redirect()->route('usuarios-sistema.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        if ((int) Auth::id() === $id) {
            return redirect()->route('usuarios-sistema.index')->with('error', 'Você não pode excluir o próprio usuário.');
        }

        try {
            $this->imagemUploadService->delete('perfil', $id);
            $this->service->delete($id);
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                return redirect()->route('usuarios-sistema.index')->with('error', 'Não é possível excluir este usuário, pois existem registros de auditoria vinculados a ele.');
            }

            throw $e;
        }

        return redirect()->route('usuarios-sistema.index');
    }

    public function updateLoggedUser(Request $request): RedirectResponse
    {
        $usuario = Auth::user();

        $rules = [
            'senha_usuario' => ['nullable', 'string', 'min:8', 'confirmed'],
            'arquivo' => ['nullable', 'file', 'image'],
        ];

        if ($usuario->perfil_usuario_id === 1) {
            $rules['nome_usuario'] = ['required', 'string', 'max:150'];
            $rules['login_usuario'] = ['required', 'string', 'max:100', Rule::unique('usuario_sis', 'login_usuario')->ignore($usuario->id)];
        }

        $data = $request->validate($rules);

        if ($request->hasFile('arquivo')) {
            $imagem = $this->imagemUploadService->upload($request->file('arquivo'), 'perfil', $usuario->id);
            $data['arquivo_imagem_id'] = $imagem->id;
        }

        if (! empty($data['senha_usuario'])) {
            $data['senha_usuario'] = bcrypt($data['senha_usuario']);
        } else {
            unset($data['senha_usuario']);
        }

        $this->service->update($usuario->id, $data);

        return redirect('/perfil-usuario')->with('success', 'Perfil atualizado.');
    }

    private function checkSelfDeactivation(int $id): ?string
    {
        if ((int) Auth::id() === $id) {
            return 'Você não pode desativar o próprio usuário.';
        }

        return null;
    }

    private function checkLastAdminActive(int $id, int $perfilId): ?string
    {
        if ($perfilId === 1) {
            $adminsAtivos = UsuarioSistema::where('perfil_usuario_id', 1)
                ->where('ativo', true)
                ->where('id', '!=', $id)
                ->count();

            if ($adminsAtivos === 0) {
                return 'Não é possível desativar o único administrador ativo.';
            }
        }

        return null;
    }
}
