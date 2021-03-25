<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('SMS System') }}
    </h2>
    <div class="flex">
        <div class="flex-shrink-0 flex items-center">
            <x-nav-link :href="route('sms.dashboard')" :active="request()->routeIs('sms.dashboard')">
                {{ __('Active Conversations') }}
            </x-nav-link>
        </div>
    <div class="flex-shrink-0 flex items-center ml-4">
        <x-nav-link :href="route('sms.archived')" :active="request()->routeIs('sms.archived')">
            {{ __('Archived Conversations') }}
        </x-nav-link>
    </div>
    <div class="flex-shrink-0 flex items-center ml-4">
        <x-nav-link :href="route('sms.new')" :active="request()->routeIs('sms.new')">
            {{ __('New Message') }}
        </x-nav-link>
    </div>
</x-slot>