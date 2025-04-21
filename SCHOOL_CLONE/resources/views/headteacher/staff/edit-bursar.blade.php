<x-app-layout title="Edit Bursar">
    <x-card>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Edit Bursar</h2>
            </div>
        </x-slot>
        
        <form action="{{ route('headteacher.staff.update.bursar', $bursar) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-input-group label="First Name" name="firstName" :value="$bursar->user->firstName" required />
                <x-input-group label="Last Name" name="lastName" :value="$bursar->user->lastName" required />
                <x-input-group label="Email" name="email" type="email" :value="$bursar->user->email" required />
                <x-input-group label="Phone Number" name="phoneNumber" :value="$bursar->phoneNumber" required />
                <x-input-group label="Role" name="role" type="select" required>
                    <option value="chief_bursar" {{ $bursar->role == 'chief_bursar' ? 'selected' : '' }}>Chief Bursar</option>
                    <option value="assistant_bursar" {{ $bursar->role == 'assistant_bursar' ? 'selected' : '' }}>Assistant Bursar</option>
                    <option value="accounts_clerk" {{ $bursar->role == 'accounts_clerk' ? 'selected' : '' }}>Accounts Clerk</option>
                    <option value="cashier" {{ $bursar->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                </x-input-group>
                <x-input-group label="Transaction Limit" name="transaction_limit" type="number" :value="$bursar->transaction_limit" 
                               :disabled="$bursar->role == 'chief_bursar'"/>
            </div>
            
            <div class="mt-6 flex justify-between">
                <a href="{{ route('headteacher.staff.bursars') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    Cancel
                </a>
                <div>
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded mr-2" 
                            onclick="document.getElementById('delete-bursar-form').submit();">
                        Delete
                    </button>
                    <x-button type="submit">
                        Update Bursar
                    </x-button>
                </div>
            </div>
        </form>
        
        <form id="delete-bursar-form" action="{{ route('headteacher.staff.delete.bursar', $bursar) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </x-card>
</x-app-layout>