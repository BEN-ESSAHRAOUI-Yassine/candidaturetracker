@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-mono text-sm text-neon-green bg-neon-green/5 border border-neon-green/20 rounded-lg px-4 py-3']) }}>
        {{ $status }}
    </div>
@endif
