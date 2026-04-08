<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            تعديل المستخدم: {{ $user->name }}
        </h2>
        <div>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                عودة للقائمة
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-xl p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">الاسم الكامل</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" required shadow-sm>
                    @error('name') <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-bold text-gray-700 mb-2">اسم المستخدم</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" required shadow-sm>
                    @error('username') <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني (اختياري)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" shadow-sm>
                    @error('email') <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-bold text-gray-700 mb-2">الدور</label>
                    <select name="role" id="role" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" shadow-sm required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>مستخدم</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>مسير</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدير</option>
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور (اتركها فارغة للإبقاء على الحالية)</label>
                    <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" shadow-sm>
                    @error('password') <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm p-3" shadow-sm>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary-light text-white font-bold rounded-lg shadow-md transition duration-150">
                    تحديث المستخدم
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
