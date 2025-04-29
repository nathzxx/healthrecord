<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabResultResource\Pages;
use App\Filament\Resources\LabResultResource\RelationManagers;
use App\Models\LabResult;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class LabResultResource extends Resource
{
    protected static ?string $model = LabResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laboratory';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        
            ->schema([
                Hidden::make('lab_order_id')
                    ->default(request()->get('lab_order_id'))
                    ->required(),

                    
                Forms\Components\TextInput::make('lab_order')
                ->default(request()->get('lab_order'))
                ->label('Lab Order')
                ->disabled()
                ->dehydrated(),
    
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
    
                Forms\Components\Textarea::make('result')
                    ->label('Lab Result')
                    ->required(),
    
                FileUpload::make('file')
                    ->label('Upload File')
                    ->directory('lab-results')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->acceptedFileTypes(['application/pdf', 'image/*']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lab_order'),
                Tables\Columns\TextColumn::make('patient_name')->searchable(),
                Tables\Columns\TextColumn::make('doctor_name'),
                Tables\Columns\TextColumn::make('result'),
                Tables\Columns\TextColumn::make('file')
                ->label('View File')
                ->url(fn ($record) => $record->file ? asset('storage/' . $record->file) : null)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state ? 'View File' : 'No File'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('labOrder.test_name')
                    ->label('Lab Order'),

                TextEntry::make('patient_name')
                    ->label('Patient Name'),

                TextEntry::make('doctor_name')
                    ->label('Doctor Name'),

                TextEntry::make('result')
                    ->label('Lab Result'),

                TextEntry::make('file')
                    ->label('File')
                    ->url(fn (LabResult $record) => $record->file ? asset('storage/' . $record->file) : null)
                    ->openUrlInNewTab()
                    ->visible(fn (LabResult $record) => $record->file !== null),
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
            'index' => Pages\ListLabResults::route('/'),
            'create' => Pages\CreateLabResult::route('/create'),
            'edit' => Pages\EditLabResult::route('/{record}/edit'),
        ];
    }
}
