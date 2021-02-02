<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder System') }}
        </h2>
    </x-slot>
<div class="flex items-stretch flex-wrap">
    <div class=" rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">Service Reminders Due</div>
        <p class="text-grey-darker text-base ">
         <livewire:vehicles.count.service-reminders /> Reminders due.
        </p>
    </div>
    </div>
    <div class="rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">Service Reminders Ovdeue</div>
        <p class="text-grey-darker text-base ">
        X Reminders due in [Month]
        </p>
    </div>
    </div>
    <div class="rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">Service Reminders To be Sent by Text</div>
        <p class="text-grey-darker text-base ">
            X Reminders to be sent in in [Month]
        </p>
    </div>
    </div>
</div>
</x-app-layout>
