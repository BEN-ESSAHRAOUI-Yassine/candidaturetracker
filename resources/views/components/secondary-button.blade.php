<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-dark-surface border border-dark-border rounded-lg font-mono text-xs text-text-muted uppercase tracking-wider hover:text-text-primary hover:border-neon-cyan/30 focus:outline-none focus:ring-2 focus:ring-neon-cyan/40 focus:ring-offset-2 focus:ring-offset-dark-bg disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
