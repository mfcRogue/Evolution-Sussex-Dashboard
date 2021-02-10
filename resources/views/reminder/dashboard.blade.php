<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder System') }}
        </h2>
    </x-slot>
    <div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2">Service Reminders</div>
        </div>
    </div>
    </div>
<div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.service-reminders /></div>
            <p class="text-grey-darker text-base">
            Due
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class= "px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.over-due-service-reminders /></div>
            <p class="text-grey-darker text-base text-center">
            Overdue
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.send-by-text /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Text
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="flex-grow px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.service-reminders-send-by-email /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Email
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class=" px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.service-reminders-send-by-post /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Post
            </p>
        </div>
    </div>
</div>
    <div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2">MOT Reminders</div>
        </div>
    </div>
    </div>

<div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.m-o-t-reminders /></div>
            <p class="text-grey-darker text-base">
            Due
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class= "px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.m-o-t-overdue-reminders /></div>
            <p class="text-grey-darker text-base text-center">
            Overdue
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.m-o-t-reminders-send-by-text /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Text
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="flex-grow px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.m-o-t-reminders-send-by-email /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Email
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class=" px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.m-o-t-reminders-send-by-post /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Post
            </p>
        </div>
    </div>
</div>

    <div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2">Combined Reminders</div>
        </div>
    </div>
    </div>
<div class="flex items-stretch flex-wrap">
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.combined-reminders /></div>
            <p class="text-grey-darker text-base">
            Due
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class= "px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.combined-overdue-reminders /></div>
            <p class="text-grey-darker text-base text-center">
            Overdue
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.combined-reminders-send-by-text /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Text
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class="flex-grow px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.combined-reminders-send-by-email /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Email
            </p>
        </div>
    </div>
    <div class="flex-grow rounded overflow-hidden shadow-lg my-2 bg-gray-50 m-2">
        <div class=" px-3 py-2  text-center">
            <div class="font-bold text-xl mb-2"><livewire:vehicles.count.combined-reminders-send-by-post /></div>
            <p class="text-grey-darker text-base text-center">
            Send by Post
            </p>
        </div>
    </div>
</div>


</x-app-layout>
