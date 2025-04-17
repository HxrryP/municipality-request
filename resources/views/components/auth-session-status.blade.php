@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-green-50 text-green-800 p-4 rounded-lg mb-6 border border-green-200']) }}>
        {{ $status }}
    </div>
@endif