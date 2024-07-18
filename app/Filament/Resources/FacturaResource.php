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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use App\Filament\Resources\FacturaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\FacturaResource\RelationManagers;

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
                    ->unique()
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
                    ->options(Cliente::pluck('nombre', 'id'))
                    ,
                DatePicker::make('fecha')
                    ->required()
                    ->columnSpan(3),
                DatePicker::make('vencimiento')
                    ->columnSpan(3),
                TextInput::make('base_imponible')
                    ->readonly()
                    ->required()
                    ->placeholder('Campo no modificable')
                    ->columnSpan(3),
                TextInput::make('porcentaje_iva')
                    ->label('Procentaje IVA')
                    ->default(21)
                    ->required()
                    ->columnSpan(3),
                TextInput::make('cuota_iva')
                    ->label('Cuota IVA')
                    ->readonly()
                    ->required()
                    ->placeholder('Campo no modificable')
                    ->columnSpan(3),
                TextInput::make('total_factura')
                    ->live(onBlur: true)
                    ->readonly()
                    ->required()
                    ->placeholder('Campo no modificable')
                    ->columnSpan(3),
                
                    
                    // inici repeater
                Repeater::make('detallesFactura')
                    ->relationship()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $set('total_factura', array_sum(array_column($get('detallesFactura'),'importe')));
                    })

                    ->schema([
                        TextInput::make('concepto')
                        ->placeholder('Escriba aqui el concepto')
                        ->required()
                        ->columnSpan(12),
                        TextInput::make('unidades')
                            ->placeholder('Unidades')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                if (null == $get('unidades') || null == $get('precio_unidad')){
                                    $set('importe', 0);
                                } else {
                                    $parcial=$get('unidades') * $get('precio_unidad');
                                    $set('importe', $parcial );
                                    $set('../../total_factura', array_sum(array_column($get('../../detallesFactura'),'importe')));
                                }
                                })
                            ->numeric()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('precio_unidad')
                            ->placeholder('Precio por Unidad')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                if (null == $get('unidades') || null == $get('precio_unidad')){
                                    $set('importe', 0);
                                } else {
                                    $parcial=$get('unidades') * $get('precio_unidad');
                                    $set('importe', $parcial );
                                    $set('../../total_factura', array_sum(array_column($get('../../detallesFactura'),'importe')));
                                }
                                })
                            ->prefix('€')
                            ->numeric()
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('importe')
                            ->placeholder('Campo no modificable')
                            ->live(onBlur: true)
                            ->readonly()
                            ->prefix('€')
                            ->numeric()
                            ->required()
                            ->columnSpan(3),
                    ])
                    ->columns(12)->columnSpan(12)
                    // final repeater
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
                ->toggleable(),
                // ->wrap(),
            TextColumn::make('codigo_factura')
                ->sortable()
                ->toggleable()
                ->searchable(),
            TextColumn::make('fecha')
                ->sortable()
                ->toggleable(),
            TextColumn::make('vencimiento')
                ->sortable()
                ->toggleable(),
            TextColumn::make('base_imponible')
                ->sortable()
                ->toggleable(),
            TextColumn::make('porcentaje_iva')
                ->label('Porcentaje IVA')
                ->sortable()
                ->toggleable(),
            TextColumn::make('cuota_iva')
                ->label('Cuota IVA')
                ->sortable()
                ->toggleable(),
            TextColumn::make('total_factura')
                ->sortable()
                ->toggleable(),

            ])->defaultSort('id','desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->tooltip('Ver'),
                Tables\Actions\EditAction::make()->label('')->tooltip('Editar'),
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
