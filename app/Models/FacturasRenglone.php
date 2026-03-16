<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FacturasRenglone
 * 
 * @property int $id
 * @property int|null $factura_id
 * @property int|null $producto_id
 * @property float|null $cantidad
 * @property float|null $total_renglon
 * @property float|null $precio_unitario
 * @property string|null $producto_manual
 * 
 * @property Producto|null $producto
 * @property Factura|null $factura
 *
 * @package App\Models
 */
class FacturasRenglone extends Model
{
	protected $table = 'facturas_renglones';
	public $timestamps = false;

	protected $casts = [
		'factura_id' => 'int',
		'producto_id' => 'int',
		'cantidad' => 'float',
		'total_renglon' => 'float',
		'precio_unitario' => 'float'
	];

	protected $fillable = [
		'factura_id',
		'producto_id',
		'cantidad',
		'total_renglon',
		'precio_unitario',
		'producto_manual'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}

	public function factura()
	{
		return $this->belongsTo(Factura::class);
	}
}
