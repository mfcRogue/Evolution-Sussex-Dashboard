
<x-app-layout>
    @include('partials.autotrader-nav')
    <div class="flex m-1  text-center  flex-wrap content-evenly">
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <table class="table-auto min-w-full divide-y divide-gray-200">
      <thead>
        <tr>
          <th class="w-1/5">Registration Number</th>
          <th class="w-1/5">Status</th>
          <th class="w-1/5">Actions</th>
        </tr>
      </thead>
      <tbody>

      @foreach ($vehicles as $vehicles_data)
     @if ($loop->even)
      <tr class="bg-gray-200 text-center">
      @else
      <tr class="text-center">
     @endif
        <td class="py-2">{{$vehicles_data->reg}}</td>
        <td class="py-2">{{$vehicles_data->status}}</td>
        <td>

        </tr>
      @endforeach
         </tbody>
    </table>
    </div>
    </div>
    </x-app-layout>
