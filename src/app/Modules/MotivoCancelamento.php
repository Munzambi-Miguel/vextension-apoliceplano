<?php

namespace Apoliceplano\app\Modules;

use App\Http\API\CodeController;
use App\Models\Trait\ArrayColores;
use App\Models\Trait\Search;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;

/**
 * @method static search(mixed $search)
 */
class MotivoCancelamento extends Model
{
    use Search;

    protected $table = 'motivo_cancelamentos';

    protected $fillable = [
        'uid',
        'codigo',
        'designacao',
        'motivo_cancelamento',
        'colorContext',
        'detalhes',
    ];
    protected array $searchable = ['codigo', 'designacao', 'detalhes', 'motivo_cancelamento'];

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

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uid = uuid_create();
                if (is_null($model->codigo)) {
                    $model->codigo = CodeController::generateUniqueCodeUtil('MotivoCancelamento');
                }
            }

            $model->status = 1;

            $model->tbl_name = 'motivo_cancelamento';
            $randomStatus = ArrayColores::$statusOptions[array_rand(ArrayColores::$statusOptions)]['id'];
            $model->colorContext = $randomStatus;
        });
    }
}
