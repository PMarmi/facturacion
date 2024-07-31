<?php

namespace App\Filament\Widgets;

use NumberFormatter;
use App\Models\Factura;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GeneralWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalFacturas=Factura::count();
        $ImporteTotalFacturas=Factura::sum('total_factura')/100;
        return [
            Stat::make('Facturas', $totalFacturas)
            ->icon('heroicon-o-clipboard-document-list')
            ->color('success')
            ->description('facturas emitidas')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ,
            Stat::make('Facturas', number_format($ImporteTotalFacturas, 2, ',', '.') . '€')
            ->description('Importe total todas las facturas')
            ->color('primary')
            ,
        ];
    }
}
