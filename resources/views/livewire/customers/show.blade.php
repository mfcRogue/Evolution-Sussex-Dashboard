<div>
    {{-- The whole world belongs to you --}}
    <table class="text-left w-full">
		<thead class="bg-black flex text-white w-full">
			<tr class="flex w-full mb-4">
                <th class="p-4 w-1/4">ID</th>
				<th class="p-4 w-1/4">Name</th>
			</tr>
		</thead>
        <tbody class="bg-grey-light flex flex-col items-center justify-between overflow-y-scroll w-full" style="height: 50vh;">
        @foreach ($customers as $customer)
        	<tr class="flex w-full mb-4">
                <td class="p-4 w-1/4">{{$customer->CustomerID}}</td>
				<td class="p-4 w-1/4">{{$customer->Name}}</td>
			</tr>

    @endforeach
    		</tbody>
	</table>
</div>
    {{ $customers->links() }}
</div>
