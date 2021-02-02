<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder System') }}
        </h2>
    </x-slot>
<div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="px-6 py-4  text-center">
        <div class="font-bold text-xl mb-2"><livewire:vehicles.count.service-reminders /></div>
        <p class="text-grey-darker text-base ">
         Due
        </p>
    </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class= "px-6 py-4  text-center">
        <div class="font-bold text-xl mb-2"> x </div>
        <p class="text-grey-darker text-base text-center">
        Overdue
        </p>
    </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="px-6 py-4  text-center">
        <div class="font-bold text-xl mb-2"> x </div>
        <p class="text-grey-darker text-base text-center">
          Send by Text
        </p>
    </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class="flex-grow px-6 py-4  text-center">
        <div class="font-bold text-xl mb-2"> x </div>
        <p class="text-grey-darker text-base text-center">
           Send by Email
        </p>
    </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
    <div class=" px-6 py-4  text-center">
        <div class="font-bold text-xl mb-2"> x </div>
        <p class="text-grey-darker text-base text-center">
           Send by Post
        </p>
    </div>
    </div>
</div>
</x-app-layout>
