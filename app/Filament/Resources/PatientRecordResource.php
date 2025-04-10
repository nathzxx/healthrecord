<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientRecordResource\Pages;
use App\Filament\Resources\PatientRecordResource\RelationManagers;
use App\Models\PatientRecord;
use Filament\Forms;

use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Infolist;
class PatientRecordResource extends Resource
{
    protected static ?string $model = PatientRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Patient Information')->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('email')->required()->email(),
                    Forms\Components\DatePicker::make('birthday')->required()->native(false),
                    Forms\Components\Select::make('gender')->required()
                    ->options([
                        'male'=>'Male',
                        'female'=>'Female'
                    ]),
                    Forms\Components\TextInput::make('contactnumber')
                    ->required()
                    ->label('Contact Number')
                    ->maxLength(11)
                    ->rule('regex:/^[0-9]{10,11}$/')
                    ->extraAttributes([
                        'inputmode' => 'numeric', // Mobile numeric keyboard
                        'pattern' => '[0-9]*', ]),

                    Forms\Components\TextInput::make('emergency_contact')
                    ->required()
                    ->maxLength(11)
                    ->rule('regex:/^[0-9]{10,11}$/')
                    ->extraAttributes([
                        'inputmode' => 'numeric', // Mobile numeric keyboard
                        'pattern' => '[0-9]*', ]),
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
    
                Forms\Components\Section::make('Nursing Notes')->schema([
                    Forms\Components\Textarea::make('observations'),
                    Forms\Components\Textarea::make('recommendations'),
                    Forms\Components\TextInput::make('nurse_name')
                        ->default(fn () => Auth::user()->name)
                        ->disabled()
                        ->dehydrated(), 
                    Forms\Components\DatePicker::make('date')
                        ->default(now())
                        ->disabled()
                        ->dehydrated(), 
                ]),
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Patient ID')
                    ->searchable(),
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
                SelectFilter::make('gender')
                ->options([
                'male' => 'Male',
                'female' => 'Female',
            ])->label('Gender'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Patient Information
                Section::make('Patient Information')->schema([
                    TextEntry::make('name')
                        ->label('Full Name:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('birthday')
                        ->label('Date of Birth:')
                        ->date()
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('gender')
                        ->label('Gender:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('contactnumber')
                        ->label('Contact Number:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('emergency_contact')
                        ->label('Emergency Contact:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                ])->columns(2),
    
                // Vital Signs
                Section::make('Vital Signs')->schema([
                    TextEntry::make('temperature')
                        ->label('Temperature:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('pulse')
                        ->label('Pulse:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('respiration_rate')
                        ->label('Respiration Rate:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('blood_pressure')
                        ->label('Blood Pressure:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                ])->columns(2),
    
                // System Assessment
                Section::make('System Assessment')->schema([
                    TextEntry::make('general_appearance')
                        ->label('General Appearance:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('head_eyes_ears_nose_throat')
                        ->label('Head, Eyes, Ears, Nose, Throat:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('respiratory')
                        ->label('Respiratory:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('cardiovascular')
                        ->label('Cardiovascular:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('abdomen')
                        ->label('Abdomen:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('musculoskeletal')
                        ->label('Musculoskeletal:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('neurological')
                        ->label('Neurological:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                ]),
    
                // Nursing Notes
                Section::make('Nursing Notes')->schema([
                    TextEntry::make('observations')
                        ->label('Observations:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('recommendations')
                        ->label('Recommendations:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('nurse_name')
                        ->label('Nurse\'s Name:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('date')
                        ->label('Date:')
                        ->date()
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                ])->columns(2),
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
            //'view' => Pages\ViewPatientRecord::route('/{record}'),
            'edit' => Pages\EditPatientRecord::route('/{record}/edit'),
        ];
    }
}
