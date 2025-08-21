<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">会員情報編集</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <!-- 姓 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">姓</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    @error('last_name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 名 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">名</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    @error('first_name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- セイ -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">セイ</label>
                    <input type="text" name="last_name_kana" value="{{ old('last_name_kana', $user->last_name_kana) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    @error('last_name_kana')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- メイ -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">メイ</label>
                    <input type="text" name="first_name_kana" value="{{ old('first_name_kana', $user->first_name_kana) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    @error('first_name_kana')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 郵便番号 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">郵便番号</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                    @error('postal_code')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 住所 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">住所</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                    @error('address')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 電話番号 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">電話番号</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full">
                    @error('phone_number')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- メールアドレス -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">メールアドレス</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ステータス -->
                <div class="mb-4">
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>有効</option>
                        <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>退会</option>
                    </select>
                    @error('status')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        更新する
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>