<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">注文詳細</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto bg-white p-6 rounded shadow">

        {{-- 購入者情報 --}}
        <div class="mb-6">
            <h3 class="font-bold mb-2">購入者情報</h3>
            <p>氏名：{{ $order->user->last_name }} {{ $order->user->first_name }}</p>
            <p>注文日：{{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p>配送先：{{ $order->shippingAddress->postal_code }} {{ $order->shippingAddress->address }}</p>
            <p>支払方法：{{ $order->payment_method }}</p>
        </div>

        {{-- 注文ステータス更新フォーム --}}
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="mb-6">
            @csrf
            @method('PATCH')

            <label for="order_status" class="block font-semibold mb-1">注文ステータス</label>
            <select name="order_status" id="order_status" class="border rounded p-2 w-64">
                @foreach(\App\Models\Order::ORDER_STATUSES as $statusKey => $statusLabel)
                <option value="{{ $statusKey }}" @if($order->status === $statusKey) selected @endif>{{ $statusLabel }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">更新</button>
        </form>

        {{-- 注文商品テーブル --}}
        <table class="w-full table-auto border mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">商品名</th>
                    <th class="border px-4 py-2 text-right">単価（税込）</th>
                    <th class="border px-4 py-2 text-center">数量</th>
                    <th class="border px-4 py-2 text-right">小計</th>
                    <th class="border px-4 py-2 text-center">製作ステータス</th>
                    <th class="border px-4 py-2 text-center">更新</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2 text-right">¥{{ number_format($item->price) }}</td>
                    <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2 text-right">¥{{ number_format($item->price * $item->quantity) }}</td>
                    <td class="border px-4 py-2 text-center">
                        <form method="POST" action="{{ route('admin.orderItems.updateStatus', $item->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="production_status" class="border rounded p-1">
                                @foreach(\App\Models\OrderItem::PRODUCTION_STATUSES as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}" @if($item->production_status === $statusKey) selected @endif>{{ $statusLabel }}</option>
                                @endforeach
                            </select>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">更新</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 金額情報 --}}
        <div class="text-right space-y-2">
            <p>商品合計：¥{{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity)) }}</p>
            <p>送料：¥{{ number_format($order->shipping_fee) }}</p>
            <p class="font-bold">請求金額合計：¥{{ number_format($order->total_amount) }}</p>
        </div>

    </div>
</x-app-layout>