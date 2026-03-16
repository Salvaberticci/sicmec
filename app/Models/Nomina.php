<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nomina
 * 
 * @property int $id
 * @property int|null $trabajador_id
 * @property int|null $metodo_pago_id
 * @property float|null $monto
 * @property string|null $observacion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Trabajadore|null $trabajadore
 * @property MetodosPago|null $metodos_pago
 *
 * @package App\Models
 */
class Nomina extends Model
{
	protected $table = 'nominas';

	protected $casts = [
		'trabajador_id' => 'int',
		'metodo_pago_id' => 'int',
		'monto' => 'float'
	];

	protected $fillable = [
		'trabajador_id',
		'metodo_pago_id',
		'monto',
		'observacion'
	];

	public function trabajadore()
	{
		return $this->belongsTo(Trabajadore::class, 'trabajador_id');
	}

	public function metodos_pago()
	{
		return $this->belongsTo(MetodosPago::class, 'metodo_pago_id');
	}
}
