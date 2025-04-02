<?php

namespace Apoliceplano\app\Http\Controllers;

use Apoliceplano\app\Modules\MotivoCancelamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MotivoCancelamentoController extends Controller
{
    /**
     * Exibe a página inicial do componente.
     */
    public function index(Request $request)
    {
        $screenHeight = $request->header('Screen-Height', 800);
        $itemHeight = 35;

        $itemsPerPage = (int)floor($screenHeight / $itemHeight);

        $motivoCancelamentos = MotivoCancelamento::search($request->search)->paginate($itemsPerPage);
        return Inertia::render('Packages/motivo-cancelamento/Components/TableMotivoCancelamento', compact('motivoCancelamentos'));
    }

    // Adicione métodos adicionais conforme necessário
}
