<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            商品詳細
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow p-6 rounded">
            <h3 class="text-2xl font-bold mb-4">{{ $product->name }}</h3>

            <div class="mb-4">
                <strong>価格：</strong> ¥{{ number_format($product->price) }}
            </div>

            <div class="mb-4">
                <strong>在庫数：</strong> {{ $product->stock }}
            </div>

            <div class="mb-4">
                <strong>説明：</strong><br>
                <p>{{ $product->description }}</p>
            </div>

            @if ($product->image_path)
            <div class="mb-4">
                <strong>画像：</strong><br>
                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-64 h-auto rounded">
            </div>
            @endif

            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="mb-3">
                    <label for="quantity">数量：</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 80px;">
                </div>

                <button type="submit" class="btn btn-primary">カートに追加</button>
            </form>

            <div class="mt-6">
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">編集</a>
                @endif
                <a href="{{ route('products.index') }}" class="btn btn-secondary">一覧に戻る</a>
            </div>
        </div>
    </div>
</x-app-layout>