<x-app-layout>
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
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('reminder.list.due', ['month'=>$month])" :active="request()->routeIs('reminder.list.due')">
                     {{ __('Reminders Due') }}
                    </x-nav-link>
                </div>
    </x-slot>

<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Combined Service and MOT Reminders</div></strong>
</div>
</div>
<table class="table-auto">
  <thead>
    <tr>
      <th class="w-1/5">Name</th>
      <th class="w-1/5">Service Reminder Date</th>
      <th class="w-1/5">MOT Reminder Date</th>
      <th class="w-1/5">To be Sent by</th>
      <th class="w-1/5">Valid contact?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Intro to CSS</td>
      <td>Adam</td>
      <td>858</td>
    </tr>
  </tbody>
</table>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Service Reminders</div></strong>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>MOT Reminders</div></strong>
</div>
</div>

</x-app-layout>
