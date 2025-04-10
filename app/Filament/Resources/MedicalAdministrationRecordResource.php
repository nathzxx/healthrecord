<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalAdministrationRecordResource\Pages;
use App\Filament\Resources\MedicalAdministrationRecordResource\RelationManagers;
use App\Models\MedicalAdministrationRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicalAdministrationRecordResource extends Resource
{
    protected static ?string $model = MedicalAdministrationRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('PatientName')->required(),
                Forms\Components\TextInput::make('Doctor/Nurse')->required(),
                Forms\Components\TextInput::make(name: 'MedicationGiven')->required(),
                Forms\Components\TimePicker::make('Time')->required(),
                Forms\Components\DatePicker::make('Date')->required(),
                Forms\Components\TextInput::make('SideEffect')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'PatientName'),
                Tables\Columns\TextColumn::make('Doctor/Nurse'),
                Tables\Columns\TextColumn::make('MedicationGiven'),
                Tables\Columns\TextColumn::make('Time'),
                Tables\Columns\TextColumn::make('Date'),
                Tables\Columns\TextColumn::make('SideEffect'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicalAdministrationRecords::route('/'),
            'create' => Pages\CreateMedicalAdministrationRecord::route('/create'),
            'edit' => Pages\EditMedicalAdministrationRecord::route('/{record}/edit'),
        ];
    }
}
