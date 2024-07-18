<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'codigo_factura',
        'fecha',
        'vencimiento',
        'base_imponible',
        'porcentaje_iva',
        'cuota_iva',
        'total_factura',
    ];

    // Relación entre facturaS y cliente
    // facturas N:1 cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detallesFactura(): HasMany
    {
        return $this->hasMany(DetallesFactura::class);
    }
}
