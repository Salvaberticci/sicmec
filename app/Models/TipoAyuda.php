<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoAyuda
 * 
 * @property int $id
 * @property string $descripcion
 *
 * @package App\Models
 */
class TipoAyuda extends Model
{
	protected $table = 'tipo_ayuda';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];
}
