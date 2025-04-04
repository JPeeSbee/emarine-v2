<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2">
                <x-app-logo /> 
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" :href="route('home')" :current="(strpos(url()->current(), route('home').'/dashboard') !== false)">{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist>
            @hasanyrole('Encoder|Super-Admin')
                @can('Certificate Issuance')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Issuance')" class="grid">
                        <flux:navlist.item icon="clipboard-document" :href="route('marine-issuance')" :current="(strpos(url()->current(), route('marine-issuance')) !== false)">{{ __('Certificate Issuance') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
                @endcan

                @if(auth()->user()->hasAnyPermission(['Posted Certificate', 'Certificate Summary']))
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Reports')" class="grid">
                        @can('Posted Certificate')
                            <flux:navlist.item icon="document-text" :href="route('report.posted')" :current="(strpos(url()->current(), route('report.posted')) !== false)">{{ __('Posted Certificate') }}</flux:navlist.item>
                        @endcan
                        @can('Certificate Summary')
                            <flux:navlist.item icon="folder-open" :href="route('report.summary')" :current="(strpos(url()->current(), route('report.summary')) !== false)">{{ __('Certificate Summary') }}</flux:navlist.item>
                        @endcan
                    </flux:navlist.group>
                </flux:navlist>
                @endif
            @endrole
            @hasanyrole('Admin|Super-Admin')
                @if(auth()->user()->hasAnyPermission(['User', 'Role', 'Agent', 'Location', 'Policy', 'System Settings']))
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Maintenance')" class="grid">
                        @can('User')
                            <flux:navlist.item icon="user" :href="route('maintenance.user')" :current="(strpos(url()->current(), route('maintenance.user')) !== false)">{{ __('User') }}</flux:navlist.item>
                        @endcan
                        @can('Role')
                            <flux:navlist.item icon="key" :href="route('maintenance.role')" :current="(strpos(url()->current(), route('maintenance.role')) !== false)">{{ __('Role') }}</flux:navlist.item>
                        @endcan
                        @can('Agent')
                            <flux:navlist.item icon="identification" :href="route('maintenance.agent')" :current="(strpos(url()->current(), route('maintenance.agent')) !== false)">{{ __('Agent') }}</flux:navlist.item>
                        @endcan
                        @can('Location')
                            <flux:navlist.item icon="globe-alt" :href="route('maintenance.location')" :current="(strpos(url()->current(), route('maintenance.location')) !== false)">{{ __('Location') }}</flux:navlist.item>
                        @endcan
                        @can('Policy')
                            <flux:navlist.item icon="book-open" :href="route('maintenance.policy')" :current="(strpos(url()->current(), route('maintenance.policy')) !== false)">{{ __('Policy') }}</flux:navlist.item>
                        @endcan
                        @can('System Settings')
                            <flux:navlist.item icon="wrench" :href="route('maintenance.system-setting')" :current="(strpos(url()->current(), route('maintenance.system-setting')) !== false)">{{ __('System Settings') }}</flux:navlist.item>
                        @endcan
                    </flux:navlist.group>
                </flux:navlist>
                @endif
            @endrole
            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog">{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog">{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
