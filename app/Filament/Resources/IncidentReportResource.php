<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidentReportResource\Pages;
use App\Filament\Resources\IncidentReportResource\RelationManagers;
use App\Models\IncidentReport;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Filters\Filter;

class IncidentReportResource extends Resource
{
    protected static ?string $model = IncidentReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Nurse Information')
                ->schema([
                    Forms\Components\TextInput::make(name: 'username')
                    ->label('Username')
                    ->default(fn () => Auth::user()->name)
                    ->disabled() 
                    ->dehydrated(),
                    Forms\Components\TimePicker::make(name: 'Time')
                    ->default(Carbon::now('Asia/Manila')->format('H:i')) 
                        ->disabled()
                        ->dehydrated(),
                    Forms\Components\DatePicker::make('Date')
                        ->default(now())
                        ->disabled()
                        ->dehydrated()
                ])->columns(2),

                Forms\Components\Section::make(' Person Involved in the Incident')
                ->schema([
                    Forms\Components\TextInput::make('name_involve')
                    ->required(),
                    Forms\Components\TextInput::make('contact')
                    ->required()
                    ->label('Contact Number')
                    ->maxLength(11)
                    ->rule('regex:/^[0-9]{10,11}$/')
                    ->extraAttributes(['inputmode' => 'numeric', 'pattern' => '[0-9]*']),

                ])->columns(2),

                Forms\Components\Section::make('Incident Information')
                ->schema([
                    Forms\Components\TextInput::make(name: 'IncidentLocation')
                    ->label('Incident Location')
                    ->required(),
                    
                Forms\Components\Select::make(name: 'IncidentType')
                    ->options([
                        'Fall'=>'Fall',
                        'Medication Error' => 'Medication Error',
                        'Equipment Malfunction'=>'Equipment Malfunction',
                        'Patient Complaint'=> 'Patient Complaint',
                        'Staff Injury' => 'Staff Injury',
                        'Other' => 'Other'
                    ])
                    ->label('Incident Type')
                    ->searchable()
                    ->reactive()
                    ->required(),
                   
                    
                Forms\Components\DatePicker::make(name: 'IncidentDate')
                    ->label('Incident Date')
                    ->native(false)
                    ->required(),
                    Forms\Components\TimePicker::make(name: 'IncidentTime')
                    ->label('Incident Time')
                    ->format('H:i')
                    ->required(),
                
                Forms\Components\Textarea::make('Incident')
                    ->label('Incident')
                    ->required()
                    ->columnSpanFull()
                    ->rows(5),

                ])->columns(2),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name_involve')
                ->searchable(),
                Tables\Columns\TextColumn::make('IncidentType'),
                Tables\Columns\TextColumn::make('Date'),
                Tables\Columns\TextColumn::make('Time'),
             
                
            ])
            ->filters([
                Filter::make('Date')
                ->form([
                    DatePicker::make('date'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['date'], fn ($query, $date) =>
                            $query->whereDate('Date', $date)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            TextEntry::make('name_involve')->label(label: 'Name Involve:'),
            TextEntry::make('IncidentLocation')->label('Incident Location:'),
            TextEntry::make('IncidentType')->label('Incident Type:'),
            TextEntry::make('IncidentDate')->label('IncidentDate:'),
            TextEntry::make('Incident')->label('Incident Details:')->columnSpanFull(),
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
            'index' => Pages\ListIncidentReports::route('/'),
            'create' => Pages\CreateIncidentReport::route('/create'),
            'edit' => Pages\EditIncidentReport::route('/{record}/edit'),
        ];
    }
}
