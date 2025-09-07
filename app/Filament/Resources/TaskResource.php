<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        $user = Filament::auth()->user();

        $query = parent::getEloquentQuery();

        if ($user->role === 'developer') {
            $query->where('developer_id', $user->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $user = Filament::auth()->user();
        $isAdmin = $user->role === 'admin';

        $schema = [];

        if ($isAdmin) {
            // Admin menggunakan Form
            $schema[] = Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255);

            $schema[] = Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull();

            $schema[] = Forms\Components\Select::make('status_id')
                ->label('Status')
                ->relationship('status', 'name', fn ($query) => $query->orderBy('sort_order', 'asc'))
                ->default(fn () => Status::orderBy('sort_order', 'asc')->value('id'))
                ->required();

            $schema[] = Forms\Components\DatePicker::make('start_date')->required();
            $schema[] = Forms\Components\DatePicker::make('due_date')->required();
        } else {
            // Developer menggunakan custom view
            $schema[] = Forms\Components\ViewField::make('custom_display')
                ->label(false) 
                ->view('task-detail'); 
        }

        return $form->schema($schema);
    }


    public static function table(Table $table): Table
    {
        $user = Filament::auth()->user();

        // Filter untuk developer
        $filters = [
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->relationship('status', 'name'),

            Tables\Filters\SelectFilter::make('severity')
                ->label('Severity')
                ->relationship('severity', 'name'),
        ];
        
        // Filter tambahan untuk admin (bisa filter bersadarkan developer)
        if ($user->role === 'admin') {
            $filters[] = Tables\Filters\SelectFilter::make('developer')
                ->label('Developer')
                ->relationship('developer', 'name');
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('developer.name')->label('Developer'),
                Tables\Columns\TextColumn::make('status.name')
                ->label('Status')
                ->badge()
                ->color(fn ($state) => match (strtolower($state)) {
                    'waiting'     => 'secondary',
                    'in progress' => 'primary',
                    'pending'     => 'warning',
                    'completed'   => 'success',
                    'closed'      => 'danger',
                    default       => 'secondary',
                }),
                Tables\Columns\TextColumn::make('severity.name')->label('Severity'),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('due_date')->date(),
                Tables\Columns\TextColumn::make('creator.name')->label('Creator'),
            ])
            ->filters($filters)
            ->recordClasses(function ($record) {
                $color = $record->severity?->color;

                if ($color) {
                    return "bg-[{$color}]";
                }

                return '';
            })
            ->actions([
                // action hanya untuk Admin saja
                ...( $user->role === 'admin'
                    ? [
                        Tables\Actions\EditAction::make(),

                        // Action Close hanya ada saat status bukan Closed 
                        Tables\Actions\Action::make('close')
                            ->label('Close Task')
                            ->color('danger')
                            ->icon('heroicon-o-x-circle')
                            ->action(function ($record) {
                                $statusClosed = \App\Models\Status::where('name', 'Closed')->first();
                                if ($statusClosed) {
                                    $record->status_id = $statusClosed->id;
                                    $record->save();
                                }
                            })
                            ->requiresConfirmation()
                            ->visible(fn ($record) => strtolower($record->status->name) !== 'closed'),
                    ]
                    : []
                )
            ]);
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
