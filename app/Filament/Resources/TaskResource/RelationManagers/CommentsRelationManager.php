<?php

namespace App\Filament\Resources\TaskResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\ViewColumn;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('body')
                    ->label('Comment')
                    ->required()
                    ->maxLength(1000)
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                    ])
                    ->columnSpanFull(),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('body')
                    ->label('')
                    ->view('comment')
                    ->viewData(fn ($record) => ['record' => $record]),
            ])
            ->paginated(false)
            ->defaultSort('created_at', 'asc')
            ->heading('Comments')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Comment')
                    ->modalHeading('New Comment')
                    ->modalButton('Post')
                    ->using(function (array $data, $model) {
                        $data['user_id'] = auth()->id();
                        $data['task_id'] = $this->ownerRecord->id;
                        return $model::create($data);
                    }),
            ]);
    }
}
