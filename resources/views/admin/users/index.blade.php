<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-blue-800 leading-tight">
                {{ __('Quản lý người dùng') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">ID</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Tên</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Email</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Vai trò</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Ngày tạo</th>
                                    <th class="text-left py-3 px-4 text-gray-700 font-semibold">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="py-4 px-4 text-gray-900">{{ $user->id }}</td>
                                    <td class="py-4 px-4 text-gray-900">{{ $user->name }}</td>
                                    <td class="py-4 px-4 text-gray-900">{{ $user->email }}</td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900 text-xs bg-blue-100 px-2 py-1 rounded">Xem</a>
                                            <a href="{{ route('admin.users.watchlist', $user) }}" class="text-purple-600 hover:text-purple-900 text-xs bg-purple-100 px-2 py-1 rounded">Watchlist</a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 text-xs bg-indigo-100 px-2 py-1 rounded">Sửa</a>
                                            @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs bg-red-100 px-2 py-1 rounded">Xóa</button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
