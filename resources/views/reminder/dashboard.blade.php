<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder System') }}
        </h2>
    </x-slot>

    <div class="flex m-1  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Combined Service and MOT Reminders</div></strong>
</div>
</div>
<div class="flex m-4 space-x-4  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$combined_count_due}}</div></strong>
    Due
  </div>
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$combined_count_due_overdue}}</div></strong>
    Overdue
  </div>
  <div class="flex-auto bg-gray-50	p-6 shadow-md  rounded">
    <strong><div>{{$combined_count_due_email}}</div></strong>
    Email
  </div>
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$combined_count_due_sms}}</div></strong>
    SMS
  </div>
      <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$combined_count_due_post}}</div></strong>
    Post
  </div>
</div>
      <div class="flex m-1  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>MOT Reminders</div></strong>
</div>
</div>
<div class="flex m-4 space-x-4  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$mot_count_due}}</div></strong>
    Due
  </div>
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$mot_count_due_overdue}}</div></strong>
    Overdue
  </div>
  <div class="flex-auto bg-gray-50	p-6 shadow-md  rounded">
    <strong><div>{{$mot_count_due_email}}</div></strong>
    Email
  </div>
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$mot_count_due_sms}}</div></strong>
    SMS
  </div>
      <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$mot_count_due_post}}</div></strong>
    Post
  </div>
</div>
<div class="flex m-1  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>Service Reminders</div></strong>
</div>
</div>
<div class="flex m-4 space-x-4  text-center content-between flex flex-wrap content-evenly">
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$service_count_due}}</div></strong>
    Due
  </div>
  <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$service_count_due_overdue}}</div></strong>
    Overdue
  </div>
  <div class="flex-auto bg-gray-50	p-6 shadow-md  rounded">
    <strong><div>{{$service_count_due_email}}</div></strong>
    Email
  </div>
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$service_count_due_sms}}</div></strong>
    SMS
  </div>
      <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <strong><div>{{$service_count_due_post}}</div></strong>
    Post
  </div>
</div>

</x-app-layout>
