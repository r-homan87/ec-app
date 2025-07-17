<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $user->last_name }} {{ $user->first_name }} さんの注文履歴
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">
        @if ($orders->isEmpty())
        <p class="text-gray-600">注文履歴はありません。</p>
        @else
        <div class="bg-white shadow rounded p-6">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">注文ID</th>
                        <th class="px-4 py-2 text-left">注文日</th>
                        <th class="px-4 py-2 text-left">合計金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2">¥{{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>