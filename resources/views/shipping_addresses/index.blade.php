<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">配送先一覧</h1>

        {{-- 新規登録フォーム --}}
        <form action="{{ route('orders.confirm') }}" method="POST">
            @csrf
            <div class="mb-6">
                <div class="mt-2 space-y-2">
                    <input type="text" name="new_postal_code" placeholder="郵便番号（ハイフンなし）" class="w-full border p-2 rounded">
                    <input type="text" name="new_address" placeholder="住所" class="w-full border p-2 rounded">
                    <input type="text" name="new_recipient_name" placeholder="宛名" class="w-full border p-2 rounded">
                </div>
                <div class="text-right mt-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        新規登録
                    </button>
                </div>
            </div>
        </form>

        {{-- 配送先一覧 --}}
        @if($shippingAddresses->isEmpty())
        <p>登録されている配送先はありません。</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border">郵便番号</th>
                        <th class="py-2 px-4 border">住所</th>
                        <th class="py-2 px-4 border">宛名</th>
                        <th class="py-2 px-4 border text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shippingAddresses as $address)
                    <tr>
                        <td class="py-2 px-4 border">{{ $address->postal_code }}</td>
                        <td class="py-2 px-4 border">{{ $address->address }}</td>
                        <td class="py-2 px-4 border">{{ $address->recipient_name }}</td>
                        <td class="py-2 px-4 border text-center space-x-2">
                            <a href="{{ route('shipping_addresses.edit', $address->id) }}" class="text-blue-600 hover:underline">編集</a>
                            <form action="{{ route('shipping_addresses.destroy', $address->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>