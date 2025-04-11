<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorOrderResource\Pages;
use App\Filament\Resources\DoctorOrderResource\RelationManagers;
use App\Models\DoctorOrder;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;


class DoctorOrderResource extends Resource
{
    protected static ?string $model = DoctorOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('patient_record_id')
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

            Forms\Components\Textarea::make('order')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_record_id')->searchable(),
                Tables\Columns\TextColumn::make('patient_name')->searchable(),
                Tables\Columns\TextColumn::make('doctor_name'),
                Tables\Columns\TextColumn::make('order'),
            ])
            ->filters([
                //
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
            TextEntry::make('patient_record_id')
                ->label('Patient Record ID'),

            TextEntry::make('patient_name')
                ->label('Patient Name'),

            TextEntry::make('doctor_name')
                ->label('Doctor Name'),

            TextEntry::make('order')
                ->label('Doctor’s Order')
                ->markdown() // Optional, useful for formatting if it’s long
                ->columnSpanFull(), // Optional for full width
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctorOrders::route('/'),
            'create' => Pages\CreateDoctorOrder::route('/create'),
            //'view' => Pages\ViewDoctorOrder::route('/{record}'),
            'edit' => Pages\EditDoctorOrder::route('/{record}/edit'),
        ];
    }
}
