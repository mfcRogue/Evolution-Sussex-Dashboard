<x-app-layout>
@include('partials.loancar-nav')

@foreach ($loancars as $loancar_data)

@endforeach

<form action="{{route('loancar.update', ['id' => $loancar_data->id])}}" method="POST">
  @csrf

    <div class="flex-auto bg-gray-50 p-6 rounded m-1">
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            Registration Number
        </div>
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <input type="text" class="w-2/6" id="text" maxlength="11"  name="regnumber" aria-describedby="regnumber" placeholder="Enter Registation Number" 
            @if($request->flash())
            value="{{ old('regnumber') }}"
            @else
            value="{{$loancar_data->reg_no}}"
            @endif
            >
            
        </div>   
    </div>
        <div class="flex-auto bg-gray-50 p-6 rounded m-1">
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            Mileage
        </div>
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <input type="number" class="w-2/6" id="text" maxlength="11"  name="mileage" aria-describedby="miileage" placeholder="Enter Mileage" 
            @if($request->flash())
            value="{{ old('mileage') }}"
            @else
            value="{{$loancar_data->mileage}}"
            @endif
            >
        </div>   
    </div>

    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <button type="submit" class="w-1/6 hover:bg-blue-300 bg-blue-600 border-2 border-blue-500 hover:border-blue-500 bg-transparent text-white hover:text-blue-800 py-3 px-4 font-semibold rounded-md"><i class="far fa-paper-plane"></i> Send</button>
        </div>
    </div>

</form>

</x-app-layout>
