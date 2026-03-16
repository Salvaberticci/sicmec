<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MetodosPago
 * 
 * @property int $id
 * @property string|null $descripcion
 * 
 * @property Collection|Nomina[] $nominas
 * @property Collection|Pago[] $pagos
 *
 * @package App\Models
 */
class MetodosPago extends Model
{
	protected $table = 'metodos_pago';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function nominas()
	{
		return $this->hasMany(Nomina::class, 'metodo_pago_id');
	}

	public function pagos()
	{
		return $this->hasMany(Pago::class, 'metodo_pago_id');
	}
}
