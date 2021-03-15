<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Reminder System') }}
    </h2>
    <div class="flex">
    <!-- Reminder Navigation -->
            <div class="flex-shrink-0 flex items-center">
                <x-nav-link :href="route('reminder.dashboard')" :active="request()->routeIs('reminder.dashboard')">
                    {{ __('Reminder Dashboard') }}
                </x-nav-link>
            </div>
                <div class="flex-shrink-0 flex items-center  ml-4">
                <x-nav-link :href="route('reminder.list.due', ['month'=>$month])" :active="request()->routeIs('reminder.list.due')">
                    {{ __('Reminders Due') }}
                </x-nav-link>
            </div>
</x-slot>
