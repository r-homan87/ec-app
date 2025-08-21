<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6">注文情報確認</h2>

        @php
        $shippingOption = $data['shipping_option'] ?? '';
        $recipient = $data['recipient_name'] ?? '';
        $postalCode = $data['postal_code'] ?? '';
        $address = $data['address'] ?? '';
        $shippingFee = 800;
        $subtotal = $cartItems->reduce(function ($carry, $item) {
        return $carry + ($item->product ? $item->product->price * $item->quantity : 0);
        }, 0);
        $total = $subtotal + $shippingFee;
        @endphp

        {{-- カート内容 --}}
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">商品名</th>
                        <th class="border px-4 py-2">単価(税込)</th>
                        <th class="border px-4 py-2">数量</th>
                        <th class="border px-4 py-2">小計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                    @if ($item->product)
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2 text-right">¥{{ number_format($item->product->price) }}</td>
                        <td class="border px-4 py-2 text-right">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2 text-right">¥{{ number_format($item->product->price * $item->quantity) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 金額 --}}
        <div class="mt-4 text-right space-y-1">
            <p>送料：<span class="font-semibold">{{ number_format($shippingFee) }}円</span></p>
            <p>商品合計：<span class="font-semibold">{{ number_format($subtotal) }}円</span></p>
            <p class="text-lg font-bold">請求金額：<span class="text-red-600">{{ number_format($total) }}円</span></p>
        </div>

        {{-- 支払方法 --}}
        <div class="flex mt-6 space-x-4">
            <h3 class="text-lg font-semibold min-w-[100px]">支払方法</h3>
            <p class="mt-1">
                {{ $data['payment_method'] === 'credit_card' ? 'クレジットカード' : ($data['payment_method'] === 'bank_transfer' ? '銀行振込' : 'その他') }}
            </p>
        </div>

        {{-- お届け先 --}}
        <div class="flex mt-6 space-x-4">
            <h3 class="text-lg font-semibold min-w-[100px]">お届け先</h3>
            <div class="flex flex-col mt-1">
                <p>〒{{ $postalCode }}</p>
                <p>{{ $address }}</p>
                <p>{{ $recipient }}</p>
            </div>
        </div>

        {{-- 注文確定ボタン --}}
        <form method="POST" action="{{ route('orders.store') }}" class="mt-6">
            @csrf
            @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                この内容で注文する
            </button>
        </form>
    </div>
</x-app-layout>