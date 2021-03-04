<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SMS System') }}
        </h2>
        <div class="flex">
        <!-- Reminder Navigation -->
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.dashboard')" :active="request()->routeIs('sms.dashboard')">
                     {{ __('Active Conversations') }}
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.dashboard')" :active="request()->routeIs('sms.dashboard')">
                     {{ __('Archived Conversations') }}
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.new')" :active="request()->routeIs('sms.new')">
                     {{ __('New Message') }}
                    </x-nav-link>
                </div>
    </x-slot>

    <div class="flex m-1  text-center  flex-wrap content-evenly">
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">

    <table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-2/6">Customer Name</th>
      <th class="w-1/6">Number</th>
      <th class="w-1/6">Updated</th>
      <th class="w-1/6">Actions</th>
    </tr>
  </thead>
  <tbody>

   @foreach ($sms_active as $sms_records)
    @if ($loop->even)
        <tr class="bg-gray-200">   
    @else
        <tr>   
    @endif
   <td>{{$sms_records->number}}</td>
   <td>{{$sms_records->number}}</td>
   <td>{{date('d-m-Y', strtotime($sms_records->updated))}}</td>
   <td>Edit | Archive</td>
   @endforeach
  </tbody>
</table>

    </div>
</div>
</x-app-layout>