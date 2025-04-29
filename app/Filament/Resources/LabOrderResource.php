<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabOrderResource\Pages;
use App\Filament\Resources\LabOrderResource\RelationManagers;
use App\Models\LabOrder;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Infolist;
class LabOrderResource extends Resource
{
    protected static ?string $model = LabOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laboratory';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('patient_record_id')
                ->label('Patient Record ID')
                ->default(request()->get('patient_id'))
                ->required(),
            
            Forms\Components\TextInput::make('patient_name')
                ->default(request()->get('patient_name'))
                ->label('Patient Name')
                ->disabled()
                ->dehydrated(),
            
            Forms\Components\TextInput::make('doctor_name')
                ->default(request()->get('doctor_name'))
                ->label('Doctor Name')
                ->disabled()
                ->dehydrated(),

            Forms\Components\Textarea::make('lab_order')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')->searchable(),
                Tables\Columns\TextColumn::make('doctor_name'),
                Tables\Columns\TextColumn::make('lab_order'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('Create Lab Results')
                ->label('Add Lab Result')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->visible(fn () => Auth::user()?->hasRole('doctor'))
                ->url(fn ($record) => route('filament.admin.resources.lab-results.create', [
                    'lab_order_id' => $record->id,
                    'lab_order' => $record->lab_order,
                    'patient_name' => $record->patient_name,
                    'doctor_name' => Auth::user()->name,
                ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
    
                TextEntry::make('patient_name')
                    ->label('Patient Name :'),
    
                TextEntry::make('doctor_name')
                    ->label('Doctor Name :'),
    
                TextEntry::make('lab_order')
                    ->label('Lab Orders :')
                    ->markdown() // Optional, useful for formatting if it’s long
                    ->columnSpanFull(), // Optional for full width
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabOrders::route('/'),
            'create' => Pages\CreateLabOrder::route('/create'),
            'edit' => Pages\EditLabOrder::route('/{record}/edit'),
        ];
    }
}
