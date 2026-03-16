<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Turno
 * 
 * @property int $id
 * @property string|null $descripcion
 * 
 * @property Collection|Trabajadore[] $trabajadores
 *
 * @package App\Models
 */
class Turno extends Model
{
	protected $table = 'turnos';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function trabajadores()
	{
		return $this->hasMany(Trabajadore::class, 'turno');
	}
}
