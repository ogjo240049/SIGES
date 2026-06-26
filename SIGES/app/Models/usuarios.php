<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class usuarios extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'telefono',
        'rol',
    ];

    protected function casts(): array
    {
        return [
            'rol' => 'integer',
        ];
    }

    public function choferes(): HasMany
    {
        return $this->hasMany(choferes::class, 'id_usuario', 'id_usuario');
    }
}
