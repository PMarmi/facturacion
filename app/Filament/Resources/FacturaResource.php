<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cliente;
use App\Models\Factura;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Enums\ActionsPosition;
use App\Filament\Resources\FacturaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\FacturaResource\RelationManagers;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class FacturaResource extends Resource
{
    protected static ?string $model = Factura::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    TextInput::make('codigo_factura')
                        ->autofocus()
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->placeholder('Codigo de Factura')
                        ->columnSpan(3),
                    Select::make('cliente_id')
                        // ->relationship('cliente','nombre')
                        // relationship(nombre_relación,campo_a_mostrar)
                        ->label('Cliente')
                        ->searchable()
                        ->required()
                        ->columnSpan(3)
                        ->options(Cliente::pluck('nombre', 'id')),
                    DatePicker::make('fecha')
                        ->required()
                        ->default(now()->format('d-m-Y'))
                        ->columnSpan(3),
                    DatePicker::make('vencimiento')
                        ->columnSpan(3),
                    
                    
                    // inici repeater
                    TableRepeater::make('detallesFactura')
                        ->relationship()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            // se ejecuta cuando se elimina una línea del repeater
                            $set('base_imponible', round(array_sum(array_column($get('detallesFactura'),'importe'))),2);
                            $set('cuota_iva', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva') / 100,2));  
                            $set('total_factura', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) + round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva') / 100,2),2));
                        })
                        // Añadir los que faltan

                        ->schema([
                            TextInput::make('concepto')
                                ->placeholder('Escriba aqui el concepto')
                                ->required()
                                ->columnSpan(4),
                            TextInput::make('unidades')
                                ->placeholder('Unidades')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                        if (null == $get('unidades') || null == $get('precio_unidad')){
                                            $set('importe', 0);
                                        } else {
                                            $parcial=round($get('unidades') * $get('precio_unidad'),2);
                                            $set('importe', $parcial );
                                            $baseImponible=round(array_sum(array_column($get('../../detallesFactura'),'importe')),2);
                                            $set('../../base_imponible', $baseImponible);
                                            $cuotaIva=round($baseImponible * $get('../../porcentaje_iva') / 100,2);
                                            $set('../../cuota_iva', $cuotaIva);
                                            $totalFactura=round($baseImponible + $cuotaIva,2);
                                            $set('../../total_factura', $totalFactura);
                                        }
                                        })
                                    ->numeric()
                                    ->integer()
                                    ->required()
                                    ->validationMessages([
                                        'integer' => 'El :attribute ha de ser sencer.',
                                    ])
                                    // ->step(1)
                                    ->columnSpan(1),
                            TextInput::make('precio_unidad')
                                ->placeholder('Precio por Unidad')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    if (null == $get('unidades') || null == $get('precio_unidad')){
                                        $set('importe', 0);
                                    } else {
                                        $parcial=round($get('unidades') * $get('precio_unidad'),2);
                                        $set('importe', $parcial );
                                        $baseImponible=round(array_sum(array_column($get('../../detallesFactura'),'importe')),2);
                                        $set('../../base_imponible', $baseImponible);
                                        $cuotaIva=round($baseImponible * $get('../../porcentaje_iva') / 100,2);
                                        $set('../../cuota_iva', $cuotaIva);
                                        $totalFactura=round($baseImponible + $cuotaIva,2);
                                        $set('../../total_factura', $totalFactura);
                                    }
                                    })
                                    ->prefix('€')
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(1),
                            TextInput::make('importe')
                                ->placeholder('---------------------')
                                ->live(onBlur: true)
                                ->readonly()
                                ->prefix('€')
                                ->numeric()
                                ->required()
                                ->columnSpan(1),
                                ])
                                ->colStyles(function () {
                                    return [
                                'concepto' => 'width: 500px;',
                                'unidades' => 'width: 150px;',
                            ];
                    })
                    ->columns(12),
                    // ->columnSpan(12)
                    // final repeater

                    // Section::make('Contenedor')
                    //     ->schema([
                    //             // Placeholder::make('elemento01'),
                    //             // Placeholder::make('elemento02'),
                    //             // Placeholder::make('elemento03'),
                    //         TextInput::make('base_imponible')
                    //             ->live(onBlur: true)
                    //             ->inlinelabel()
                    //             ->numeric()
                    //             ->extraInputAttributes([
                    //                 'style' => 'text-align: right;'
                    //             ])
                    //             ->readonly()
                    //             ->placeholder('------------------------------------------')
                    //             ->columnSpan(4),
                    //         TextInput::make('porcentaje_iva')
                    //         ->afterStateUpdated(function (Get $get, Set $set) {
                    //             // se ejecuta cuando se elimina una línea del repeater
                    //             $set('base_imponible', round(array_sum(array_column($get('detallesFactura'),'importe'))),2);
                    //             $set('cuota_iva', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva') / 100,2));  
                    //             $set('total_factura', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) + round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva') / 100,2),2));
                    //         })
                    //         ->live(onBlur: true)
                    //         ->inlinelabel()
                    //         ->label('Procentaje IVA')
                    //         ->default(21)
                    //         ->extraInputAttributes([
                    //             'style' => 'text-align: right;'
                    //         ])
                    //         ->columnSpan(4),
                    //     ])
                    //     ->extraAttributes([
                    //         'style' => 'display: grid; grid-auto-rows: min-content; grid-template-columns: 60% 40%;'
                    //     ])
                    //     ,
                    Placeholder::make('')
                        ->columnSpan(8),
                    TextInput::make('base_imponible')
                        ->live(onBlur: true)
                        ->numeric()
                        ->inlinelabel()
                        ->extraInputAttributes([
                            'style' => 'text-align: right;'
                        ])
                        ->readonly()
                        ->placeholder('------------------------------------------')
                        ->columnSpan(4),
                    Placeholder::make('')
                        ->columnSpan(8),
                    TextInput::make('porcentaje_iva')
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            // se ejecuta cuando se elimina una línea del repeater
                            // if (null !== $get('porcentaje_iva')){
                                # 
                                $set('base_imponible', round(array_sum(array_column($get('detallesFactura'),'importe'))),2);
                                $set('cuota_iva', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva')) / 100,2);  
                                $set('total_factura', round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) + round(round(array_sum(array_column($get('detallesFactura'),'importe')),2) * $get('porcentaje_iva') / 100,2),2));
                            // } else {
                            //     $set('total_factura',77);
                            // }
                        })
                        ->live(onBlur: true)
                        ->required()
                        ->numeric()
                        // ->minValue(0)
                        ->rules("min:0")
                        ->inlinelabel()
                        ->label('Procentaje IVA')
                        ->default(21)
                        ->extraInputAttributes([
                            'style' => 'text-align: right;'
                        ])
                        ->columnSpan(4),
                    Placeholder::make('')
                        ->columnSpan(8),
                    TextInput::make('cuota_iva')
                        ->live(onBlur: true)
                        ->inlinelabel()
                        ->numeric()
                        ->extraInputAttributes([
                            'style' => 'text-align: right;'
                        ])
                        ->label(fn (Get $get) => 'IVA ' . $get('porcentaje_iva') . '%')
                        ->readonly()
                        ->placeholder('------------------------------------------')
                        ->columnSpan(4),
                    Placeholder::make('')
                        ->columnSpan(8),
                    TextInput::make('total_factura')
                        ->live(onBlur: true)
                        ->numeric()
                        ->inlinelabel()
                        ->readonly()
                        ->extraInputAttributes([
                            'style' => 'text-align: right; font-weight: bolder; font-size: 1.1rem;'
                        ])
                        // ->required()
                        ->placeholder('------------------------------------------')
                        ->columnSpan(4)
                    ])->columns(12);
                }
                
    public static function table(Table $table): Table
                {
                    return $table
                    ->columns([
                        TextColumn::make('id')
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('cliente.nombre')
                            ->weight('bold')
                            ->size('xl')
                            ->color('primary')
                            ->sortable()
                            // ->wrap()
                            ->toggleable(),
                        TextColumn::make('codigo_factura')
                            ->label('Código Factura')
                            ->sortable()
                            ->toggleable()
                            ->searchable(),
                        TextColumn::make('fecha')
                            ->sortable()
                            ->default(now()->format('d-m-Y'))
                            ->toggleable(),
                        TextColumn::make('vencimiento')
                            ->sortable()
                            ->toggleable(),
                        TextColumn::make('base_imponible')
                            ->sortable()
                            ->money('eur')
                            ->alignEnd()
                            ->toggleable(),
                        TextColumn::make('porcentaje_iva')
                            ->label('Porcentaje IVA')
                            ->sortable()
                            ->toggleable()
                            ->alignEnd(),
                        TextColumn::make('cuota_iva')
                            ->label('Cuota IVA')
                            ->sortable()
                            ->money('eur')
                            ->alignEnd()
                            ->toggleable(),
                        TextColumn::make('base_imponible')
                            ->sortable()
                            ->money('eur')
                            ->alignEnd()
                            ->toggleable(),
                        TextColumn::make('total_factura')
                            ->sortable()
                            ->toggleable()
                            // ->numeric(2),
                            ->money('eur')
                            ->alignEnd(),

            ])->defaultSort('id','desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->tooltip('Ver'),
                Tables\Actions\EditAction::make()->label('')->tooltip('Editar'),
                Action::make('pepe')->label('')->tooltip('Imprimir')
                ->icon('heroicon-o-printer')
                ->url(fn (Factura $record) => 'mostrarFactura/' . $record->id)
                ->openUrlInNewTab(),
            ],position: ActionsPosition::BeforeColumns)->recordUrl(null)->striped()
            ->bulkActions([
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacturas::route('/'),
            'create' => Pages\CreateFactura::route('/create'),
            'view' => Pages\ViewFactura::route('/{record}'),
            'edit' => Pages\EditFactura::route('/{record}/edit'),
        ];
    }
}
