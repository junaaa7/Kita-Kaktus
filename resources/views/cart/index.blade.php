@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4" style="margin-bottom: 100px;">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-6">Keranjang Belanja</h1>
    
    @if(count($cart) > 0)

        {{-- FORM CHECKOUT TERSEMBUNYI --}}
        <form id="checkoutForm" method="POST" action="{{ secure_url('/checkout-selected') }}">
            @csrf
        </form>

        <!-- Tampilan Desktop (Table) -->
        <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="selectAll" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span>Pilih Semua</span>
                                </label>
                            </th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                            <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                        <tr class="cart-item hover:bg-gray-50 dark:hover:bg-gray-700 transition" id="cart-row-{{ $id }}">
                            <td class="px-4 md:px-6 py-3 md:py-4 align-middle">
                                <input type="checkbox" value="{{ $id }}" class="item-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500">
                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4">
                                <div class="flex items-center space-x-3">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-10 h-10 md:w-12 md:h-12 object-cover rounded">
                                    @else
                                        <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                            <i class="fas fa-cactus text-gray-500 dark:text-gray-400 text-sm md:text-base"></i>
                                        </div>
                                    @endif

                                    <span class="text-sm md:text-base text-gray-800 dark:text-white font-medium">{{ $item['name'] }}</span>
                                </div>
                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 align-middle">
                                <span class="text-sm md:text-base text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 align-middle">
                                <input 
                                    type="number" 
                                    name="quantity" 
                                    value="{{ $item['quantity'] }}" 
                                    min="1"
                                    data-id="{{ $id }}"
                                    data-price="{{ $item['price'] }}"
                                    class="quantity-input w-16 md:w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm md:text-base"
                                >
                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 align-middle">
                               <span class="subtotal text-green-600 dark:text-green-400 font-semibold whitespace-nowrap text-sm md:text-base">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-4 md:px-6 py-3 md:py-4 align-middle">
                                <form action="{{ secure_url('/cart/remove') }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">

                                    <button type="submit" class="text-red-500 hover:text-red-700 transition p-1">
                                        <i class="fas fa-trash-alt text-sm md:text-base"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700">
                        <tr>
                            <td colspan="6" class="px-4 md:px-6 py-3 md:py-4">
                                <div class="flex justify-end items-center gap-2 md:gap-3">
                                    <span class="font-bold text-sm md:text-base text-gray-700 dark:text-gray-300">
                                        Total Terpilih:
                                    </span>

                                    <span class="font-bold text-base md:text-lg text-green-600 dark:text-green-400 whitespace-nowrap" id="selectedTotal">
                                        Rp 0
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tampilan Mobile (Card) -->
        <div class="block md:hidden space-y-4 mb-6">
            @foreach($cart as $id => $item)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 cart-item-card" id="cart-card-{{ $id }}">
                <div class="flex items-start space-x-3">
                    <input type="checkbox" value="{{ $id }}" class="item-checkbox-mobile mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    
                    <div class="flex-1">
                        <div class="flex items-start space-x-3">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                    <i class="fas fa-cactus text-gray-500 dark:text-gray-400 text-xl"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 dark:text-white text-sm">{{ $item['name'] }}</h3>
                                <p class="text-green-600 font-bold text-sm mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Jumlah:</span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" class="quantity-minus w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition flex items-center justify-center" data-id="{{ $id }}" data-price="{{ $item['price'] }}">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="quantity-value-mobile w-10 text-center font-medium text-gray-800 dark:text-white" data-id="{{ $id }}">{{ $item['quantity'] }}</span>
                                    <button type="button" class="quantity-plus w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition flex items-center justify-center" data-id="{{ $id }}" data-price="{{ $item['price'] }}">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Subtotal:</span>
                                <span class="subtotal-mobile text-green-600 font-semibold text-sm" data-id="{{ $id }}">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="mt-2 pt-2 flex justify-end">
                                <form action="{{ secure_url('/cart/remove') }}" method="POST" class="delete-form-mobile">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition text-sm">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-bold text-gray-700 dark:text-gray-300">Total Terpilih:</span>
                    <span class="font-bold text-lg text-green-600 dark:text-green-400" id="selectedTotalMobile">Rp 0</span>
                </div>
                
                <div class="flex justify-end">
                    <form action="{{ secure_url('/cart/clear') }}" method="POST" onsubmit="return confirm('Hapus semua produk dari keranjang?')" class="mr-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition text-sm">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Tombol Aksi untuk Desktop -->
        <div class="hidden md:flex justify-between items-center">
            <div class="flex space-x-3">
                <form action="{{ secure_url('/cart/clear') }}" method="POST" onsubmit="return confirm('Hapus semua produk dari keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-trash-alt mr-2"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('collection.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-store mr-2"></i> Lanjut Belanja
                </a>

                <button type="button" id="checkoutSelectedBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-credit-card mr-2"></i> Checkout
                </button>
            </div>
        </div>
        
        <!-- Tombol Aksi untuk Mobile -->
        <div class="block md:hidden mt-4">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('collection.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition text-center">
                    <i class="fas fa-store mr-2"></i> Lanjut Belanja
                </a>
                <button type="button" id="checkoutSelectedBtnMobile" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition">
                    <i class="fas fa-credit-card mr-2"></i> Checkout
                </button>
            </div>
        </div>

    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 md:p-12 text-center" style="margin-bottom: 100px;">
            <i class="fas fa-shopping-cart text-5xl md:text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-base md:text-lg">Keranjang belanja kosong</p>

            <a href="{{ route('collection.index') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-store mr-2"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

<script>
    // ==================== VARIABLES ====================
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectedTotalSpan = document.getElementById('selectedTotal');
    const selectedTotalSpanMobile = document.getElementById('selectedTotalMobile');
    const checkoutSelectedBtn = document.getElementById('checkoutSelectedBtn');
    const checkoutSelectedBtnMobile = document.getElementById('checkoutSelectedBtnMobile');
    const checkoutForm = document.getElementById('checkoutForm');

    // Format Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    // ==================== UPDATE TOTAL ====================
    function updateSelectedTotal() {
        let total = 0;
        let anyChecked = false;

        // Desktop checkboxes
        document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
            anyChecked = true;
            const row = checkbox.closest('tr');
            const subtotalText = row.querySelector('.subtotal').innerText;
            const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, ''));
            total += subtotal;
        });

        // Mobile checkboxes
        document.querySelectorAll('.item-checkbox-mobile:checked').forEach(checkbox => {
            anyChecked = true;
            const card = checkbox.closest('.cart-item-card');
            const subtotalText = card.querySelector('.subtotal-mobile').innerText;
            const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, ''));
            total += subtotal;
        });

        if (selectedTotalSpan) selectedTotalSpan.innerText = formatRupiah(total);
        if (selectedTotalSpanMobile) selectedTotalSpanMobile.innerText = formatRupiah(total);

        // Disable/enable checkout button
        const btns = [checkoutSelectedBtn, checkoutSelectedBtnMobile].filter(btn => btn);
        btns.forEach(btn => {
            if (!anyChecked) {
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.disabled = true;
            } else {
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btn.disabled = false;
            }
        });
    }

    // ==================== SELECT ALL (DESKTOP) ====================
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox, .item-checkbox-mobile').forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateSelectedTotal();
        });
    }

    // ==================== INDIVIDUAL CHECKBOX (DESKTOP) ====================
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(document.querySelectorAll('.item-checkbox, .item-checkbox-mobile')).every(cb => cb.checked);
            if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
            updateSelectedTotal();
        });
    });

    // ==================== INDIVIDUAL CHECKBOX (MOBILE) ====================
    document.querySelectorAll('.item-checkbox-mobile').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(document.querySelectorAll('.item-checkbox, .item-checkbox-mobile')).every(cb => cb.checked);
            if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
            updateSelectedTotal();
        });
    });

    // ==================== UPDATE QUANTITY (DESKTOP) ====================
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            let productId = this.dataset.id;
            let price = parseInt(this.dataset.price);
            let quantity = parseInt(this.value);

            if (quantity < 1 || isNaN(quantity)) {
                quantity = 1;
                this.value = 1;
            }

            fetch("{{ secure_url('/cart/update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    id: productId,
                    quantity: quantity,
                    _method: "PUT"
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = this.closest('tr');
                    const card = document.getElementById('cart-card-' + productId);
                    const subtotal = price * quantity;

                    if (row) row.querySelector('.subtotal').innerText = formatRupiah(subtotal);
                    if (card) card.querySelector('.subtotal-mobile').innerText = formatRupiah(subtotal);
                    if (card) card.querySelector('.quantity-value-mobile').innerText = quantity;

                    updateSelectedTotal();
                } else {
                    alert('Gagal update jumlah produk.');
                }
            })
            .catch(error => {
                alert('Gagal update jumlah produk.');
                console.error(error);
            });
        });
    });

    // ==================== QUANTITY BUTTONS (MOBILE) ====================
    document.querySelectorAll('.quantity-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const price = parseInt(this.dataset.price);
            const quantitySpan = document.querySelector(`.quantity-value-mobile[data-id="${id}"]`);
            let currentQty = parseInt(quantitySpan.innerText);
            
            if (currentQty > 1) {
                const newQty = currentQty - 1;
                quantitySpan.innerText = newQty;
                
                fetch("{{ secure_url('/cart/update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ id: id, quantity: newQty, _method: "PUT" })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = document.getElementById('cart-card-' + id);
                        const row = document.querySelector(`#cart-row-${id}`);
                        const subtotal = price * newQty;
                        
                        if (card) card.querySelector('.subtotal-mobile').innerText = formatRupiah(subtotal);
                        if (row) row.querySelector('.subtotal').innerText = formatRupiah(subtotal);
                        if (row) row.querySelector('.quantity-input').value = newQty;
                        
                        updateSelectedTotal();
                    }
                });
            }
        });
    });

    document.querySelectorAll('.quantity-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const price = parseInt(this.dataset.price);
            const quantitySpan = document.querySelector(`.quantity-value-mobile[data-id="${id}"]`);
            let currentQty = parseInt(quantitySpan.innerText);
            const newQty = currentQty + 1;
            quantitySpan.innerText = newQty;
            
            fetch("{{ secure_url('/cart/update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ id: id, quantity: newQty, _method: "PUT" })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById('cart-card-' + id);
                    const row = document.querySelector(`#cart-row-${id}`);
                    const subtotal = price * newQty;
                    
                    if (card) card.querySelector('.subtotal-mobile').innerText = formatRupiah(subtotal);
                    if (row) row.querySelector('.subtotal').innerText = formatRupiah(subtotal);
                    if (row) row.querySelector('.quantity-input').value = newQty;
                    
                    updateSelectedTotal();
                }
            });
        });
    });

    // ==================== CHECKOUT SELECTED ====================
    function processCheckout() {
        const selectedItems = [...document.querySelectorAll('.item-checkbox:checked'), ...document.querySelectorAll('.item-checkbox-mobile:checked')];

        if (selectedItems.length === 0) {
            alert('Pilih produk terlebih dahulu.');
            return;
        }

        // Hapus input lama
        checkoutForm.querySelectorAll('input[name="selected_items[]"]').forEach(input => input.remove());

        // Tambah input baru
        selectedItems.forEach(item => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = item.value;
            checkoutForm.appendChild(input);
        });

        checkoutForm.submit();
    }

    if (checkoutSelectedBtn) checkoutSelectedBtn.addEventListener('click', processCheckout);
    if (checkoutSelectedBtnMobile) checkoutSelectedBtnMobile.addEventListener('click', processCheckout);

    // ==================== DELETE FORM CONFIRM ====================
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Hapus produk ini dari keranjang?')) {
                e.preventDefault();
            }
        });
    });

    document.querySelectorAll('.delete-form-mobile').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Hapus produk ini dari keranjang?')) {
                e.preventDefault();
            }
        });
    });

    // ==================== INITIALIZE ====================
    updateSelectedTotal();
</script>
@endsection