<x-app-layout>
@include('partials.accounts-nav')

<form action="{{route('sms.send')}}" method="POST">
  @csrf

    <div class="flex-auto bg-gray-50 p-6 rounded m-1">
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            File Upload
        </div>
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <input type="file" class="w-2/6" id="number" maxlength="11"  name="number" aria-describedby="number" placeholder="Enter Number" value="{{ old('number') }}">
        </div>    
        <div class="flex space-x-4  text-center  flex-wrap content-evenly justify-center">
            <small id="number" class="text-gray-500  block">Please ensure file is a CSV</small>
        </div>
    </div>

    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
        <div class="flex m-2 space-x-4  text-center  flex-wrap content-evenly justify-center">
            <button type="submit" class="w-1/6 hover:bg-blue-300 bg-blue-600 border-2 border-blue-500 hover:border-blue-500 bg-transparent text-white hover:text-blue-800 py-3 px-4 font-semibold rounded-md"><i class="fas fa-upload"></i> Upload</button>
        </div>
    </div>

</form>

</x-app-layout>
