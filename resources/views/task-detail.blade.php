@php
    use Illuminate\Support\Carbon;

    $record = $getRecord();
    $user = Filament\Facades\Filament::auth()->user();

    $statusColors = [
      'waiting'     => 'background-color: #E5E7EB; color: #1F2937;',
      'in progress' => 'background-color: #DBEAFE; color: #1D4ED8;',
      'pending'     => 'background-color: #FEF3C7; color: #B45309;',
      'completed'   => 'background-color: #DCFCE7; color: #166534;',
      'closed'      => 'background-color: #FEE2E2; color: #991B1B;',
  ];

    $statusName = strtolower($record->status->name);
    $statusClass = $statusColors[$statusName] ?? 'bg-gray text-gray-800';

    $severityColor = $record->severity?->color ?? 'bg-gray-200';

    $dueDate = Carbon::parse($record->due_date);
    $now = Carbon::now();
    $daysLeft = $now->diffInDays($dueDate, false);
@endphp

<div class="space-y-4 p-4 w-full">
    <h1 class="text-3xl font-bold">{{ $record->title }}</h1>

    <p class="text-gray-700">{{ $record->description }}</p>

    <div class="flex flex-col items-start gap-4 text-sm mt-2">
        {{-- Status --}}
        <div>
          Status : 
          <span class="px-2 py-1 rounded-full font-semibold" style="{{ $statusColors[$statusName] ?? 'background-color: #E5E7EB; color: #1F2937;' }}">
            {{ $record->status->name }}
        </span>
        </div>

        @if($record->severity)
            <div>
              Severity : 
              <span class="px-2 py-1 rounded-full font-semibold" style="color: {{ $severityColor }}">
                {{ $record->severity->name }}
            </span>
            </div>
        @endif

        <span>
            Start: {{ Carbon::parse($record->start_date)->format('d M Y') }}
        </span>

        <span class="{{ $daysLeft < 0 ? 'text-red-600' : '' }}">
            Due: {{ $dueDate->format('d M Y') }} 
            ({{ $daysLeft < 0 ? abs($daysLeft) . ' days ago' : $daysLeft . ' days remaining' }})
        </span>
    </div>

</div>
