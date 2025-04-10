<?php

namespace Apoliceplano\App\Modules;

use App\Models\Beneficiario\Beneficiario;
use App\Models\Trait\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @method static withAll()
 */
class ApoliceBeneficiario extends Model
{
    use Search;

    protected $table = 'apolice_beneficiarios';

    protected $fillable = [
        'uid',
        'beneficiario',
        'regra',
        'apolice',
        'selectType',
        'tbl_name',
    ];

    protected $searchable = ['beneficiario', 'regra', 'apolice', 'selectType'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->uuid) {
                $model->uid = uuid_create();
            }

            $model->status = 1;
            $model->tbl_name = 'apolice_beneficiario';

            Log::channel('vappsaude')
                ->info('ApoliceBeneficiario está sendo criado: '
                .$model->beneficiario.' - '.Auth::user()->name, ['model' => 'apolice-beneficiarios_create']);

        });

        static::deleting(function ($model) {

            $beneficairio = Beneficiario::query()->where('uid', $model->beneficiario)
                ->first();

            $beneficairio->update(['apolice' => null]);

            //  \Log::info('ApoliceBeneficiario está sendo excluído: '.$model->id.' - '.auth()->user()->name);
        });

        static::deleted(function ($model) {

            Log::channel('vappsaude')->info('ApoliceBeneficiario está foi excluído: '
            .$model->id.' - '.Auth::user()->name, ['model' => 'apolice-beneficiarios_delete']);

        });
    }

    public function scopeWithAll($query)
    {
        return $query->with('getBeneficiario');
    }

    public function getBeneficiario(): HasOne
    {
        return $this->hasOne(Beneficiario::class, 'uid', 'beneficiario');
    }

    public function scopeSecondPaginate(Builder $query, $perPage = null, $columns = ['*'], $pageName = 'second_page', $page = null): LengthAwarePaginator
    {
        $perPage = $perPage ?: $this->getPerPage();

        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $total = $query->toBase()->getCountForPagination();

        $results = $total
            ? $query->forPage($page, $perPage)->get($columns)
            : collect();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    protected function paginator($items, $total, $perPage, $currentPage, array $options): LengthAwarePaginator
    {
        return new LengthAwarePaginator($items, $total, $perPage, $currentPage, $options);

    }
}
