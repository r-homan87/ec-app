<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            会員一覧
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            <table class="w-full table-auto border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">会員ID</th>
                        <th class="border px-4 py-2 text-left">氏名</th>
                        <th class="border px-4 py-2 text-left">メールアドレス</th>
                        <th class="border px-4 py-2 text-left">ステータス</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline">
                                {{ $user->last_name }}{{ $user->first_name }}
                            </a>
                        </td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            @if ($user->email_verified_at)
                            <span class="text-green-600">有効</span>
                            @else
                            <span class="text-red-600">未確認</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>