<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use App\Models\Status;
use Filament\Resources\Pages\EditRecord;
use Filament\Facades\Filament;
use Carbon\Carbon;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        $user = Filament::auth()->user();

        $currentSortOrder = $this->record->status->sort_order;
        $currentStatusId = $this->record->status_id;

         if ($user->role === 'admin') {
             return [];
         } else {
             $availableStatuses = Status::where('sort_order', '>=', $currentSortOrder)->where('sort_order', '<', 4)->where('id', '!=', $currentStatusId)
                 ->orderBy('sort_order')
                 ->get();
         }

        $actions = [];

        foreach ($availableStatuses as $status) {
            $actions[] = Actions\Action::make('set_status_' . $status->id)
                ->label($status->name)
                ->color($this->getStatusColor($status->name))
                ->action(function () use ($status) {
                    $data = ['status_id' => $status->id];
                    // Jika Complete, maka finish date di update
                    if (strtolower($status->name) === 'completed') {
                        $data['finish_date'] = Carbon::now();
                    }
                    $this->record->update($data);
                    return redirect(request()->header('Referer'));
                });
        }

        return $actions;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        $user = Filament::auth()->user();

        if ($user->role === 'developer') {
            return [];
        }

        return parent::getFormActions();
    }

    private function getStatusColor(string $statusName): string
    {
        return match (strtolower($statusName)) {
            'waiting' => 'gray',
            'in progress' => 'primary',
            'pending' => 'warning',
            'completed' => 'success',
            'closed' => 'danger',
            default => 'primary',
        };
    }
}
