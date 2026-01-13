<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Receipt
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Record customer payment for outstanding invoices
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <a href="{{ url('/pos/receipts') }}"
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Receipts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Error Messages -->
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

            <!-- Receipt Form -->
            <form method="POST" action="{{ url('/pos/receipts') }}" id="receiptForm">
                @csrf

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Form Content -->
                    <div class="p-6 space-y-6">
                        <!-- Receipt Header -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Receipt No
                                </label>
                                <input type="text" name="receipt_no" value="{{ old('receipt_no', $receiptNo) }}"
                                       class="w-full px-4 py-2.5 border-gray-300 rounded-lg bg-gray-50 text-gray-600 font-mono"
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Receipt Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="receipt_date" value="{{ old('receipt_date', date('Y-m-d')) }}"
                                       class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Customer <span class="text-red-500">*</span>
                                </label>
                                <select name="customer_id" id="customer_select"
                                        class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->customer_code }} - {{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Outstanding Orders Table -->
                        <div id="ordersSection" class="hidden">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Outstanding Orders</h3>
                            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order No</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance Amount</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody" class="bg-white divide-y divide-gray-200">
                                        <!-- Orders will be loaded here via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Received Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Received Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="received_amount" id="received_amount" step="0.01" min="0.01"
                                   value="{{ old('received_amount') }}"
                                   class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Payment Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Type <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_type" id="payment_type"
                                    class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">-- Select Payment Type --</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <!-- Cheque Fields (hidden by default) -->
                        <div id="chequeFields" class="hidden grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cheque No <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="cheque_no" id="cheque_no"
                                       value="{{ old('cheque_no') }}"
                                       class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cheque Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="cheque_date" id="cheque_date"
                                       value="{{ old('cheque_date') }}"
                                       class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="cheque_bank" id="cheque_bank"
                                       value="{{ old('cheque_bank') }}"
                                       class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Bank Field (hidden by default) -->
                        <div id="bankField" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bank <span class="text-red-500">*</span>
                            </label>
                            <select name="bank_id" id="bank_id"
                                    class="w-full px-4 py-2.5 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Bank --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->account_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Hidden fields for selected orders -->
                        <div id="hiddenFields"></div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Save Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const customerSelect = document.getElementById('customer_select');
        const ordersSection = document.getElementById('ordersSection');
        const ordersTableBody = document.getElementById('ordersTableBody');
        const paymentType = document.getElementById('payment_type');
        const chequeFields = document.getElementById('chequeFields');
        const bankField = document.getElementById('bankField');
        const receivedAmount = document.getElementById('received_amount');
        const hiddenFields = document.getElementById('hiddenFields');
        const receiptForm = document.getElementById('receiptForm');

        let selectedOrders = [];

        // Load customer orders when customer is selected
        customerSelect.addEventListener('change', function() {
            const customerId = this.value;
            
            if (customerId) {
                fetch(`/pos/receipts/customer-orders?customer_id=${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        selectedOrders = [];
                        ordersTableBody.innerHTML = '';
                        
                        if (data.orders && data.orders.length > 0) {
                            data.orders.forEach(order => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${order.order_no}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${order.created_at}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-right">${parseFloat(order.balance_amount).toFixed(2)}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <input type="number" step="0.01" min="0" max="${order.balance_amount}" 
                                               class="order-amount w-24 px-2 py-1 border-gray-300 rounded text-sm text-right" 
                                               data-order-id="${order.id}" 
                                               value="${order.balance_amount}" 
                                               disabled>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <input type="checkbox" class="order-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                                               data-order-id="${order.id}" 
                                               data-balance="${order.balance_amount}">
                                    </td>
                                `;
                                ordersTableBody.appendChild(row);
                            });
                            ordersSection.classList.remove('hidden');
                        } else {
                            ordersSection.classList.add('hidden');
                            alert('No outstanding orders found for this customer.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error loading customer orders.');
                    });
            } else {
                ordersSection.classList.add('hidden');
                selectedOrders = [];
            }
        });

        // Handle order checkbox changes
        ordersTableBody.addEventListener('change', function(e) {
            if (e.target.classList.contains('order-checkbox')) {
                const orderId = e.target.dataset.orderId;
                const row = e.target.closest('tr');
                const amountInput = row.querySelector('.order-amount');

                if (e.target.checked) {
                    amountInput.disabled = false;
                    amountInput.focus();
                    const amount = parseFloat(amountInput.value) || 0;
                    selectedOrders.push({ id: orderId, amount: amount });
                } else {
                    amountInput.disabled = true;
                    selectedOrders = selectedOrders.filter(o => o.id !== orderId);
                }
                updateHiddenFields();
                calculateTotal();
            }

            // Handle amount input changes
            if (e.target.classList.contains('order-amount')) {
                const orderId = e.target.dataset.orderId;
                const amount = parseFloat(e.target.value) || 0;
                const order = selectedOrders.find(o => o.id === orderId);
                if (order) {
                    order.amount = amount;
                    updateHiddenFields();
                    calculateTotal();
                }
            }
        });

        // Update hidden fields for form submission
        function updateHiddenFields() {
            hiddenFields.innerHTML = '';
            selectedOrders.forEach((order, index) => {
                hiddenFields.innerHTML += `
                    <input type="hidden" name="order_ids[${index}]" value="${order.id}">
                    <input type="hidden" name="amounts[${index}]" id="amount_${order.id}" value="${order.amount}">
                `;
            });
        }

        // Calculate total based on selected orders
        function calculateTotal() {
            let total = 0;
            selectedOrders.forEach(order => {
                total += order.amount || 0;
            });
            receivedAmount.value = total.toFixed(2);
        }

        // Handle payment type change
        paymentType.addEventListener('change', function() {
            const type = this.value;
            
            // Hide all fields first
            chequeFields.classList.add('hidden');
            bankField.classList.add('hidden');
            
            // Remove required attributes
            document.getElementById('cheque_no').removeAttribute('required');
            document.getElementById('cheque_date').removeAttribute('required');
            document.getElementById('cheque_bank').removeAttribute('required');
            document.getElementById('bank_id').removeAttribute('required');
            
            if (type === 'cheque') {
                chequeFields.classList.remove('hidden');
                document.getElementById('cheque_no').setAttribute('required', 'required');
                document.getElementById('cheque_date').setAttribute('required', 'required');
                document.getElementById('cheque_bank').setAttribute('required', 'required');
            } else if (type === 'bank') {
                bankField.classList.remove('hidden');
                document.getElementById('bank_id').setAttribute('required', 'required');
            }
        });

        // Form submission validation
        receiptForm.addEventListener('submit', function(e) {
            if (selectedOrders.length === 0) {
                e.preventDefault();
                alert('Please select at least one order.');
                return false;
            }
        });
    </script>
</x-app-layout>

