<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();

        \App\Models\Cliente::create([
            "nombre"=> "Pau Marmi",
            "nif"=> "47131366L",
            "direccion"=> "Carratera Vella 22",
            "poblacion"=> "Jorba",
            "codigo_postal"=> "08719",
            "provincia"=> "Barcelona",
        ]);
        \App\Models\Factura::create([
            "cliente_id"=> "1",
            "codigo_factura"=> "00000F",
            'fecha' => fake()->date(),
            'vencimiento' => fake()->date(),
            "base_imponible"=> "100000",
            "porcentaje_iva"=> "2100",
            "cuota_iva"=> "21000",
            "total_factura"=> "121000",
        ]);

        \App\Models\DetallesFactura::create([
            "factura_id"=> "1",
            "concepto"=> "Patatas",
            "unidades"=> "2",
            "precio_unidad"=> "50000",
            "importe"=> "100000",

        ]);
        
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
