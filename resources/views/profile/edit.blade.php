<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">会員情報編集</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
            @if ($errors->any())
            <div class="mb-6 text-red-600">
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700">姓</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">名</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">セイ</label>
                    <input type="text" name="last_name_kana" value="{{ old('last_name_kana', $user->last_name_kana) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">メイ</label>
                    <input type="text" name="first_name_kana" value="{{ old('first_name_kana', $user->first_name_kana) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">郵便番号</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">住所</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">電話番号</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">メールアドレス</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-input mt-1 block w-full rounded-md shadow-sm border-gray-300" required>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded shadow">
                        更新する
                    </button>
                </div>
            </form>

            <hr class="my-8">

            <form method="POST" action="{{ route('profile.destroy') }}"
                onsubmit="return confirm('本当に退会しますか？この操作は取り消せません。');">
                @csrf
                @method('DELETE')

                <x-danger-button>
                    退会する
                </x-danger-button>
            </form>
        </div>
    </div>
</x-app-layout>