<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class choferes extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_chofer';

    protected $fillable = [
        'id_usuario',
        'unidad_asignada',
        'identificacion',
    ];

    protected function casts(): array
    {
        return [
            'id_usuario' => 'integer',
            'unidad_asignada' => 'integer',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(usuarios::class, 'id_usuario', 'id_usuario');
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(vehiculos::class, 'unidad_asignada', 'matricula');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(pagos::class, 'id_chofer', 'id_chofer');
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(servicios::class, 'id_chofer', 'id_chofer');
    }

    public function bitacoras(): HasMany
    {
        return $this->hasMany(bitacora::class, 'id_chofer', 'id_chofer');
    }
}
