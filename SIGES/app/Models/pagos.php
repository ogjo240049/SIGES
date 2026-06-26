<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pagos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_chofer',
        'fecha_pago',
        'monto_pago',
    ];

    protected function casts(): array
    {
        return [
            'id_chofer' => 'integer',
            'fecha_pago' => 'date',
            'monto_pago' => 'decimal:2',
        ];
    }

    public function chofer(): BelongsTo
    {
        return $this->belongsTo(choferes::class, 'id_chofer', 'id_chofer');
    }
}
