<?php

namespace App\Models;

use App\Models\choferes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class vehiculos extends Model
{
    use HasFactory;

    protected $primaryKey = 'matricula';

    protected $fillable = [
        'nombre',
        'placa',
        'marca',
        'modelo',
        'motor',
        'serie',
        'concesionario',
    ];

    public function chofer(): HasOne
    {
        return $this->hasOne(choferes::class, 'unidad_asignada', 'matricula');
    }
}
