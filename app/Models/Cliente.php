<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $id
 * @property string|null $cedula
 * @property string|null $nombre
 * @property string|null $telefono
 * @property string|null $direccion
 * @property float|null $saldo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $nro_expediente
 * @property string|null $ubch_centro_electoral
 * 
 * @property Collection|Factura[] $facturas
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';

	protected $casts = [
		'saldo' => 'float'
	];

	protected $fillable = [
		'cedula',
		'nombre',
		'telefono',
		'direccion',
		'saldo',
		'nro_expediente',
		'ubch_centro_electoral',
		'correo'
	];

	public function facturas()
	{
		return $this->hasMany(Factura::class);
	}
}
