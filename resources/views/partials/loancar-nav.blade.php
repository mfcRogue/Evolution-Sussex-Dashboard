<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight no-print">
        {{ __('Loan Car System') }}
    </h2>
       <div class="flex no-print">
    <!-- Reminder Navigation -->
            <div class="flex-shrink-0 flex items-center">
                <x-nav-link :href="route('loancar.index')" :active="request()->routeIs('loancar.index')">
                    {{ __('Loan Car Dashboard') }}
                </x-nav-link>
            </div>
                <div class="flex-shrink-0 flex items-center  ml-4">
                <x-nav-link :href="route('loancar.index')" :active="request()->routeIs('loancar.index')">
                    {{ __('Add New') }}
                </x-nav-link>
            </div>
</x-slot>