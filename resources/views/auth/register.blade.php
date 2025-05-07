<x-guest-layout>
    <div class="RegisterHeader">
        <p style="text-align: center; font-size:25px;font-weight:bolder;">Create Your Account</p>
        <hr>
    </div>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username : ')" />
            <x-text-input placeholder="Enter the username..."  id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus/>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- phone numder -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number : ')" />
            <x-text-input placeholder="Enter the phone number..." id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus/>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- gender -->
        <div class="mt-4">
            <div class="radio-group inline-flex gap-2 border w-full p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-black">
                <x-input-label for="gender" :value="__('Gender : ')" />

                <input type="radio"  class="text-black mt-1" type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required autofocus/>
                <span class="pl-2">Male</span>
    
                <input type="radio"  class="text-black mt-1" type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required autofocus/>
                <span class="pl-4"> Female</span>

            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>
        
        <!-- address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address : ')" />
            <x-text-input  placeholder="Enter the address..." id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus/>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- photo-->
        <div class="mt-4">
            <x-input-label for="photo" :value="__('Photo : ')" />
            <x-text-input id="file" class="block mt-1 w-full border" style="padding: 5px;" type="file" name="photo" required />
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password :')" />

            <x-text-input placeholder="Enter the password..." id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        {{-- 
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password :')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
