<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientRecordResource\Pages;
use App\Filament\Resources\PatientRecordResource\RelationManagers;
use App\Models\PatientRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientRecordResource extends Resource
{
    protected static ?string $model = PatientRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Patient Information')->schema([
                    Forms\Components\TextInput::make('full_name')->required(),
                    Forms\Components\DatePicker::make('date_of_birth')->required(),
                    Forms\Components\TextInput::make('gender')->required(),
                    Forms\Components\TextInput::make('contact_number')->required(),
                    Forms\Components\TextInput::make('emergency_contact')->required(),
                ])->columns(2),
    
                Forms\Components\Section::make('Vital Signs')->schema([
                    Forms\Components\TextInput::make('temperature'),
                    Forms\Components\TextInput::make('pulse'),
                    Forms\Components\TextInput::make('respiration_rate'),
                    Forms\Components\TextInput::make('blood_pressure'),
                ])->columns(2),
    
                Forms\Components\Section::make('System Assessment')->schema([
                    Forms\Components\Textarea::make('general_appearance'),
                    Forms\Components\Textarea::make('head_eyes_ears_nose_throat'),
                    Forms\Components\Textarea::make('respiratory'),
                    Forms\Components\Textarea::make('cardiovascular'),
                    Forms\Components\Textarea::make('abdomen'),
                    Forms\Components\Textarea::make('musculoskeletal'),
                    Forms\Components\Textarea::make('neurological'),
                ])->columns(1),
    
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPatientRecords::route('/'),
            'create' => Pages\CreatePatientRecord::route('/create'),
            'view' => Pages\ViewPatientRecord::route('/{record}'),
            'edit' => Pages\EditPatientRecord::route('/{record}/edit'),
        ];
    }
}
