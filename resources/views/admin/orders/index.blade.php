@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Pesanan</h1>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4">{{ $order->order_number }}</td>
                <td class="px-6 py-4">{{ $order->user->name }}</td>
                <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'processed') bg-blue-100 text-blue-800
                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-900">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection