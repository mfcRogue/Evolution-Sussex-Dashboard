
<x-app-layout>
@include('partials.loancar-nav')

<div class="flex m-1  text-center  flex-wrap content-evenly">
<div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
<table class="table-auto min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="w-1/5">Registration Number</th>
      <th class="w-1/5">Service Reminder Date</th>
      <th class="w-1/5">MOT Reminder Date</th>
      <th class="w-1/5">Mileage</th>
      <th class="w-1/5">Actions</th>
    </tr>
  </thead>
  <tbody>

  @foreach ($loancars as $loancar_data)
 @if ($loop->even)
  <tr class="bg-gray-200 text-center">
  @else
  <tr class="text-center">   
 @endif
    <td class="py-2">{{$loancar_data->reg_no}}</td>
    @if ($loancar_data->ServDueDate < now())
    <td class="bg-red-400">{{date('d-m-Y', strtotime($loancar_data->ServDueDate))}}</td>
    @else
    <td class="bg-green-400">{{date('d-m-Y', strtotime($loancar_data->ServDueDate))}}</td>
    @endif
    @if ($loancar_data->MOTDueDate < now())
    <td class="bg-red-400">{{date('d-m-Y', strtotime($loancar_data->MOTDueDate))}}</td>
    @else
    <td class="bg-green-400">{{date('d-m-Y', strtotime($loancar_data->MOTDueDate))}}</td>
    @endif
    <td>{{$loancar_data->mileage}}</td>    
    <td>
     <a href="{{route('loancar.edit', ['id'=>$loancar_data->id])}}" class="w-1/6 hover:bg-blue-300 bg-blue-600 border-2 border-blue-500 hover:border-blue-500 bg-transparent text-white hover:text-blue-600 py-1 px-2 font-semibold rounded-md"><i class="fas fa-edit"></i> Edit</a>
     <a href="{{route('loancar.destroy', ['id'=>$loancar_data->id])}}" class="w-1/6 hover:bg-red-300 bg-red-600 border-2 border-red-500 hover:border-red-500 bg-transparent text-white hover:text-red-600 py-1 px-2 font-semibold rounded-md"><i class="fas fa-trash"></i> Delete</a>
    </tr>
  @endforeach
     </tbody>
</table>
</div>
</div>
</x-app-layout>
