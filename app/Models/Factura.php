<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Factura
 * 
 * @property int $id
 * @property int|null $cliente_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float|null $total_medicamentos
 * @property string|null $estatus
 * @property string|null $atendido_por
 * @property string|null $observacion
 * 
 * @property Cliente|null $cliente
 * @property Collection|FacturasRenglone[] $facturas_renglones
 * @property Collection|Pago[] $pagos
 *
 * @package App\Models
 */
class Factura extends Model
{
	protected $table = 'facturas';

	protected $casts = [
		'cliente_id' => 'int',
		'total_medicamentos' => 'float'
	];

	protected $fillable = [
		'cliente_id',
		'total_medicamentos',
		'estatus',
		'atendido_por',
		'observacion',
		'archivo_planilla',
		'medico_tratante',
		'patologia'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function facturas_renglones()
	{
		return $this->hasMany(FacturasRenglone::class);
	}

	public function pagos()
	{
		return $this->hasMany(Pago::class);
	}
}
