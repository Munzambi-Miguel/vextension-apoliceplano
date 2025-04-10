<?php

namespace Apoliceplano\App\Modules;

use App\Http\API\CodeController;
use App\Models\Empresas\Empresas;
use App\Models\Planos\Planos;
use App\Models\Trait\ArrayColores;
use App\Models\Trait\Search;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Fluent;

/**
 * @method static paginate(int $itemsPerPage)
 * @method static allRelation()
 */
class ApolicePlano extends Model
{
    use Search;

    protected $table = 'apolice_plano';

    protected $fillable = [
        'uid',
        'codigo',
        'cancelamento',
        'codigo_motivo',
        'valor_limite',
        'colorContext',
        'data_fim',
        'data_inicio',
        'detalhes',
        'empresa',
        'moeda_corrente',
        'permisao_ggrats',
        'permisao_rem',
        'permisao_sreg',
        'plano',
        'regra_idoso',
        'status',
        'tipo_apolice',
        'tipo_fracionamento',
    ];

    public static function createData($data): self
    {
        $attribute = new Fluent($data);
        if ($attribute->uid) {
            $ttr = self::where('uid', $data['uid'])->first();
            $ttr->update($data);

            return $ttr;
        }

        return self::create($data);
    }

    public function planoApolice(): HasOne
    {
        return $this->hasOne(Planos::class, 'uid', 'plano');
    }

    public function planoInfo(): HasOne
    {
        return $this->hasOne(Planos::class, 'uid', 'plano');
    }

    public function empresaApolice()
    {
        return $this->hasOne(Empresas::class, 'uid', 'empresa');
    }

    public function scopeAllRelation($query)
    {
        return $query->with('planoApolice.coberturasInfo', 'empresaApolice');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->uuid) {
                $model->uid = uuid_create();
                if (is_null($model->codigo)) {
                    $model->codigo = CodeController::generateUniqueCodeUtil('ApolicePlano', 'METAPLP'.date('Y').'.');
                }
            }

            $model->data_fim = Carbon::parse($model->data_fim)->format('Y-m-d');
            $model->data_inicio = Carbon::parse($model->data_inicio)->format('Y-m-d');
            $model->cancelamento = Carbon::parse($model->cancelamento)->format('Y-m-d');
            $model->status = 1;

            $model->tbl_name = 'apolice_plano';
            $randomStatus = ArrayColores::$statusOptions[array_rand(ArrayColores::$statusOptions)]['id'];
            $model->colorContext = $randomStatus;
        });

        static::updating(function ($model) {
            $model->data_fim = Carbon::parse($model->data_fim)->format('Y-m-d');
            $model->data_inicio = Carbon::parse($model->data_inicio)->format('Y-m-d');
            $model->cancelamento = Carbon::parse($model->cancelamento)->format('Y-m-d');
        });

        static::retrieved(function ($model) {
            $model->data_fim = Carbon::parse($model->data_fim)->format('d-m-Y');
            $model->data_inicio = Carbon::parse($model->data_inicio)->format('d-m-Y');
            $model->cancelamento = Carbon::parse($model->cancelamento)->format('d-m-Y');
        });
    }
}
