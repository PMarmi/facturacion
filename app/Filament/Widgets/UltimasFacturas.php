<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Factura;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimasFacturas extends BaseWidget
{
    public function table(Table $table): Table
    {
        $ultimId= Factura::max('id');
        // $ultimId -= 3; ELS 4 ÚLTIMS
        return $table
            ->query(
                Factura::query()
                ->where('id', '>=' , $ultimId)
                ->orderBy('id', 'DESC')
            )
            ->columns([
                TextColumn::make('id')
                ->sortable(),
                TextColumn::make('cliente.nombre')
                    ->weight('bold')
                    ->size('xl')
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('codigo_factura')
                    ->label('Código Factura'),
                        ]);
    }
}
