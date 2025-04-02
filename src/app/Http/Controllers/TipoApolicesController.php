<?php

namespace Apoliceplano\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoApolicesController extends Controller
{
    /**
     * Exibe a página inicial do componente.
     */
    public function index()
    {
        return Inertia::render('Packages/tipo-apolices/Components/TableTipoApolices');
    }

    // Adicione métodos adicionais conforme necessário
}
