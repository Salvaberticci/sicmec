<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 * 
 * @property int $id
 * @property int|null $factura_id
 * @property int|null $metodo_pago_id
 * @property float|null $monto
 * @property string|null $referencia
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property MetodosPago|null $metodos_pago
 * @property Factura|null $factura
 *
 * @package App\Models
 */
class Pago extends Model
{
	protected $table = 'pagos';

	protected $casts = [
		'factura_id' => 'int',
		'metodo_pago_id' => 'int',
		'monto' => 'float'
	];

	protected $fillable = [
		'factura_id',
		'metodo_pago_id',
		'monto',
		'referencia'
	];

	public function metodos_pago()
	{
		return $this->belongsTo(MetodosPago::class, 'metodo_pago_id');
	}

	public function factura()
	{
		return $this->belongsTo(Factura::class);
	}
}
