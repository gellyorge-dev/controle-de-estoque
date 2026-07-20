<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\RegistroAuditoriaService;
use Illuminate\View\View;

class RegistroAuditoriaController extends Controller
{
    public function __construct(
        private readonly RegistroAuditoriaService $service
    ) {}

    public function index(): View
    {
        $registros = $this->service->paginate(50);

        return view('registros-auditoria.index', compact('registros'));
    }
}
