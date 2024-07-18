<?php

namespace App\Models;

use App\Models\Factura;
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

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

}
