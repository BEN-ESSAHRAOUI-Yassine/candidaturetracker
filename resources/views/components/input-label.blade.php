@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-mono text-xs font-medium text-text-muted tracking-wider uppercase']) }}>
    {{ $value ?? $slot }}
</label>
