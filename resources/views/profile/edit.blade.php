<x-app-layout>
    <x-slot name="header">
        <h2 class="font-mono font-bold text-lg text-text-primary">Paramètres</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Info -->
        <div class="glass rounded-2xl p-6 sm:p-8 animate-fade-up">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-xl bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-mono text-sm text-text-primary font-semibold">{{ Auth::user()->name }}</h3>
                    <p class="font-mono text-xs text-text-muted">{{ Auth::user()->email }}</p>
                </div>
                <span class="ml-auto inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-neon-green/10 border border-neon-green/20 font-mono text-[10px] text-neon-green">
                    <span class="w-1.5 h-1.5 rounded-full bg-neon-green"></span>
                    Actif
                </span>
            </div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Password -->
        <div class="glass rounded-2xl p-6 sm:p-8 animate-fade-up animate-fade-up-d1">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-xl bg-neon-cyan/10 border border-neon-cyan/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="font-mono text-sm text-text-primary font-semibold">Sécurité</h3>
            </div>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete -->
        <div class="glass rounded-2xl p-6 sm:p-8 animate-fade-up animate-fade-up-d2">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-xl bg-neon-orange/10 border border-neon-orange/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-neon-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="font-mono text-sm text-neon-orange font-semibold">Zone dangereuse</h3>
            </div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
