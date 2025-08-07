<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">配送先 編集</h1>

        <form action="{{ route('shipping_addresses.update', $shippingAddress->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold mb-1">郵便番号（ハイフンなし）</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $shippingAddress->postal_code) }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">住所</label>
                    <input type="text" name="address" value="{{ old('address', $shippingAddress->address) }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">宛名</label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $shippingAddress->recipient_name) }}" class="w-full border p-2 rounded">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        更新する
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>