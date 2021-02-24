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
        @for ($i = 1; $i < 13; $i++)
        <x-nav-link :href="route('reminder.list.due', ['month'=>$i])">
            {{ date('F', strtotime('2020-'. $i)) }}
        </x-nav-link>
        @endfor
    </div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Combined Service and MOT Reminders</div></strong>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
<table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-1/6">Name</th>
      <th class="w-1/6">Registration Number</th>
      <th class="w-1/6">Service Reminder Date</th>
      <th class="w-1/6">MOT Reminder Date</th>
      <th class="w-1/6">To be Sent by</th>
      <th class="w-1/6">Actions</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($combined_data_due as $combined_records)
 @if ($loop->even)
  <tr class="bg-gray-200">   
  @else
  <tr>   
 @endif
    <td class="text-left">{{$combined_records->Title}} {{$combined_records->Name}}</td>
      <td>{{$combined_records->RegNo}}</td>

    <td>{{date('d-m-Y', strtotime($combined_records->ServDueDate))}}</td>
    <td>{{date('d-m-Y', strtotime($combined_records->MOTDueDate))}}</td>
    
    @if ($combined_records->Email <> '' or $combined_records->Email2 <> '')
        <td><i class="fas fa-at"></i></td>    
    @elseif ($combined_records->Str1 <> '')
        <td><i class="fas fa-sms"></i></td>
    @else
        <td><i class="fas fa-mail-bulk"></i></td>
    @endif
          <td>Edit | Delete | Valid?</td>
    </tr>
  @endforeach
   
  </tbody>
</table>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Service Reminders</div></strong>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
<table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-1/6">Name</th>
      <th class="w-1/6">Registration Number</th>
      <th class="w-1/6">Service Reminder Date</th>
      <th class="w-1/6">MOT Reminder Date</th>
      <th class="w-1/6">To be Sent by</th>
      <th class="w-1/6">Actions</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($service_data_due as $service_records)
 @if ($loop->even)
  <tr class="bg-gray-200">   
  @else
  <tr>   
 @endif
    <td class="text-left">{{$service_records->Title}} {{$service_records->Name}}</td>
    <td>{{$service_records->RegNo}}</td>

    <td>{{date('d-m-Y', strtotime($service_records->ServDueDate))}}</td>
    <td>{{date('d-m-Y', strtotime($service_records->MOTDueDate))}}</td>
    
    @if ($service_records->Email <> '' or $service_records->Email2 <> '')
        <td><i class="fas fa-at"></i></td>    
    @elseif ($service_records->Str1 <> '')
        <td><i class="fas fa-sms"></i></td>
    @else
        <td><i class="fas fa-mail-bulk"></i></td>
    @endif
          <td>Edit | Delete | Valid?</td>
    </tr>
  @endforeach
     </tbody>
</table>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>MOT Reminders</div></strong>
</div>
</div>
<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
<table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-1/6">Name</th>
      <th class="w-1/6">Registration Number</th>
      <th class="w-1/6">Service Reminder Date</th>
      <th class="w-1/6">MOT Reminder Date</th>
      <th class="w-1/6">To be Sent by</th>
      <th class="w-1/6">Actions</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($mot_data_due as $mot_records)
 @if ($loop->even)
  <tr class="bg-gray-200">   
  @else
  <tr>   
 @endif
    <td class="text-left">{{$mot_records->Title}} {{$mot_records->Name}}</td>
    <td>{{$mot_records->RegNo}}</td>

    <td>{{date('d-m-Y', strtotime($mot_records->ServDueDate))}}</td>
    <td>{{date('d-m-Y', strtotime($mot_records->MOTDueDate))}}</td>
    
    @if ($mot_records->Email <> '' or $mot_records->Email2 <> '')
        <td><i class="fas fa-at"></i></td>    
    @elseif ($mot_records->Str1 <> '')
        <td><i class="fas fa-sms"></i></td>
    @else
        <td><i class="fas fa-mail-bulk"></i></td>
    @endif
          <td>Edit | Delete | Valid?</td>
    </tr>
  @endforeach
     </tbody>
</table>
</div>
</div>
</x-app-layout>