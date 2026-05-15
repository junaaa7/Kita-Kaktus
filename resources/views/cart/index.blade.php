@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto" style="margin-bottom: 100px;">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Keranjang Belanja</h1>
    
    @if(count($cart) > 0)
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                        <tr class="cart-item transition duration-200 ease-in-out hover:bg-gray-50 dark:hover:bg-gray-700" data-id="{{ $id }}" id="cart-row-{{ $id }}">
                            <td class="px-6 py-4 align-middle">
                                <input type="checkbox" class="item-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500" data-id="{{ $id }}" value="{{ $id }}">
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded mr-3">
                                    @endif
                                    <span class="text-gray-800 dark:text-white">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="text-gray-600 dark:text-gray-300 whitespace-nowrap">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2 update-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-900">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="subtotal text-green-600 dark:text-green-400 font-semibold whitespace-nowrap">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <form action="{{ route('cart.remove') }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 delete-btn">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-base text-gray-700 dark:text-gray-300 align-middle">
                                Total Terpilih:
                            </td>
                            <td class="px-6 py-4 font-bold text-base text-green-600 dark:text-green-400 whitespace-nowrap align-middle" id="selectedTotal">
                                Rp 0
                            </td>
                            <td class="px-6 py-4 align-middle"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="flex justify-between items-center">
            <div class="flex space-x-3">
                <form id="deleteSelectedForm" action="{{ route('cart.delete.selected') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected_ids" id="selectedIdsInput" value="">
                    <button type="submit" id="deleteSelectedBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih
                    </button>
                </form>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('collection.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-store mr-2"></i> Lanjut Belanja
                </a>
                <button type="button" id="checkoutSelectedBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-shopping-cart mr-2"></i> Checkout Terpilih
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
    // Select All checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectedTotalSpan = document.getElementById('selectedTotal');
    const checkoutSelectedBtn = document.getElementById('checkoutSelectedBtn');
    const deleteSelectedForm = document.getElementById('deleteSelectedForm');
    const selectedIdsInput = document.getElementById('selectedIdsInput');
    
    // Function to update total
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
        
        selectedTotalSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
        
        if (!anyChecked) {
            checkoutSelectedBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            checkoutSelectedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Select All functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateSelectedTotal();
        });
    }
    
    // Individual checkbox change
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(document.querySelectorAll('.item-checkbox')).every(cb => cb.checked);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
            }
            updateSelectedTotal();
        });
    });
    
    // Delete selected items - set value and submit form
    if (deleteSelectedForm) {
        deleteSelectedForm.addEventListener('submit', function(e) {
            const selectedIds = [];
            document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });
            
            if (selectedIds.length === 0) {
                e.preventDefault();
                alert('Pilih produk yang ingin dihapus terlebih dahulu!');
                return false;
            }
            
            if (!confirm(`Hapus ${selectedIds.length} produk yang dipilih?`)) {
                e.preventDefault();
                return false;
            }
            
            selectedIdsInput.value = JSON.stringify(selectedIds);
        });
    }
    
    // Checkout selected items
    if (checkoutSelectedBtn) {
        checkoutSelectedBtn.addEventListener('click', function() {
            const selectedIds = [];
            document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });
            
            if (selectedIds.length === 0) {
                alert('Pilih produk yang ingin di-checkout terlebih dahulu!');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("checkout.selected") }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_items[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        });
    }
    
    // Initialize total on page load
    updateSelectedTotal();
    
    // Single delete - just submit the form (will reload)
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Hapus produk ini dari keranjang?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection