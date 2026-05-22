<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-neon-cyan/10 border border-neon-cyan/30 rounded-lg font-mono text-xs text-neon-cyan uppercase tracking-wider hover:bg-neon-cyan/20 hover:border-neon-cyan/50 focus:outline-none focus:ring-2 focus:ring-neon-cyan/40 focus:ring-offset-2 focus:ring-offset-dark-bg shadow-glow-sm transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
