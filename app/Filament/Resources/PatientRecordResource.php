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

   
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Patient Information')
            ->schema([
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
                    ->extraAttributes(['inputmode' => 'numeric', 'pattern' => '[0-9]*']),
                Forms\Components\TextInput::make('emergency_contact')
                    ->required()
                    ->maxLength(11)
                    ->rule('regex:/^[0-9]{10,11}$/')
                    ->extraAttributes(['inputmode' => 'numeric', 'pattern' => '[0-9]*']),
            ])->columns(2),

            Forms\Components\Section::make('Vital Signs')
            ->schema([
                Forms\Components\TextInput::make('temperature')
                    ->numeric()
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
                Forms\Components\TextInput::make('pulse')
                    ->numeric()
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
                Forms\Components\TextInput::make('respiration_rate')
                    ->numeric()
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
                Forms\Components\TextInput::make('blood_pressure')
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
            ])->columns(2),

            Forms\Components\Section::make('System Assessment')
            ->schema([
                Forms\Components\Textarea::make('general_appearance')
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
                Forms\Components\Textarea::make('head_eyes_ears_nose_throat'),
                Forms\Components\Textarea::make('respiratory'),
                Forms\Components\Textarea::make('cardiovascular'),
                Forms\Components\Textarea::make('abdomen'),
                Forms\Components\Textarea::make('musculoskeletal'),
                Forms\Components\Textarea::make('neurological'),
            ])->columns(1),

            Forms\Components\Section::make('Nursing Notes')
            ->schema([
                Forms\Components\Textarea::make('observations')
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateCdssFields($set, $get)),
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

            Forms\Components\Textarea::make('cdss_recommendations')
            ->label('CDSS Recommendations')
            ->disabled()
            ->dehydrated() // <-- important!
            ->rows(3)
            ->columnSpanFull(),
        
            Forms\Components\TextInput::make('cdss_risk_level')
            ->label('Risk Level')
            ->disabled()
            ->dehydrated() // <-- important!
            ->extraAttributes(['style' => 'font-weight: bold']),
        
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
                Tables\Actions\Action::make('Create Lab Order')
                    ->label('Add Lab Order')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->visible(fn () => Auth::user()?->hasRole('doctor'))
                    ->url(fn ($record) => route('filament.admin.resources.lab-orders.create', [
                        'patient_id' => $record->id,
                        'patient_name' => $record->name,
                        'doctor_name' => Auth::user()->name,
                    ])),
             
              
                Tables\Actions\Action::make('Create Doctor Order')
                    ->label('Add Doctor Order')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->visible(fn () => Auth::user()?->hasRole('doctor'))
                    ->url(fn ($record) => route('filament.admin.resources.doctor-orders.create', [
                        'patient_id' => $record->id,
                        'patient_name' => $record->name,
                        'doctor_name' => Auth::user()->name,
                    ]))
                    
                    ->openUrlInNewTab(false),
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

                //cdss recommendation
                Section::make('CDSS')->schema([
                    TextEntry::make('cdss_recommendations')
                        ->label('CDSS Recommendation:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                    TextEntry::make('cdss_risk_level')
                        ->label('CDSS Risk Level:')
                        ->extraAttributes(['class' => 'text-gray-700 font-medium']),
                ])->columns(2),

                
            ]);
    }
            protected static function updateCdssFields(callable $set, callable $get): void
        {
            $data = [
                'temperature' => $get('temperature'),
                'blood_pressure' => $get('blood_pressure'),
                'pulse' => $get('pulse'),
                'respiration_rate' => $get('respiration_rate'),
                'general_appearance' => $get('general_appearance'),
                'observations' => $get('observations'),
            ];

            [$recommendations, $riskLevel] = self::generateCdss($data);

            $set('cdss_recommendations', $recommendations);
            $set('cdss_risk_level', $riskLevel);
        }

        protected static function generateCdss(array $data): array
        {
            $alerts = [];
            $flags = [];

            if (!empty($data['temperature'])) {
                if ($data['temperature'] > 37.5) $alerts[] = "Fever detected.";
                elseif ($data['temperature'] < 35) $alerts[] = "Possible hypothermia.";
            }

            if (!empty($data['blood_pressure'])) {
                if (self::isHighBloodPressure($data['blood_pressure'])) $alerts[] = "High blood pressure.";
                elseif (self::isLowBloodPressure($data['blood_pressure'])) $alerts[] = "Low blood pressure.";
            }

            if (!empty($data['pulse'])) {
                if ($data['pulse'] > 100) $alerts[] = "Tachycardia.";
                elseif ($data['pulse'] < 60) $alerts[] = "Bradycardia.";
            }

            if (!empty($data['respiration_rate'])) {
                if ($data['respiration_rate'] > 20) $alerts[] = "Elevated respiration rate.";
                elseif ($data['respiration_rate'] < 12) $alerts[] = "Low respiration rate.";
            }

            if (!empty($data['general_appearance']) && str_contains(strtolower($data['general_appearance']), 'pale')) {
                $flags[] = "Pale appearance – assess for anemia.";
            }

            if (!empty($data['observations'])) {
                $obs = strtolower($data['observations']);
                if (str_contains($obs, 'dizzy')) $flags[] = "Dizziness reported.";
                if (str_contains($obs, 'fatigue')) $flags[] = "Fatigue noted.";
                if (str_contains($obs, 'shortness of breath')) $flags[] = "Shortness of breath reported.";
            }

            $allFindings = array_merge($alerts, $flags);
            $recommendations = implode(' ', $allFindings);

            $alertCount = count($alerts);
            $riskLevel = 'Low';
            if ($alertCount >= 3) $riskLevel = 'High';
            elseif ($alertCount === 2) $riskLevel = 'Moderate';

            return [$recommendations ?: 'No clinical alerts.', $riskLevel];
        }

        protected static function isHighBloodPressure(string $bp): bool
        {
            $parts = explode('/', $bp);
            return isset($parts[0], $parts[1]) && ((int)$parts[0] > 140 || (int)$parts[1] > 90);
        }

        protected static function isLowBloodPressure(string $bp): bool
        {
            $parts = explode('/', $bp);
            return isset($parts[0], $parts[1]) && ((int)$parts[0] < 90 || (int)$parts[1] < 60);
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
