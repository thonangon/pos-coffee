<div class=" w-full flex h-screen bg-gray-100 dark:bg-neutral-900 font-sans antialiased text-gray-800 dark:text-gray-100">
    <div class="w-1/2 p-6 flex flex-col">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Products</h2>

        <div class="flex-shrink-0 mb-4">
            <input wire:model.live="search" type="text" placeholder="Search products by name or SKU..."
                class="w-full px-5 py-3 border border-blue-300 rounded-xl shadow-sm 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors 
                        dark:bg-neutral-800 dark:border-blue-700 dark:text-gray-100">

            @if (session()->has('error'))
                <div class="mt-2 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg shadow-md">
                    {{ session('error') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div
                    class="mt-2 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg shadow-md">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        {{-- Categories Section --}}
        {{-- <div class="mb-4 flex items-center gap-2">

            <button wire:click="$set('filterCategories', null)" @class([
                'px-3 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap',
                'bg-gray-900 text-white dark:bg-white dark:text-gray-900' =>
                    $filterCategories === null,
                'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' =>
                    $filterCategories !== null,
            ])>
                All Categories
            </button>
            @foreach ($categoryList as $category)
                <button wire:click="$set('filterCategories', {{ $category->id }})" @class([
                    'px-3 py-1.5 text-sm font-medium rounded-lg whitespace-nowrap',
                    'bg-gray-900 text-white dark:bg-white dark:text-gray-900' =>
                        $filterCategories == $category->id,
                    'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' =>
                        $filterCategories != $category->id,
                ])>
                    {{ $category->name }}
                </button>
            @endforeach
        </div> --}}


        {{-- Left panel item listing/item catalog --}}
        <div class="flex-grow overflow-y-auto pr-2">
            <div class="grid grid-cols-4 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($this->filteredItems as $item)
                    <div
                        class=" dark:bg-neutral-800 rounded-3xl  overflow-hidden 
                                         transition-all duration-200 transform hover:scale-105 hover:shadow-xl">
                        <div>
                            <div
                                class="w-60 h-40 bg-gray-200 dark:bg-neutral-700 rounded mb-3 flex items-center justify-center text-gray-400">
                                @if ($item->image)
                                    <img wire:click = "addToCart({{ $item->id }})"
                                        src="http://127.0.0.1:8000/storage/{{ $item->image }}"
                                        alt="{{ $item->name }}" class="w-full h-full object-cover rounded-3xl">
                                @else
                                    <span class="text-2xl">{{ $item->name[0] }}</span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $item->name }}</h3>

                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 font-bold">
                                $ {{ number_format($item->price, 2) }}
                            </p>
                        </div>

                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400 mt-8">No products found.</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- Right panel --}}
    <div
        class="w-1/2 bg-white dark:bg-neutral-800 border-l dark:border-neutral-700 p-6 flex flex-col ">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">CHART</h2>
        <div class="mb-6 flex items-center gap-2">
            <div class="flex-grow">
                <select wire:model="customer_id" id="customer" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow">
                <select wire:model="payment_method_id" id="payment-method" class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">
                    <option value="">Select Cashier</option>
                    @foreach ($cashiers as $cashier)
                        <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- checkout stert --}}
        <div class="bg-white dark:bg-neutral-800 rounded-lg  ">

            <div >
                <table class="w-full text-left table-auto">
                    <thead class="bg-gray-50 dark:bg-neutral-700">
                        <tr>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 rounded-tl-lg">
                                Item
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                Quantity
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                                Price
                            </th>
                            <th scope="col"
                                class="p-4 text-xs font-medium text-right text-gray-500 uppercase dark:text-gray-400 rounded-tr-lg">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->cart as $cartItem)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition-colors duration-200">
                                <td class="p-4">
                                    <div>

                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $cartItem['name'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-2 text-center">
                                    <input type="number" min="1"
                                        wire:model.live.debounce.500ms="cart.{{ $cartItem['id'] }}.quantity"
                                        class="py-2.5 sm:py-3 px-4 block w-20 border-gray-200 rounded-lg sm:text-sm 
                                                 focus:border-blue-500 focus:ring-blue-500 
                                                 dark:bg-neutral-900 dark:border-neutral-700 
                                                 dark:text-neutral-400 dark:placeholder-neutral-500 
                                                 dark:focus:ring-neutral-600">
                                </td>
                                <td class="p-4 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                    $ {{ number_format($cartItem['price'] * $cartItem['quantity'], 2) }}
                                </td>
                                <td class="p-4 text-right">
                                    <button wire:click="removeFromCart({{ $cartItem['id'] }})"
                                        class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.19.982.707.982H19.5a1 1 0 00.959-.69l-1.391-6.955A1 1 0 0017 5H6.5">
                                        </path>
                                    </svg>
                                    <p class="mt-4 text-lg">Your cart is empty.</p>
                                    <p class="mt-2 text-sm">Add some items to get started!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (!empty($this->cart))
                <div class="mt-6">
                    <label for="discount"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Amount</label>
                    <input wire:model.live.blur="discount_amount" type="number" id="discount" min="0"
                        placeholder="Enter discount amount"
                        class="py-2.5 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-600 dark:text-white" />
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-neutral-700 space-y-3">
                    <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                        <span>Subtotal:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-100">$
                            {{ number_format($this->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                        <span>Tax (15%):</span>
                        <span class="font-medium text-gray-800 dark:text-gray-100">$
                            {{ number_format($this->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                        <span>Total before discount:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-100">$
                            {{ number_format($this->totalBeforeDiscount, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-semibold text-red-500 dark:text-red-400">
                        <span>Discount:</span>
                        <span>- $ {{ number_format($this->discount_amount, 2) }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center text-xl font-bold mt-4 pt-4 border-t border-gray-200 dark:border-neutral-700">
                        <span>Final Total:</span>
                        <span class="text-blue-600 dark:text-blue-400">$ {{ number_format($this->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-lg font-bold pt-2">
                        <span>Change Given:</span>
                        <span class="text-green-600 dark:text-green-400">$
                            {{ number_format($this->change, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex-shrink-0 mt-6">
            <input wire:model.live.blur="paid_amount" type="number" min="0" placeholder="Amount Paid"
                class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                       focus:border-blue-500 focus:ring-blue-500 mb-4 
                       dark:bg-neutral-900 dark:border-neutral-700 
                       dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">

            <button wire:click="checkout" wire:loading.attr="disabled"
                class="w-full py-4 bg-green-600 text-white font-bold text-lg rounded-xl 
                       transition-colors duration-200 hover:bg-green-700 disabled:opacity-50 
                       disabled:cursor-not-allowed shadow-lg">
                Complete Sale
            </button>
        </div>
    </div>
</div>
