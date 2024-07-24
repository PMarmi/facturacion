<?php

namespace App\Models;

use App\Casts\EurosCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'base_imponible' => EurosCast::class,
        'porcentaje_iva' => EurosCast::class,
        'cuota_iva' => EurosCast::class,
        'total_factura' => EurosCast::class,
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
