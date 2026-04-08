<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            إدارة المستخدمين
        </h2>
        <div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-light border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة مستخدم جديد
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-right">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-bold text-sm">
                    <tr>
                        <th class="px-6 py-4">الاسم</th>
                        <th class="px-6 py-4">اسم المستخدم</th>
                        <th class="px-6 py-4">البريد الإلكتروني</th>
                        <th class="px-6 py-4">الدور</th>
                        <th class="px-6 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->username }}</td>
                        <td class="px-6 py-4">{{ $user->email ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($user->isAdmin())
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold">مدير</span>
                            @elseif($user->isManager())
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">مسير</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold">مستخدم</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center space-x-3 space-x-reverse">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 hover:bg-blue-100 rounded p-2" title="تعديل">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 rounded p-2" title="حذف">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
