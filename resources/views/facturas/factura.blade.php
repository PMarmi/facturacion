<style>
    body {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 70,70707071%;
        height: 98%;
        /* border: 1px red solid; */
        display: flex;
        flex-direction: column;
    }

@media print {
    body {
        width: 98%;
        height: 141,43%;
    }
}
    footer {
    margin-top: auto;
    /* border: 1px red solid; */
    width: auto;
}
    header {
        display: grid;
        grid-template-columns: auto;
        grid-auto-rows: 50%;
        padding-bottom: 10%;
    }

    /* .client{
        grid-column-start: 1;
        grid-column-end: 1;
        background-color: blue;
    } */

    /* .zona {
        border: 3px red solid;
        min-height: 100px;
        display: flex;
        /* justify-content: space-between; */
        /* gap: 25px; */
    /* } */

    img {
        padding-top: 1%;
        width: 75%;
        /* height: 100%;   */
    }
    
    .zona1 {
        display: grid;
        grid-template-areas:
        "l l l a a a nombre"
        "l l l a a a cif"
        "l l l a a a direccion"
        "l l l a a a tel"
        "l l l a a a mail"
        ;
        grid-template-columns: repeat(7,1fr);
        width: 100%;
    }
    .zona1 div {
        width: 100%;
        /* border: 2px red solid; */
        text-align: left;
        /* grid-auto-columns: auto; */
    }
        .l {
            grid-area: l;
            padding-left: 2%;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
        .nombre {
            grid-area: nombre;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
        .direccion {
            grid-area: direccion;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
        .tel {
            grid-area: tel;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
        .mail {
            grid-area: mail;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
        .cif {
            grid-area: cif;
            /* border: 1px red solid; */
            /* margin: 0 auto; */
        }
    .informacio_venta {
        display: grid;
        grid-template-areas:
        "client a y z"
        "client a n z"
        "client a f z"
        "client a fecha_vencimiento z"
        "client a x z"
        "client a x z"
        "client a x z"
        "titulo titulo titulo titulo"
        ;
        width: 100%;
        padding-bottom: 2%;
        grid-template-columns: 33% 33% 33% 1%;
    }
    .informacio_venta div {
        width: 100%;
        /* border: 2px red solid; */
        /* grid-auto-columns: auto; */
    }
        .z {
            grid-area: z;
            /* border: 2px red solid; */
        }
        .n {
            grid-area: n;
            /* border: 1px red solid; */
            text-align: right;
            /* margin: 0 auto; */
        }
        .f {
            grid-area: f;
            /* border: 1px red solid; */
            text-align: right;
            /* margin: 0 auto; */
        }
        .fecha_vencimiento {
            grid-area: fecha_vencimiento;
            /* border: 1px red solid; */
            text-align: right;
        }
        .titulo {
            grid-area: titulo;
            /* border: 1px red solid; */
            text-align: center;
        }
        .client {
            grid-area: client;
            /* border: 1px red solid; */
        }
    th {
        text-align: left;
    }
    .aLaDerecha {
        text-align: right;
    }
    .factura_items {
        margin-left: 20px;
        margin-right: 20px;
        padding-bottom: 2%;
    }

    .factura_total {
        padding-left: 64%;
        text-align: left;
    }
    .footer {
    display: grid;
    grid-template-areas:
    "mensaje_footer_pagar"
    "datos_mercantil"
    "web";
    grid-gap: 10px;
    width: 100%;
    }
    .resumen_factura div {
        width: 100%;
        /* border: 2px red solid; */
    }
    footer {
        text-align: center;
    }
        .mensaje_footer_pagar {
            grid-area: mensaje_footer_pagar;
            /* border: 1px red solid; */
            color: gray;
        }
        .datos_mercantil {
            grid-area: datos_mercantil;
            /* border: 1px red solid; */
            color: gray;
        }
        .web {
            grid-area: web;
            /* border: 1px red solid; */
            color: blue;
        }
</style>

<!-- <style>
    .item1 { grid-area: header; }
    .item2 { grid-area: menu; }
    .item3 { grid-area: main; }
    .item4 { grid-area: right; }
    .item5 { grid-area: footer; }
    
    .grid-container {
        display: grid;
        grid-template-areas:
        'header header header header header header'
        'menu main main main right right'
        'menu footer footer footer footer footer';
        grid-gap: 10px;
        background-color: #2196F3;
      padding: 10px;
    }
    
    .grid-container > div {
      background-color: rgba(255, 255, 255, 0.8);
      text-align: center;
      padding: 20px 0;
      font-size: 30px;
    }
    </style> -->
    <!-- <div class="grid-container">
        <div class="item1">Header</div>
        <div class="item2">Menu</div>
        <div class="item3">Main</div>  
        <div class="item4">Right</div>
        <div class="item5">Footer</div>
      </div> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
</head>
<body>
    <header>
        <div class="zona1">
            <div class="l"><img src="/img/logo_robust.png"></div>
            <div class="nombre">Robust Data Solutions SL</div>
            <div class="cif">B13950753</div>
            <div class="direccion">C/ de la Sort, 5, 2º-2ª <br> Jorba (08719), España</div>
            <div class="tel">981728446</div>
            <div class="mail">info@robustdatasolutions.com</div>
            <!-- <div class="f">Fecha</div>
            <div class="n">Codigo factura</div> -->
        </div>        
        <!-- <div class="client"><img src="img/RDS-C+N-BIG.png"> </div> -->
    </header>
    <div class="informacio_venta">
        <div class="z">&nbsp;</div>
        <div class="titulo"><h2>Factura</h2></div>
        <!-- <div class="empresa">
            <div class="nombre">Robust Data Solutions</div>
            <div class="direccion">Jorba...</div>
            <div class="tel">981728446</div>
            <div class="mail">pau@robustdatasolutions.com</div>
            <div class="cif">CIF EMPRESA</div>
        </div> -->
        <div class="n">Codigo Factura: {{ $factura->codigo_factura }}</div>
        {{-- <div class="f">Fecha: {{ \Carbon\Carbon::parse($factura->fecha)->diffForHumans() }}</div> --}}
        <div class="f">Fecha: {{ \Carbon\Carbon::parse($factura->fecha)->translatedFormat('j / m / y') }}</div>
        <div class="fecha_vencimiento">Vencimiento: {{ \Carbon\Carbon::parse($factura->vencimiento)->translatedFormat('j / m / y') }}</div>
        <div class="client">
            <fieldset>
                <legend><b>Cliente</b></legend>
                <div class="nombre_c">{{ $factura->cliente->nombre }}</div>
                <div class="nif">{{ $factura->cliente->nif }}</div>
                <div class="direccion_c">{{ $factura->cliente->direccion }}</div>
                <div class="poblacion">{{ $factura->cliente->poblacion }}</div>
                <div class="provincia">{{ $factura->cliente->provincia }}</div>
                <div class="tel"> &nbsp; </div>
                <div class="mail"> &nbsp; </div>
            </fieldset>
        </div>
    </div>
    <table class="factura_items">
        <thead>
            <tr>
                <th style="width:50%">Concepto</th>
                <th style="width:10%">Unidades</th>
                <th style="width:20%" class="aLaDerecha">Precio Unidad</th>
                <th style="width:20%" class="aLaDerecha">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factura->detallesFactura as $detalle )
                <tr>
                    <td>{{ $detalle->concepto }}</td>
                    <td>{{ $detalle->unidades }}</td>
                    <td class="aLaDerecha">{{ Number::currency($detalle->precio_unidad, 'EUR', 'es') }}</td>
                    <td class="aLaDerecha">{{ Number::currency($detalle->importe, 'EUR', 'es')  }}</td>
                </tr>
            @endforeach
            <!-- solo dejar 1 tr en el body -->
        </tbody>
        <!-- <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td class="baseImpo aLaDerecha">Base Imponible</td>
                <td class="aLaDerecha">1.250</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="aLaDerecha">21% IVA</td>
                <td class="aLaDerecha">186</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="aLaDerecha">Total Factura</td>
                <td class="aLaDerecha">27545</td>
            </tr>
        </tfoot> -->
    </table>

    <table class="factura_total">
        <tr>
            <td><b>Base Imponible</b></td>
            <td>{{ Number::currency($factura->base_imponible, 'EUR', 'es')  }}</td>
        </tr>
        <tr>
            <td><b>{{ $factura->porcentaje_iva }}% IVA</b></td>
            <td>{{ Number::currency($factura->cuota_iva, 'EUR', 'es')  }}</td>
        </tr>
        <tr>
            <td><b>Total Factura</b></td>
            <td>{{ Number::currency($factura->total_factura, 'EUR', 'es')  }}</td>
        </tr>
    </table>

    <footer>
        <div class="footer">
            <div class="mensaje_footer_pagar"><font size="2"> Pagar por transferencia bancaria al siguiente número de cuenta IBAN ES58 0049 1875 5620 1016 6148 / SWIFT BSCHESMM</div>
            <div class="datos_mercantil">Inscrita en el Registro Mercantil de Barcelona, Tomo 48841 , Folio 58, Sección GENERAL, Hoja 598154 - CIF B13950753</div>
            <div class="web"><a href="https://robustdatasolutions.com">robustdatasolutions.com</a></div></font>
        </div>
    </footer>
</body>
</html>