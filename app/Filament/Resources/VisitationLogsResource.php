<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitationLogsResource\Pages;
use App\Filament\Resources\VisitationLogsResource\RelationManagers;
use App\Models\VisitationLogs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitationLogsResource extends Resource
{
    protected static ?string $model = VisitationLogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(name: 'Reason')->required(),
                Forms\Components\TimePicker::make('Time')->required(),
                Forms\Components\DatePicker::make('Date')->required(),
                Forms\Components\Textarea::make(name: 'InterventionProvided')
                ->required()
                ->columnSpanFull()
                ->rows(5),
                Forms\Components\Textarea::make(name: 'FollowUps')
                ->required()
                ->columnSpanFull()
                ->rows(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Reason'),
                Tables\Columns\TextColumn::make('Time'),
                Tables\Columns\TextColumn::make(name: 'Date'),
                Tables\Columns\TextColumn::make('InterventionProvided'),
                Tables\Columns\TextColumn::make('FollowUps'),
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
            'index' => Pages\ListVisitationLogs::route('/'),
            'create' => Pages\CreateVisitationLogs::route('/create'),
            'edit' => Pages\EditVisitationLogs::route('/{record}/edit'),
        ];
    }
}
