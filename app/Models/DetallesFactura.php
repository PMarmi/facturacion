<?php

namespace App\Models;

use App\Models\Factura;
use App\Casts\EurosCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallesFactura extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'concepto',
        'unidades',
        'precio_unidad',
        'importe',
    ];

    protected $casts = [
        'precio_unidad' => EurosCast::class,
        'importe' => EurosCast::class,
    ];

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

}
