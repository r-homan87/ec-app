<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            カート一覧
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow p-6 rounded">

            @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
            @endif

            @if ($cartItems->isEmpty())
            <p>カートは空です。</p>
            @else
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">商品名</th>
                        <th class="px-4 py-2">価格</th>
                        <th class="px-4 py-2">数量</th>
                        <th class="px-4 py-2">小計</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cartItems as $item)
                    @php
                    $subtotal = $item->product->price * $item->quantity;
                    $total += $subtotal;
                    @endphp
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2">¥{{ number_format($item->product->price) }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="w-16 border rounded text-center" />
                                <button type="submit" class="text-blue-600 hover:underline text-sm">変更</button>
                            </form>
                        </td>
                        <td class="border px-4 py-2">¥{{ number_format($subtotal) }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="font-bold bg-gray-100">
                        <td colspan="3" class="text-right px-4 py-2">合計</td>
                        <td class="px-4 py-2">¥{{ number_format($total) }}</td>
                    </tr>
                </tbody>
            </table>
            @endif

            @if (!$cartItems->isEmpty())
            <div class="mt-6">
                <a href="{{ route('orders.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    情報入力に進む
                </a>
            </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    買い物を続ける
                </a>
            </div>
        </div>
    </div>
</x-app-layout>