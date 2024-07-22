<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cliente;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use App\Filament\Resources\ClienteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\ClienteResource\RelationManagers;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->autofocus()
                    ->required()
                    ->columnSpan(12)
                    ->placeholder('Nombre Cliente')
                    ->extraInputAttributes(['style' => 'font-weight: bolder; font-size: 1.1rem;']),
                TextInput::make('nif')
                    ->placeholder('Introduce el NIF o DNI')
                    ->label("NIF")
                    ->required()
                    ->columnSpan(6),
                TextInput::make('provincia')
                    ->placeholder('Provincia')
                    ->columnSpan(6),
                TextInput::make('poblacion')
                    ->label("Población")
                    ->placeholder('Población')
                    ->columnSpan(6),
                TextInput::make('codigo_postal')
                    ->label('Código Postal')
                    ->placeholder('Código Postal')
                    ->columnSpan(6),
                TextInput::make('direccion')
                    ->label('Dirección')
                    ->placeholder('Dirección')
                    ->columnSpan(12),
                    
                
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('nombre')
                ->weight('bold')
                ->size('xl')
                ->color('primary')
                ->sortable()
                ->toggleable()
                // ->wrap()
                ->searchable(),
            TextColumn::make('direccion')
                ->sortable()
                ->toggleable()
                ->searchable(),
            TextColumn::make('poblacion')
                ->sortable()
                ->toggleable()
                ->searchable(),
            TextColumn::make('codigo_postal')
                ->sortable()
                ->toggleable()
                ->searchable(),
            TextColumn::make('provincia')
                ->sortable()
                ->toggleable()
                ->searchable(),
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
