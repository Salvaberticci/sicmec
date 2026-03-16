<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Trabajadore
 * 
 * @property int $id
 * @property string|null $cedula
 * @property string|null $nombre
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string|null $cargo
 * @property int|null $turno
 * 
 * @property Collection|Nomina[] $nominas
 *
 * @package App\Models
 */
class Trabajadore extends Model
{
	protected $table = 'trabajadores';
	public $timestamps = false;

	protected $casts = [
		'turno' => 'int'
	];

	protected $fillable = [
		'cedula',
		'nombre',
		'telefono',
		'direccion',
		'cargo',
		'turno'
	];

	public function turno()
	{
		return $this->belongsTo(Turno::class, 'turno');
	}

	public function nominas()
	{
		return $this->hasMany(Nomina::class, 'trabajador_id');
	}
}
