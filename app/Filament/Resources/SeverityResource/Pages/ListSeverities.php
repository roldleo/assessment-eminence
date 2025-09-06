<?php

namespace App\Filament\Resources\SeverityResource\Pages;

use App\Filament\Resources\SeverityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeverities extends ListRecords
{
    protected static string $resource = SeverityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
