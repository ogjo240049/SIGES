<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class servicios extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'origen_viaje',
        'destino_viaje',
        'id_chofer',
        'fecha_pedido',
    ];

    protected function casts(): array
    {
        return [
            'id_chofer' => 'integer',
            'fecha_pedido' => 'date',
        ];
    }

    public function chofer(): BelongsTo
    {
        return $this->belongsTo(choferes::class, 'id_chofer', 'id_chofer');
    }
}
