<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">商品編集</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">

            @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($product->image_path)
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">現在の画像</label>
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-32 h-auto">
                </div>
                @endif

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">新しい画像を選択（任意）</label>
                    <input type="file" name="image" class="form-input rounded-md shadow-sm mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">商品説明</label>
                    <textarea name="description" class="w-full rounded border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">価格</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">在庫数</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ジャンル</label>
                    <select name="genre_id" class="w-full rounded border-gray-300 shadow-sm">
                        <option value="">選択してください</option>
                        @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ $product->genre_id == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">販売ステータス</label>
                    <select name="status" class="w-full rounded border-gray-300 shadow-sm">
                        <option value="available" {{ $product->status == 'available' ? 'selected' : '' }}>販売中</option>
                        <option value="unavailable" {{ $product->status == 'unavailable' ? 'selected' : '' }}>販売停止中</option>
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        更新する
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>