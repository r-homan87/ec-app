<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            注文情報入力
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <form action="{{ route('orders.confirm') }}" method="POST">
            @csrf

            {{-- 支払方法 --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">支払方法</label>
                <label>
                    <input type="radio" name="payment_method" value="credit_card" required>
                    クレジットカード
                </label><br>
                <label>
                    <input type="radio" name="payment_method" value="bank_transfer">
                    銀行振込
                </label>

                @error('payment_method')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- お届け先 --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">お届け先</label>

                {{-- 自分の住所 --}}
                <label>
                    <input type="radio" name="shipping_option" value="myself" checked>
                    ご自身の住所
                </label>

                {{-- 登録済住所 --}}
                <br>
                <label>
                    <input type="radio" name="shipping_option" value="registered">
                    登録済住所から選択
                </label>
                <select name="registered_address_id" class="mt-2 block w-full border rounded p-2">
                    <option value="">選択してください</option>
                    @foreach ($shippingAddresses as $address)
                    <option value="{{ $address->id }}">
                        {{ $address->postal_code }} {{ $address->address }} {{ $address->recipient_name }}
                    </option>
                    @endforeach
                </select>

                {{-- 新しい住所 --}}
                <br>
                <label>
                    <input type="radio" name="shipping_option" value="new">
                    新しいお届け先
                </label>
                <div class="mt-2 space-y-2">
                    <input type="text" name="new_postal_code" placeholder="郵便番号（ハイフンなし）" class="w-full border p-2 rounded">
                    @error('new_postal_code')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror

                    <input type="text" name="new_address" placeholder="住所" class="w-full border p-2 rounded">
                    @error('new_address')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror

                    <input type="text" name="new_recipient_name" placeholder="宛名" class="w-full border p-2 rounded">
                    @error('new_recipient_name')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                @error('shipping_option')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
                @error('registered_address_id')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- hiddenで空データを送る（NULLエラー防止） --}}
            <input type="hidden" name="shipping_postal_code" value="">
            <input type="hidden" name="shipping_address" value="">
            <input type="hidden" name="shipping_name" value="">

            {{-- 送信 --}}
            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    確認画面へ進む
                </button>
            </div>
        </form>
    </div>
</x-app-layout>