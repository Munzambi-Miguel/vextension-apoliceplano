<?php

namespace Apoliceplano\app\Http\Controllers;

use Apoliceplano\app\Modules\ApoliceBeneficiario;
use Apoliceplano\app\Modules\ApolicePlano;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorDataRequest;
use App\Http\Requests\Utils\ModelController;
use App\Models\ActoClinico\RuleAprovation;
use App\Models\Beneficiario\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class ApolicePlanoController extends Controller
{
    /**
     * Exibe a página inicial do componente.
     */
    public function index(Request $request)
    {
        $screenHeight = $request->header('Screen-Height', 800);
        $itemHeight = 62;

        $itemsPerPage = (int)floor($screenHeight / $itemHeight);

        $apolicesPlano = ApolicePlano::allRelation()->paginate($itemsPerPage)->appends($request->all());

        $ruleApproval = RuleAprovation::all();

        $beneficiarioApolice = ApoliceBeneficiario::withAll()->where('apolice', $request->mltUd)->secondPaginate(20)->appends($request->all());
        return Inertia::render(
            'Packages/apolice-plano/Components/TableApolicePlano',
            compact('apolicesPlano', 'beneficiarioApolice', 'ruleApproval')
        );
    }

    public function store(StorDataRequest $request)
    {
        $data = ApolicePlano::createData($request['content']);
        return redirect()->route('ApolicePlano.index', ['key' => \Str::limit(encrypt($data), 20), 'mltUd' => $data->uid])->with([
            'success' => 'Post created successfully!'
        ]);
    }

  
    public function addBenApolice(StorDataRequest $request): void
    {


        $dataPersist = new Fluent($request['content']);
        if ($dataPersist->selectType === 'MarcaTodos') {
            $allBen = Beneficiario::query()->where('empresa', $dataPersist->empresa)->get();

            foreach ($allBen as $item) {
                // Verifica se já existe um registro para o beneficiário
                $apoliceBen = ApoliceBeneficiario::query()->where('beneficiario', $item->uid)->first();


                $data = [
                    'selectType' => $dataPersist->selectType,
                    'beneficiario' => $item->uid,
                    'regra' => 'TitularComDependentesApolice',
                    'apolice' => $dataPersist->apolice,
                ];

                try {
                    if (is_null($apoliceBen)) {
                        // Caso não exista, cria um novo registro
                        ApoliceBeneficiario::query()->create($data);
                    } else {
                        // Caso já exista, realiza a atualização
                        $apoliceBen->update($data);
                    }

                    $item->update(['apolice' => $request['apolice']]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }


        if ($dataPersist->selectType === 'SelectAlgunsTitular') {
            $allBen = Beneficiario::query()->where('empresa', $dataPersist->empresa)->where('tipoConta', 'PARM001')->get();
            foreach ($allBen as $item) {
                // Verifica se já existe um registro para o beneficiário
                $apoliceBen = ApoliceBeneficiario::query()->where('beneficiario', $item->uid)->first();

                $data = [
                    'selectType' => $dataPersist->selectType,
                    'beneficiario' => $item->uid,
                    'regra' => 'TitularApolice',
                    'apolice' => $dataPersist->apolice,
                ];
                try {
                    if (is_null($apoliceBen)) {
                        // Caso não exista, cria um novo registro
                        ApoliceBeneficiario::query()->create($data);
                    } else {
                        // Caso já exista, realiza a atualização
                        $apoliceBen->update($data);
                    }

                    $item->update(['apolice' => $request['apolice']]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        if ($dataPersist->selectType === 'SelectAlgunsDependentes') {
            $allBen = Beneficiario::query()->where('empresa', $dataPersist->empresa)->whereNot('tipoConta', 'PARM001')->get();
            foreach ($allBen as $item) {
                // Verifica se já existe um registro para o beneficiário
                $apoliceBen = ApoliceBeneficiario::query()->where('beneficiario', $item->uid)->first();

                $data = [
                    'selectType' => $dataPersist->selectType,
                    'beneficiario' => $item->uid,
                    'regra' => 'DepedentesApolice',
                    'apolice' => $dataPersist->apolice,
                ];

                try {
                    if (is_null($apoliceBen)) {
                        // Caso não exista, cria um novo registro
                        ApoliceBeneficiario::query()->create($data);
                    } else {
                        // Caso já exista, realiza a atualização
                        $apoliceBen->update($data);
                    }

                    $item->update(['apolice' => $request['apolice']]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }


        $apoliceBen = ApoliceBeneficiario::query()->where('beneficiario', $dataPersist->beneficiario)->first();
        $data = [
            'selectType' => $dataPersist->selectType,
            'beneficiario' => $dataPersist->beneficiario,
            'regra' => $dataPersist->regra,
            'apolice' => $dataPersist->apolice,
        ];

        try {
            if (is_null($apoliceBen)) {

                ApoliceBeneficiario::query()->create($data);
            } else {

                $apoliceBen->update($data);
            }
            $item = Beneficiario::where('uid', $dataPersist->beneficiario)->first();
            $item->update(['apolice' => $request['apolice']]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function newRule(StorDataRequest $request): void
    {
        $obj = new Fluent($request['content']);

        $this->validateRequest($obj->initial_rules, 'Data de início da regra não foi inserida', 'initial_rules');

        $this->validateRequest($obj->rule, 'regra não foi selecionada', 'rule');

        $this->validateRequest($obj->coluna, 'coluna não foi selecionada', 'coluna');

        $this->validateRequest($obj->notify, 'Detalhes não foi inserido', 'notify');

        RuleAprovation::createData($request['content']);
    }
}
