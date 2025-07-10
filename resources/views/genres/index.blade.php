<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ジャンル一覧・追加
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white shadow rounded p-6">
                <form action="{{ route('genres.store') }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <input type="text" name="name" placeholder="ジャンル名" class="border rounded px-4 py-2 w-full" required>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            追加
                        </button>
                    </div>
                    @error('name')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            <div class="bg-white shadow rounded p-6">
                @if ($genres->isEmpty())
                <p class="text-gray-600">ジャンルが登録されていません。</p>
                @else
                <table class="w-full table-auto border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">ジャンル名</th>
                            <th class="border px-4 py-2 text-left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $genre)
                        <tr>
                            <td class="border px-4 py-2">{{ $genre->name }}</td>
                            <td class="border px-4 py-2 flex space-x-4">
                                <a href="{{ route('genres.edit', $genre) }}" class="text-blue-600 hover:underline">編集</a>

                                <form action="{{ route('genres.destroy', $genre) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>