@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto" style="margin-bottom: 100px;">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Keranjang Belanja</h1>
    
    @if(count($cart) > 0)

        {{-- FORM CHECKOUT TERSEMBUNYI --}}
        <form id="checkoutForm" method="POST" action="{{ route('checkout.selected') }}">
            @csrf
        </form>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="selectAll" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span>Pilih Semua</span>
                                </label>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                        <tr class="cart-item" id="cart-row-{{ $id }}">
                            <td class="px-6 py-4 align-middle">
                                <input 
                                    type="checkbox" 
                                    value="{{ $id }}" 
                                    class="item-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500"
                                >
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                            <i class="fas fa-cactus text-gray-500 dark:text-gray-400"></i>
                                        </div>
                                    @endif

                                    <span class="text-gray-800 dark:text-white font-medium">{{ $item['name'] }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <span class="text-gray-600 dark:text-gray-300">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <input 
                                    type="number" 
                                    name="quantity" 
                                    value="{{ $item['quantity'] }}" 
                                    min="1"
                                    data-id="{{ $id }}"
                                    data-price="{{ $item['price'] }}"
                                    class="quantity-input w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                >
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <span class="subtotal text-green-600 dark:text-green-400 font-semibold">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-middle">
                                <form action="{{ route('cart.remove') }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">

                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-base text-gray-700 dark:text-gray-300">
                                Total Terpilih:
                            </td>
                            <td class="px-6 py-4 font-bold text-base text-green-600 dark:text-green-400" id="selectedTotal">
                                Rp 0
                            </td>
                            <td class="px-6 py-4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="flex space-x-3">
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Hapus semua produk dari keranjang?')">
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
                    <i class="fas fa-credit-card mr-2"></i> Checkout Terpilih
                </button>
            </div>
        </div>

    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center" style="margin-bottom: 100px;">
            <i class="fas fa-shopping-cart text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Keranjang belanja kosong</p>

            <a href="{{ route('collection.index') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-store mr-2"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

<script>
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectedTotalSpan = document.getElementById('selectedTotal');
    const checkoutSelectedBtn = document.getElementById('checkoutSelectedBtn');
    const checkoutForm = document.getElementById('checkoutForm');

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function updateSelectedTotal() {
        let total = 0;
        let anyChecked = false;

        document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
            anyChecked = true;

            const row = checkbox.closest('tr');
            const subtotalText = row.querySelector('.subtotal').innerText;
            const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, ''));

            total += subtotal;
        });

        if (selectedTotalSpan) {
            selectedTotalSpan.innerText = formatRupiah(total);
        }

        if (checkoutSelectedBtn) {
            if (!anyChecked) {
                checkoutSelectedBtn.classList.add('opacity-50', 'cursor-not-allowed');
                checkoutSelectedBtn.disabled = true;
            } else {
                checkoutSelectedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                checkoutSelectedBtn.disabled = false;
            }
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateSelectedTotal();
        });
    }

    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(document.querySelectorAll('.item-checkbox')).every(cb => cb.checked);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
            }

            updateSelectedTotal();
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            let productId = this.dataset.id;
            let price = parseInt(this.dataset.price);
            let quantity = parseInt(this.value);

            if (quantity < 1 || isNaN(quantity)) {
                quantity = 1;
                this.value = 1;
            }

            fetch("{{ route('cart.update') }}", {
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
                    const subtotal = price * quantity;

                    row.querySelector('.subtotal').innerText = formatRupiah(subtotal);

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

    if (checkoutSelectedBtn) {
        checkoutSelectedBtn.addEventListener('click', function() {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked');

            if (selectedItems.length === 0) {
                alert('Pilih produk terlebih dahulu.');
                return;
            }

            checkoutForm.querySelectorAll('input[name="selected_items[]"]').forEach(input => input.remove());

            selectedItems.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_items[]';
                input.value = checkbox.value;

                checkoutForm.appendChild(input);
            });

            checkoutForm.submit();
        });
    }

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Hapus produk ini dari keranjang?')) {
                e.preventDefault();
            }
        });
    });

    updateSelectedTotal();
</script>
@endsection