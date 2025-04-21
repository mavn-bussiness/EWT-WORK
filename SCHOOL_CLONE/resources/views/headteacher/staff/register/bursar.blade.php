<x-app-layout title="Bursars Management">
    <x-card>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Register New Bursar</h2>
            </div>
        </x-slot>
        
        <form action="{{ route('headteacher.staff.register.bursar') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-input-group label="First Name" name="firstName" required />
                <x-input-group label="Last Name" name="lastName" required />
                <x-input-group label="Email" name="email" type="email" required />
                <x-input-group label="Phone Number" name="phoneNumber" required />
                <x-input-group label="Role" name="role" type="select" required>
                    <option value="chief_bursar">Chief Bursar</option>
                    <option value="assistant_bursar">Assistant Bursar</option>
                    <option value="accounts_clerk">Accounts Clerk</option>
                    <option value="cashier">Cashier</option>
                </x-input-group>
                <x-input-group label="Password" name="password" type="password" required />
                <x-input-group label="Confirm Password" name="password_confirmation" type="password" required />
            </div>
            
            <div class="mt-6 flex justify-end">
                <x-button type="submit">
                    Register Bursar
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card class="mt-6">
        <x-slot name="header">
            <h2 class="text-xl font-semibold">Current Bursars</h2>
        </x-slot>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Limit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bursarsList as $bursar)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $bursar->user->firstName }} {{ $bursar->user->lastName }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucwords(str_replace('_', ' ', $bursar->role)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $bursar->phoneNumber }}<br>
                                {{ $bursar->user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($bursar->transaction_limit)
                                    KES {{ number_format($bursar->transaction_limit) }}
                                @else
                                    Unlimited
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$bursar->user->is_active ? 'active' : 'inactive'" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>