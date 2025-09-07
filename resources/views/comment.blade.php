@php
    $isMine = $record->user_id === auth()->id();
@endphp

<div class="w-full flex flex-col {{ $isMine ? 'items-end' : 'items-start' }} my-2">
    <div class="text-xs mb-1">
        {{ $record->user->name }} • {{ $record->created_at->format('d M Y H:i') }}
    </div>
    <div class="px-3 py-2 rounded-lg bg-black max-w-[70%] {{ $isMine ? '' : 'text-primary-600' }}">
        {!! $record->body !!}
    </div>
</div>