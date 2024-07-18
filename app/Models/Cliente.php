<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'nif',
        'direccion',
        'poblacion',
        'codigo_postal',
        'provincia'
    ];

    // Relación entre cliente y facturas
    // cliente 1:N facturaS
    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }
}