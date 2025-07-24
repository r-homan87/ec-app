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
                        <th class="px-4 py-2 text-left">購入日時</th>
                        <th class="px-4 py-2 text-left">注文個数</th>
                        <th class="px-4 py-2 text-left">注文ステータス</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-t">
                        <td class="px-4 py-2 text-blue-600 underline">
                            <a href="{{ route('admin.orders.show', $order->id) }}">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            {{ $order->orderItems->sum('quantity') }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $order->status_label }} {{-- 例: '未発送', '発送済み'など --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>