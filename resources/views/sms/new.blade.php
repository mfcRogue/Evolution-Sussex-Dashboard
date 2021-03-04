<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SMS System') }}
        </h2>
        <div class="flex">
        <!-- Reminder Navigation -->
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.dashboard')" :active="request()->routeIs('sms.dashboard')">
                     {{ __('Active Conversations') }}
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.dashboard')" :active="request()->routeIs('sms.dashboard')">
                     {{ __('Archived Conversations') }}
                    </x-nav-link>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <x-nav-link :href="route('sms.new')" :active="request()->routeIs('sms.new')">
                     {{ __('New Message') }}
                    </x-nav-link>
                </div>
    </x-slot>

 
    @if ($errors->any())
    <div class="flex-auto bg-gray-50 p-6 shadow-md rounded">
    <div class="flex m-1  text-center  flex-wrap content-evenly">
    <b>The following errors have been found</b>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    </div>
@endif

<form action="/sms/send" method="POST">
  @csrf
  <div class="form-group">
     <label for="number">Telephone Number</label>
    <input type="number" class="form-control" id="number" name="number" aria-describedby="number" placeholder="Enter Number" value="  ">
    <small id="number" class="form-text text-muted">Please ensure number is correct before sending and must start with 07 and be 11 digits long</small>
  </div>
  <div class="form-group">
    <label for="message">Message</label>
    <input type="text" class="form-control" id="message" name="message" placeholder="Enter Message" value="{{ old('message') }}">
  </div>
  <button type="submit" class="btn btn-primary">Create</button>
</form>
    </div>
</div>
</x-app-layout>