<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id
 * @property string|null $codigo
 * @property string|null $nombre_producto
 * @property string|null $existencia
 * @property string|null $presentacion
 * @property string|null $unidad
 * @property string|null $peso
 * @property string|null $tipo
 * 
 * @property Collection|FacturasRenglone[] $facturas_renglones
 *
 * @package App\Models
 */
class Producto extends Model
{
	protected $table = 'productos';
	public $timestamps = false;

	protected $fillable = [
		'codigo',
		'nombre_producto',
		'existencia',
		'presentacion',
		'unidad',
		'peso',
		'tipo'
	];

	public function facturas_renglones()
	{
		return $this->hasMany(FacturasRenglone::class);
	}

	public function tipo_ayudas()
	{
		return $this->belongsTo(TipoAyuda::class, 'presentacion', 'id');
	}

	public function tipo_medicamentos()
	{
		return $this->belongsTo(TipoMedicamento::class, 'presentacion', 'id');
	}

	public function tipo_insumo()
	{
		return $this->belongsTo(TipoInsumo::class, 'presentacion', 'id');
	}
}
