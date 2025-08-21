<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            トップページ
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="mb-1">ようこそ、ながのCAKEへ!</p>
                <p class="mb-1">このサイトは、ケーキ販売のECサイトになります。</p>
                <p class="mb-1">会員でない方も商品の閲覧はできますが、</p>
                <p>購入には会員登録が必要になります。</p>
            </div>

            {{-- エラーメッセージ --}}
            @if (session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
                <table class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫</th>
                            <th>画像</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="py-2 px-4"><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                            <td class="py-2 px-4">¥{{ number_format($product->price) }}</td>
                            <td class="py-2 px-4">{{ $product->stock }}</td>
                            <td class="py-2 px-4">
                                @if ($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                <form action="{{ route('cart.store') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 border rounded px-2 py-1">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                        カートに追加
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 全ての商品を見るボタン --}}
                <div class="mt-4 text-right">
                    <a href="{{ route('products.index') }}" class="text-blue-600 font-semibold hover:underline">
                        全ての商品を見る &gt;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>