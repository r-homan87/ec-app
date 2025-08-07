<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">マイページ</h1>

        <div class="bg-white rounded shadow p-4 mb-6">
            <div class="flex items-center mb-2">
                <h2 class="font-semibold text-lg">登録情報</h2>
                <a href="{{ route('profile.edit') }}" class="ml-2 px-2 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                    編集する
                </a>
            </div>

            <table class="table-auto w-full">
                <tr>
                    <th class="text-left">氏名</th>
                    <td>{{ $user->last_name }}{{ $user->first_name }}</td>
                </tr>
                <tr>
                    <th class="text-left">カナ</th>
                    <td>{{ $user->last_name_kana }} {{ $user->first_name_kana }}</td>
                </tr>
                <tr>
                    <th class="text-left">郵便番号</th>
                    <td>{{ $user->postal_code }}</td>
                </tr>
                <tr>
                    <th class="text-left">住所</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th class="text-left">電話番号</th>
                    <td>{{ $user->phone_number }}</td>
                </tr>
                <tr>
                    <th class="text-left">メールアドレス</th>
                    <td>{{ $user->email }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-6 flex items-center gap-3">
            <h2 class="font-semibold text-lg">配送先</h2>
            <a href="{{ route('shipping_addresses.index') }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                一覧を見る
            </a>
        </div>

        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-lg">注文履歴</h2>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                一覧を見る
            </a>
        </div>
    </div>
</x-app-layout>