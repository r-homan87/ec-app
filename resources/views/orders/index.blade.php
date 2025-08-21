<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文履歴
        </h2>
    </x-slot>

    <div class="py-8 px-4">
        @forelse ($orders as $order)
        <div class="mb-6 border p-4 rounded shadow">
            <p><strong>注文日:</strong> {{ $order->created_at->format('Y/m/d') }}</p>
            <p><strong>合計金額:</strong> ¥{{ number_format($order->total_price) }}</p>
            <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:underline">詳細を見る</a>
        </div>
        @empty
        <p>注文履歴がありません。</p>
        @endforelse
    </div>
</x-app-layout>