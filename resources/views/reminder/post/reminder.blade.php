<x-app-layout>
@include('partials.reminder-nav')
@foreach($combined_data_due as $data)

        <img src="https://evolutionsussex.co.uk/public/img/header.jpg" width="100%"/>
        <p class="text-sm ml-10">
            {{$data->Title}} {{$data->Name}}</br>
            @if (!empty($data->{'Street 1'}))
                {{ $data->{'Street 1'} }}</br>
            @endif
            @if (!empty($data->{'Street 2'}))
                {{ $data->{'Street 2'} }}</br>
            @endif
            @if (!empty($data->Town))
                {{ $data->Town }}</br>
            @endif					
            @if (!empty($data->County))
                {{ $data->County }}</br>
            @endif	
            @if (!empty($data->Postcode))
                {{ $data->Postcode }}</br>
            @endif	
        </p>
        <p class="mt-2">Date Printed:{{ date('d/m/Y') }} </p>
        <p class="mt-2"> RE: Your Vehicle {{$data->RegNo}}</p>
        <p class="mt-4">
            I would like to take this opportunity of reminding you that your MOT is due before the {{date('d/m/Y', strtotime($data->MOTDueDate))}}
            </br>
            Your service is also due around the {{date('d/m/Y', strtotime($data->ServDueDate))}}
        </p>
        <p class="mt-2">
            Should you wish us to undertake the MoT please do not hesitate to contact David the Service Advisor, and he will be more than happy to book your car in for you.
        </p>
        <p class="break_bottom"></p>
        <p class="mt-2">Your sincerely,</p>
        <p class="mt-2">David Evans, Service Advisor</p>
        <p class="mt-2">service@evosussex.co.uk</p>
        <p class="mt-2">01273 388804</p>
        <div class="page-break"></div>
@endforeach
@foreach($mot_data_due as $data)

        <img src="https://evolutionsussex.co.uk/public/img/header.jpg" width="100%"/>
        <p class="text-sm ml-10">
            {{$data->Title}} {{$data->Name}}</br>
            @if (!empty($data->{'Street 1'}))
                {{ $data->{'Street 1'} }}</br>
            @endif
            @if (!empty($data->{'Street 2'}))
                {{ $data->{'Street 2'} }}</br>
            @endif
            @if (!empty($data->Town))
                {{ $data->Town }}</br>
            @endif					
            @if (!empty($data->County))
                {{ $data->County }}</br>
            @endif	
            @if (!empty($data->Postcode))
                {{ $data->Postcode }}</br>
            @endif	
        </p>
        <p class="mt-2">Date Printed:{{ date('d/m/Y') }} </p>
        <p class="mt-2"> RE: Your Vehicle {{$data->RegNo}}</p>
        <p class="mt-4">
            I would like to take this opportunity of reminding you that your MOT is due before the {{date('d/m/Y', strtotime($data->MOTDueDate))}}
        </p>
        <p class="mt-2">
            Should you wish us to undertake the MoT please do not hesitate to contact David the Service Advisor, and he will be more than happy to book your car in for you.
        </p>
        <p class="break_bottom"></p>
        <p class="mt-2">Your sincerely,</p>
        <p class="mt-2">David Evans, Service Advisor</p>
        <p class="mt-2">service@evosussex.co.uk</p>
        <p class="mt-2">01273 388804</p>
        <div class="page-break"></div>
@endforeach


</x-app-layout>
