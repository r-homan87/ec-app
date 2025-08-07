<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            トップページ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">新着商品</h3>

                @if ($newProducts->isEmpty())
                <p>新着商品はありません。</p>
                @else
                <ul class="space-y-2">
                    @foreach ($newProducts as $product)
                    <li>
                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:underline">
                            {{ $product->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>