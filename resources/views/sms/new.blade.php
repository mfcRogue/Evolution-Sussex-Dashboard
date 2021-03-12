<x-app-layout>
@include('partials.sms-nav')

<form action="{{route('sms.send')}}" method="POST">
  @csrf

    <div class="flex-auto bg-gray-50 p-6 rounded m-1">
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            Telephone Number
        </div>
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <input type="tel" class="w-2/6" id="number" maxlength="11"  name="number" aria-describedby="number" placeholder="Enter Number" value="{{ old('number') }}">
        </div>    
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            <small id="number" class="text-gray-500  block">Please ensure number is correct before sending and must start with 07 and be 11 digits long</small>
        </div>
    </div>

    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            Message
        </div>
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <input type="text" class="w-3/6" id="message" name="message" placeholder="Enter Message" value="{{ old('message') }}">
        </div>    
    </div>

    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <button type="submit" class="w-1/6 hover:bg-blue-300 bg-blue-600 border-2 border-blue-500 hover:border-blue-500 bg-transparent text-white hover:text-blue-800 py-3 px-4 font-semibold rounded-md"><i class="far fa-paper-plane"></i> Send</button>
        </div>
    </div>

</form>

</x-app-layout>