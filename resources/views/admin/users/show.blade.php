<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">会員詳細</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <dl class="text-sm space-y-4">
                <div>
                    <dt class="font-bold">会員ID：</dt>
                    <dd>{{ $user->id }}</dd>
                </div>

                <div>
                    <dt class="font-bold">氏名：</dt>
                    <dd>{{ $user->last_name }} {{ $user->first_name }}</dd>
                </div>

                <div>
                    <dt class="font-bold">フリガナ：</dt>
                    <dd>{{ $user->last_name_kana }} {{ $user->first_name_kana }}</dd>
                </div>

                <div>
                    <dt class="font-bold">郵便番号：</dt>
                    <dd>{{ $user->postal_code }}</dd>
                </div>

                <div>
                    <dt class="font-bold">住所：</dt>
                    <dd>{{ $user->address }}</dd>
                </div>

                <div>
                    <dt class="font-bold">電話番号：</dt>
                    <dd>{{ $user->phone_number }}</dd>
                </div>

                <div>
                    <dt class="font-bold">メールアドレス：</dt>
                    <dd>{{ $user->email }}</dd>
                </div>

                <div>
                    <dt class="font-bold">会員ステータス：</dt>
                    <dd>
                        @if ($user->status)
                        <span class="text-green-600 font-semibold">有効</span>
                        @else
                        <span class="text-red-600 font-semibold">退会</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                    編集する
                </a>
                <a href="{{ route('admin.users.orders.index', $user->id) }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                    注文履歴一覧を見る
                </a>
            </div>
        </div>
    </div>
</x-app-layout>