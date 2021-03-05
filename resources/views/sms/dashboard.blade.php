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

    @if (session('status'))
    <div class="min-w-full p-2.5 bg-green-500 text-center content-center text-white">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex m-1  text-center  flex-wrap content-evenly">
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">

    <table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-2/6">Customer Name</th>
      <th class="w-1/6">Number</th>
      <th class="w-1/6">Updated</th>
      <th class="w-2/6">Actions</th>
    </tr>
  </thead>
  <tbody>

   @foreach ($sms_active as $sms_records)
    @if ($loop->even)
        <tr class="bg-gray-200">   
    @else
        <tr>   
    @endif
   <td class="py-2">{{$sms_records->number}}</td>
   <td>{{$sms_records->number}}</td>
   <td>{{date('d-m-Y H:i', strtotime($sms_records->updated))}}</td>
   <td>
    <a href="{{route('sms.view', ['id'=>$sms_records->id])}}" class="w-1/6 hover:bg-blue-300 bg-blue-600 border-2 border-blue-500 hover:border-blue-500 bg-transparent text-white hover:text-blue-600 py-1 px-2 font-semibold rounded-md"><i class="fas fa-eye"></i> View</a>
    <a href="{{route('sms.archive', ['id'=>$sms_records->id])}}" class="w-1/6 hover:bg-red-300 bg-red-600 border-2 border-red-500 hover:border-red-500 bg-transparent text-white hover:text-red-600 py-1 px-2 font-semibold rounded-md"><i class="fas fa-boxes"></i> Archive</a>
   </td>
   @endforeach
  </tbody>
</table>

    </div>
</div>
</x-app-layout>