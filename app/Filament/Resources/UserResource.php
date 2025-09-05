<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Section, TextInput, Select};
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Filament\Tables\Filters\{SelectFilter};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
    public static function canCreate(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
    public static function canEdit($record): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
    public static function canDelete($record): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
    public static function canDeleteAny(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Info')->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    
                    TextInput::make('email')->email()->required()->unique(ignoreRecord: true)
                    ->rule(fn($record) => Rule::unique('users', 'email')->ignore($record?->id)),
                    
                    Select::make('role')->required()
                    ->options(['admin' => 'Admin', 'developer' => 'Developer'])->native(false),

                    TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context) => $context === 'create')
                    ->rule(fn (string $context) => $context === 'create'
                        ? ['min:6'] : ['nullable','min:6'])
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->badge()
                    ->color(fn ($state) => $state === 'admin' ? 'success' : 'info')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(['admin' => 'Admin', 'developer' => 'Developer']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id','desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
