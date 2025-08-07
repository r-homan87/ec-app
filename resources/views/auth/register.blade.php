<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- 姓 -->
        <div>
            <x-input-label for="last_name" :value="__('姓')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- 名 -->
        <div class="mt-4">
            <x-input-label for="first_name" :value="__('名')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- セイ -->
        <div class="mt-4">
            <x-input-label for="last_name_kana" :value="__('セイ')" />
            <x-text-input id="last_name_kana" class="block mt-1 w-full" type="text" name="last_name_kana" :value="old('last_name_kana')" required />
            <x-input-error :messages="$errors->get('last_name_kana')" class="mt-2" />
        </div>

        <!-- メイ -->
        <div class="mt-4">
            <x-input-label for="first_name_kana" :value="__('メイ')" />
            <x-text-input id="first_name_kana" class="block mt-1 w-full" type="text" name="first_name_kana" :value="old('first_name_kana')" required />
            <x-input-error :messages="$errors->get('first_name_kana')" class="mt-2" />
        </div>

        <!-- メールアドレス -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- 郵便番号 -->
        <div class="mt-4">
            <x-input-label for="postal_code" :value="__('郵便番号（ハイフンなし）')" />
            <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required />
            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
        </div>

        <!-- 住所 -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('住所')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- 電話番号 -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('電話番号（ハイフンなし）')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- パスワード -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- パスワード確認 -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('パスワード（確認）')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('すでに登録済みですか？') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('登録') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>