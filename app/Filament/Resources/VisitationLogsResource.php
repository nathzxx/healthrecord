<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitationLogsResource\Pages;
use App\Filament\Resources\VisitationLogsResource\RelationManagers;
use App\Models\VisitationLogs;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class VisitationLogsResource extends Resource
{
    protected static ?string $model = VisitationLogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(name: 'name')->required(),
                Forms\Components\TextInput::make(name: 'contact')
                ->required()
                    ->label('Contact Number')
                    ->maxLength(11)
                    ->rule('regex:/^[0-9]{10,11}$/')
                    ->extraAttributes(['inputmode' => 'numeric', 'pattern' => '[0-9]*']),
                Forms\Components\Textarea::make(name: 'Reason')->required(),
                Forms\Components\Hidden::make('Time')->required()
                ->default(Carbon::now('Asia/Manila')->format('H:i')),
                Forms\Components\Hidden::make('Date')->required()
                ->disabled()
                ->dehydrated()
                ->default(now()->toDateString()),
             
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('Reason'),
                Tables\Columns\TextColumn::make('contact'),

                Tables\Columns\TextColumn::make('Time'),
                Tables\Columns\TextColumn::make(name: 'Date'),
                
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
            TextEntry::make('name')->label(label: 'Name:'),
            TextEntry::make('Reason')->label('Reason:'),
            TextEntry::make('contact')->label('Contact:'),
            TextEntry::make('Date')->label(label: 'Date:'),
            TextEntry::make('Time')->label('Time:')->columnSpanFull(),
        ]);
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
