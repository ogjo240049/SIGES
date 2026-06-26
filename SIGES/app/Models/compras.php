<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class compras extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_compra';

    protected $fillable = [
        'id_inventario',
        'precio_unitario',
        'cantidad_compra',
        'fecha',
        'lugar_compra',
    ];

    protected function casts(): array
    {
        return [
            'id_inventario' => 'integer',
            'precio_unitario' => 'decimal:2',
            'cantidad_compra' => 'integer',
            'fecha' => 'date',
        ];
    }

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(inventario::class, 'id_inventario', 'id_inventario');
    }
}
