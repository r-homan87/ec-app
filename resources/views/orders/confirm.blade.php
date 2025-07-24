<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">注文内容の確認</h2>

        <h3 class="text-lg font-semibold">お届け先</h3>

        @php
        $shippingOption = $data['shipping_option'] ?? '';
        @endphp

        @if ($shippingOption === 'new')
        <p>{{ $data['new_recipient_name'] }}</p>
        <p>{{ $data['new_postal_code'] }}</p>
        <p>{{ $data['new_address'] }}</p>
        @elseif ($shippingOption === 'myself')
        <p>{{ $user->name }}</p>
        <p>{{ $user->postal_code }}</p>
        <p>{{ $user->address }}</p>
        @elseif ($shippingOption === 'registered')
        @php
        $selected = $shippingAddresses->firstWhere('id', $data['registered_address_id']);
        @endphp
        @if ($selected)
        <p>{{ $selected->recipient_name }}</p>
        <p>{{ $selected->postal_code }}</p>
        <p>{{ $selected->address }}</p>
        @endif
        @endif

        <h3 class="text-lg font-semibold mt-4">カート内容</h3>
        <ul>
            @foreach ($cartItems as $item)
            <li>{{ $item->product->name }} × {{ $item->quantity }}</li>
            @endforeach
        </ul>

        <div class="mt-4 flex space-x-4">
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                @foreach ($data as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    この内容で注文する
                </button>
            </form>

            <a href="{{ route('orders.create') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 flex items-center justify-center">
                修正する
            </a>
        </div>
    </div>
</x-app-layout>