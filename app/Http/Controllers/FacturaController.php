<?php

namespace App\Http\Controllers;

use App\Models\DetallesFactura;
use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function mostrarFactura($id) { 
                              
        $data=Factura::find($id);
        $detallesdata=DetallesFactura::all()->where('factura_id',$id);

        return view('facturas.factura',[
            'factura' => $data,
            'detallesFactura' => $detallesdata
        ]);
                            
    } 
}
