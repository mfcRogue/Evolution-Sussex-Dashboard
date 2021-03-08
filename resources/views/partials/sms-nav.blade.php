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
    <div class="flex-shrink-0 flex items-center">
        <x-nav-link :href="route('sms.archived')" :active="request()->routeIs('sms.archived')">
            {{ __('Archived Conversations') }}
        </x-nav-link>
    </div>
    <div class="flex-shrink-0 flex items-center">
        <x-nav-link :href="route('sms.new')" :active="request()->routeIs('sms.new')">
            {{ __('New Message') }}
        </x-nav-link>
    </div>
</x-slot>

@if (session('status'))
<div class="min-w-full p-2.5 bg-green-500 text-center content-center text-white">
{{ session('status') }}
</div>
@endif
@if ($errors->any())
<div class="min-w-full p-2.5 bg-red-600 text-center content-center text-white">
<b>The following errors have been found</b>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif