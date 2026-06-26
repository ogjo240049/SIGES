<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class inventario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_inventario';

    protected $fillable = [
        'nombre_pieza',
        'tipo_pieza',
        'cantidad',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
        ];
    }

    public function compras(): HasMany
    {
        return $this->hasMany(compras::class, 'id_inventario', 'id_inventario');
    }
}
