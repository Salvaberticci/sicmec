<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoInsumo
 * 
 * @property int $id
 * @property string|null $descripcion
 *
 * @package App\Models
 */
class TipoInsumo extends Model
{
	protected $table = 'tipo_insumos';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];
}
