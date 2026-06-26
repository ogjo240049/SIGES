<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bitacora extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bitacora';

    protected $fillable = [
        'id_chofer',
        'fecha_hora',
        'locacion',
    ];

    protected function casts(): array
    {
        return [
            'id_chofer' => 'integer',
            'fecha_hora' => 'datetime',
        ];
    }

    public function chofer(): BelongsTo
    {
        return $this->belongsTo(choferes::class, 'id_chofer', 'id_chofer');
    }
}
