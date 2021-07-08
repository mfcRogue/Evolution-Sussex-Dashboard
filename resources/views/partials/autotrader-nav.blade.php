<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight no-print">
        {{ __('Autotrader System') }}
    </h2>
    <div class="flex no-print">
        <!-- Reminder Navigation -->
    <div class="flex-shrink-0 flex items-center">
        <x-nav-link :href="route('autotrader.index')" :active="request()->routeIs('autotrader.index')">
            {{ __('Autotrader Dashboard') }}
        </x-nav-link>
    </div>
    <div class="flex-shrink-0 flex items-center  ml-4">
        <x-nav-link :href="route('autotrader.getlist')" :active="request()->routeIs('autotrader.getlist')">
            {{ __('Sync List') }}
        </x-nav-link>
    </div>
    <div class="flex-shrink-0 flex items-center  ml-4">
        <x-nav-link :href="route('autotrader.getnew')" :active="request()->routeIs('autotrader.getnew')">
            {{ __('Push New Vehicles') }}
        </x-nav-link>
    </div>
        <div class="flex-shrink-0 flex items-center  ml-4">
        <x-nav-link :href="route('autotrader.getdelete')" :active="request()->routeIs('autotrader.getdelete')">
            {{ __('Delete Vehicles') }}
        </x-nav-link>
    </div>
</x-slot>
