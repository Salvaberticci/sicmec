<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoMedicamento
 * 
 * @property int $id
 * @property string|null $descripcion
 *
 * @package App\Models
 */
class TipoMedicamento extends Model
{
	protected $table = 'tipo_medicamentos';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];
}
