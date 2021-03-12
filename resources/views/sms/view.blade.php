<x-app-layout>
@include('partials.sms-nav')
<div class="shadow-md bg-gray-50">
<div class="flex m-1 text-center  flex-wrap content-center flex-col">



@foreach ($sms_messages as $sms_message)
    
    @if($loop->first)
        <div class="flex-auto bg-gray-50 text-gray-900 p-6 m-2 shadow-md rounded w-1/2 text-center">
            <span class="text-xs">{{ $sms_message->number }}</span>
        </div>
    @endif


@if ($sms_message->user == '0')
<div class="flex-auto bg-green-200 text-gray-900 p-6 m-2 shadow-md rounded w-1/2 text-right">
@else
<div class="flex-auto bg-gray-200 text-gray-900 p-6 m-2 shadow-md rounded w-1/2 text-left">
@endif



{{ $sms_message->message }}

<span class="text-xs mt-2 block">{{ date('d-m-Y H:i',strtotime($sms_message->created)) }}</span>

</div>

@endforeach
</div>   
<div class="flex m-4 text-center  flex-wrap content-center flex-col">
<div class="flex-auto bg-white text-gray-900 p-6 m-2 shadow-md rounded w-1/2 text-center">    
{{ $sms_messages->links() }}
</div>
</div>

</div>
</x-app-layout>