<div class="flex h-screen bg-gray-100 dark:bg-neutral-900 font-sans antialiased text-gray-800 dark:text-gray-100">
    <div class="w-2/3 p-6 flex flex-col">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Products</h2>

        <div class="flex-shrink-0 mb-4">
            <input wire:model.live="search" type="text" placeholder="Search products by name or SKU..." class="w-full px-5 py-3 border border-blue-300 rounded-xl shadow-sm 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors 
                        dark:bg-neutral-800 dark:border-blue-700 dark:text-gray-100">

            @if(session()->has('error'))
                <div class="mt-2 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg shadow-md">
                    {{ session('error') }}
                </div>
            @endif
            @if(session()->has('success'))
                <div
                    class="mt-2 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg shadow-md">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        {{-- Left panel item listing/item catalog --}}
        <div class="flex-grow overflow-y-auto pr-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($this->filteredItems as $item)
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden 
                                         transition-all duration-200 transform hover:scale-105 hover:shadow-xl">
                        <div class="p-4">
                            <div
                                class="w-full h-32 bg-gray-200 dark:bg-neutral-700 rounded-lg mb-3 flex items-center justify-center text-gray-400">
                                <span class="text-sm">Item Image</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $item->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">SKU: {{ $item->sku }}</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 font-bold">
                                $ {{ number_format($item->price, 2) }}
                            </p>
                        </div>
                        <button wire:click="addToCart({{ $item->id }})" class="w-full py-3 bg-indigo-600 text-white font-bold transition-colors duration-200 
                                                 hover:bg-indigo-700 rounded-b-2xl">
                            Add to Cart
                        </button>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400 mt-8">No products found.</p>
                @endforelse
            </div>
        </div>
    </div>
 {{-- Right panel --}}
    <div
        class="w-1/3 bg-white dark:bg-neutral-800 border-l dark:border-neutral-700 p-6 flex flex-col shadow-xl overflow-y-auto">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Checkout</h2>
        <div class="flex-grow pr-2">
            @forelse($this->cart as $cartItem)
                <div class="flex items-center justify-between p-4 mb-4 bg-gray-50 dark:bg-neutral-700 rounded-xl shadow-sm">
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $cartItem['name'] }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $cartItem['sku'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">$ {{ number_format($cartItem['price'], 2) }} each</p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="number" min="1" wire:model.live.debounce.500ms="cart.{{ $cartItem['id'] }}.quantity"
                            class="py-2.5 sm:py-3 px-4 block w-20 border-gray-200 rounded-lg sm:text-sm 
                                                 focus:border-blue-500 focus:ring-blue-500 
                                                 dark:bg-neutral-900 dark:border-neutral-700 
                                                 dark:text-neutral-400 dark:placeholder-neutral-500 
                                                 dark:focus:ring-neutral-600">

                        <button wire:click="removeFromCart({{ $cartItem['id'] }})"
                            class="p-2 text-red-500 hover:text-red-700 dark:hover:text-red-400">
                            ✕
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 dark:text-gray-500 mt-20">Your cart is empty.</p>
            @endforelse
        </div>

        {{-- checkout stert --}}
        <div class="flex-shrink-0 mt-6 space-y-4">
            <div class="space-y-2">
                <div>
                    <label for="customer"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                    <select wire:model="customer_id" id="customer" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                            focus:border-blue-500 focus:ring-blue-500 
                            dark:bg-neutral-900 dark:border-neutral-700 
                            dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="payment-method"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <select wire:model="payment_method_id" id="payment-method" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                            focus:border-blue-500 focus:ring-blue-500 
                            dark:bg-neutral-900 dark:border-neutral-700 
                            dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Select a payment method</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label for="discount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                    Amount</label>
                <input wire:model.live.blur="discount_amount" type="number" id="discount" min="0"
                    placeholder="Enter discount amount" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                        focus:border-blue-500 focus:ring-blue-500 
                        dark:bg-neutral-900 dark:border-neutral-700 
                        dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">$
                        {{ number_format($this->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Tax (15%):</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">$
                        {{ number_format($this->tax, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total before discount:</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">$
                        {{ number_format($this->totalBeforeDiscount, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mb-2 text-red-500 dark:text-red-400">
                    <span class="text-sm font-semibold">Discount:</span>
                    <span class="font-semibold">- $ {{ number_format($this->discount_amount, 2) }}</span>
                </div>
                <div
                    class="flex justify-between items-center text-xl font-bold mt-2 border-t border-gray-200 dark:border-neutral-700 pt-2">
                    <span>Final Total:</span>
                    <span>$ {{ number_format($this->total, 2) }}</span>
                </div>
                <div
                    class="flex justify-between items-center text-lg font-bold mt-2 border-t border-gray-200 dark:border-neutral-700 pt-2">
                    <span>Change Given:</span>
                    <span>$ {{ number_format($this->change, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0 mt-6">
            <input wire:model.live.blur="paid_amount" type="number" min="0" placeholder="Amount Paid" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                       focus:border-blue-500 focus:ring-blue-500 mb-4 
                       dark:bg-neutral-900 dark:border-neutral-700 
                       dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

            <button wire:click="checkout" wire:loading.attr="disabled" class="w-full py-4 bg-green-600 text-white font-bold text-lg rounded-xl 
                       transition-colors duration-200 hover:bg-green-700 disabled:opacity-50 
                       disabled:cursor-not-allowed shadow-lg">
                Complete Sale
            </button>
        </div>
    </div>
</div>