<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ジャンル編集
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white shadow p-6 rounded">
            @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('genres.update', $genre) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">ジャンル名</label>
                    <input type="text" name="name" value="{{ old('name', $genre->name) }}" class="form-input rounded-md shadow-sm mt-1 block w-full border-gray-300" required>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('genres.index') }}" class="text-gray-600 hover:underline">戻る</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        更新する
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>