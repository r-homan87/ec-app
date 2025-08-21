<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文詳細
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8 space-y-6">

        {{-- 注文情報 --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">注文情報</h3>
            <p class="mb-1"><strong>注文日:</strong> {{ $order->created_at->format('Y/m/d') }}</p>
            <p class="mb-1"><strong>配送先:</strong> {{ $order->shipping_postal_code }} {{ $order->shipping_address }}</p>
            <p class="mb-1"><strong>受取人:</strong> {{ $order->shipping_name }}</p>
            <p class="mb-1"><strong>支払方法:</strong> {{ $order->payment_method === 'credit_card' ? 'クレジットカード' : ($order->payment_method === 'bank_transfer' ? '銀行振込' : 'その他') }}</p>
            <p class="mb-1"><strong>ステータス:</strong> {{ \App\Models\Order::ORDER_STATUSES[$order->status] ?? '不明' }}</p>
        </div>

        {{-- 注文内容 --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">注文内容</h3>

            {{-- 請求情報 --}}
            @php
            $shippingFee = 800;
            $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
            $total = $subtotal + $shippingFee;
            @endphp

            <div class="mb-4 space-y-1">
                <p><strong>商品合計:</strong> ¥{{ number_format($subtotal) }}</p>
                <p><strong>送料:</strong> ¥800</p>
                <p class="font-bold"><strong>ご請求額:</strong> ¥{{ number_format($total) }}</p>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">商品</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">単価(税込)</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">個数</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">小計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">¥{{ number_format($item->price) }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ $item->quantity }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">¥{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>