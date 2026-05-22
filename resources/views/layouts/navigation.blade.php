<!-- Top Bar -->
<div class="fixed top-0 left-0 right-0 h-12 z-50 glass border-b border-dark-border flex items-center justify-between px-4">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-lg text-text-muted hover:text-neon-cyan hover:bg-dark-elevated/50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="block h-6 w-auto fill-current text-neon-cyan" />
            <span class="font-mono text-sm font-bold text-text-primary tracking-tight hidden sm:block">CandidatureTracker</span>
        </a>
    </div>
    <div class="flex items-center gap-2">
        <!-- Theme Toggle -->
        <button @@click="darkMode = !darkMode"
                class="p-2 rounded-lg border border-base-border text-text-muted hover:text-accent hover:border-accent transition"
                title="Toggle theme">
            <template x-if="darkMode">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </template>
            <template x-if="!darkMode">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </template>
        </button>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-dark-border text-text-muted hover:text-neon-cyan hover:border-neon-cyan/30 transition text-xs font-mono">
                    <span class="w-1.5 h-1.5 rounded-full bg-neon-green"></span>
                    {{ Auth::user()->name }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>

<!-- Sidebar -->
<aside x-show="sidebarOpen" x-transition:enter="transition-all duration-300"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition-all duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed top-12 left-0 bottom-0 w-[240px] z-40 bg-dark-surface border-r border-dark-border overflow-y-auto py-4 hidden lg:block">
    <nav class="px-3 space-y-1">
        <div class="px-3 py-2 font-mono text-xs text-text-dim uppercase tracking-widest mb-1">Navigation</div>

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('candidatures.index') }}"
           class="sidebar-link {{ request()->routeIs('candidatures.*') && !request()->routeIs('candidatures.archives') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Mes candidatures</span>
        </a>

        <a href="{{ route('candidatures.archives') }}"
           class="sidebar-link {{ request()->routeIs('candidatures.archives') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <span>Archives</span>
        </a>
    </nav>

    <div class="border-t border-dark-border mt-6 pt-4 px-3">
        <div class="px-3 py-2 font-mono text-xs text-text-dim uppercase tracking-widest mb-1">Système</div>

        <a href="{{ route('profile.edit') }}"
           class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="sidebar-link w-full text-left">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile sidebar overlay -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     @@click="sidebarOpen = false"
     class="fixed inset-0 bg-black/60 z-30 lg:hidden"></div>

<!-- Mobile sidebar -->
<aside x-show="sidebarOpen" x-transition:enter="transition-all duration-300"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition-all duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed top-12 left-0 bottom-0 w-[240px] z-40 bg-dark-surface border-r border-dark-border overflow-y-auto py-4 lg:hidden">
    <nav class="px-3 space-y-1">
        <div class="px-3 py-2 font-mono text-xs text-text-dim uppercase tracking-widest mb-1">Navigation</div>

        <a href="{{ route('dashboard') }}" @@click="sidebarOpen = false"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('candidatures.index') }}" @@click="sidebarOpen = false"
           class="sidebar-link {{ request()->routeIs('candidatures.*') && !request()->routeIs('candidatures.archives') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Mes candidatures</span>
        </a>

        <a href="{{ route('candidatures.archives') }}" @@click="sidebarOpen = false"
           class="sidebar-link {{ request()->routeIs('candidatures.archives') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <span>Archives</span>
        </a>
    </nav>

    <div class="border-t border-dark-border mt-6 pt-4 px-3">
        <div class="px-3 py-2 font-mono text-xs text-text-dim uppercase tracking-widest mb-1">Système</div>

        <a href="{{ route('profile.edit') }}" @@click="sidebarOpen = false"
           class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="sidebar-link w-full text-left">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
