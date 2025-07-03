<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            注文詳細
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <p class="mb-2"><strong>注文番号:</strong> {{ $order->id }}</p>
        <p class="mb-4"><strong>合計金額:</strong> ¥{{ number_format($order->total_price) }}</p>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">商品名</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">数量</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">単価</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">小計</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">{{ $item->quantity }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">¥{{ number_format($item->price) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">¥{{ number_format($item->price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>