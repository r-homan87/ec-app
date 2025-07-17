<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            新規商品登録
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            @if ($errors->any())
            <div class="mb-4 alert alert-danger">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">商品画像</label>
                    <input type="file" name="image" class="form-input rounded-md shadow-sm mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">商品名</label>
                    <input type="text" name="name" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">商品説明</label>
                    <textarea name="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">ジャンル</label>
                    <select name="genre_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                        <option value="">選択してください</option>
                        @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">価格 (円)</label>
                    <input type="number" name="price" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">在庫数</label>
                    <input type="number" name="stock" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">販売ステータス</label>
                    <select name="status" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="available">販売中</option>
                        <option value="unavailable">販売停止中</option>
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-success bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        登録
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>