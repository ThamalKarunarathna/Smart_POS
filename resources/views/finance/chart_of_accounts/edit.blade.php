{{-- resources/views/finance/chart_accounts/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Chart of Account
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Update account details
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ url('/finance/chart-accounts') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Chart of Accounts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Form Header --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-indigo-50">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-indigo-100">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Account Information</h3>
                            <p class="text-sm text-gray-500">Update the details below</p>
                        </div>
                    </div>
                </div>

                {{-- Form Content --}}
                <form method="POST" action="{{ url('/finance/chart_of_accounts/'.$account->id) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Account Code --}}
                    <div class="space-y-2">
                        <label for="account_code" class="block text-sm font-medium text-gray-700">
                            Account Code <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H7l-4 3V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <input id="account_code" name="account_code" type="text" required
                                   value="{{ old('account_code', $account->account_code) }}"
                                   class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>
                    </div>

                    {{-- Account Name --}}
                    <div class="space-y-2">
                        <label for="account_name" class="block text-sm font-medium text-gray-700">
                            Account Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <input id="account_name" name="account_name" type="text" required
                                   value="{{ old('account_name', $account->account_name) }}"
                                   class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>
                    </div>

                    {{-- Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Type --}}
                        <div class="space-y-2">
                            <label for="account_type" class="block text-sm font-medium text-gray-700">
                                Account Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                    </svg>
                                </div>
                                <select id="account_type" name="account_type" required
                                        class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    @php($type = old('account_type', $account->account_type))
                                    <option value="ASSET"     {{ $type=='ASSET' ? 'selected' : '' }}>ASSET</option>
                                    <option value="LIABILITY"  {{ $type=='LIABILITY' ? 'selected' : '' }}>LIABILITY</option>
                                    <option value="INCOME"     {{ $type=='INCOME' ? 'selected' : '' }}>INCOME</option>
                                    <option value="EXPENSE"    {{ $type=='EXPENSE' ? 'selected' : '' }}>EXPENSE</option>
                                    <option value="EQUITY"     {{ $type=='EQUITY' ? 'selected' : '' }}>EQUITY</option>
                                </select>
                            </div>
                        </div>

                        {{-- Parent --}}
                        <div class="space-y-2">
                            <label for="parent_id" class="block text-sm font-medium text-gray-700">
                                Parent Account (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                </div>
                                <select id="parent_id" name="parent_id"
                                        class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    <option value="">None (Main Account)</option>
                                    @isset($parents)
                                        @foreach($parents as $p)
                                            <option value="{{ $p->id }}"
                                                {{ (string)old('parent_id', $account->parent_id) === (string)$p->id ? 'selected' : '' }}>
                                                {{ $p->account_code }} - {{ $p->account_name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description (Optional)
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                                  placeholder="Enter description...">{{ old('description', $account->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="space-y-2">
                        <label for="is_active" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            @php($active = old('is_active', (string)$account->is_active))
                            <select id="is_active" name="is_active"
                                    class="pl-10 w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="1" {{ $active === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $active === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                        <a href="{{ url('/finance/chart-accounts') }}"
                           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Cancel
                        </a>

                        <div class="flex items-center space-x-3">
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-sm hover:shadow">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tips --}}
            <div class="mt-6 bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 rounded-xl p-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-indigo-800">Tips</h3>
                        <div class="mt-2 text-sm text-indigo-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Avoid changing account type after posting transactions (audit safety)</li>
                                <li>Deactivate instead of deleting to keep ledger history consistent</li>
                                <li>Use parent accounts for grouping and clean reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
