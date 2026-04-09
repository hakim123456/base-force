<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'تطبيقة الخزائن الرقمية') }}</title>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Tajawal', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1e40af',
                        'primary-light': '#2563eb',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js (Optional for dynamic tabs/dropdowns) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800">

    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <header class="bg-primary text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold tracking-tight">تطبيقة الخزائن الرقمية</span>
                    </div>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <span class="text-sm font-medium">مرحباً، {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-sm font-bold transition">خروج</a>
                    </div>
                </div>

                <!-- Horizontal Tabs Navbar -->
                <div
                    class="flex overflow-x-auto py-2 space-x-2 space-x-reverse hide-scrollbar border-t border-primary-light/50">
                    <a href="{{ route('dashboard.index') }}"
                        class="px-4 py-2 rounded-t-lg {{ request()->routeIs('dashboard.*') ? 'bg-white text-primary' : 'hover:bg-primary-light' }} font-bold text-sm whitespace-nowrap">
                        قائمة
                        العناصر المتطرفة</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 rounded-t-lg {{ request()->routeIs('admin.users.*') ? 'bg-white text-primary' : 'hover:bg-primary-light' }} font-bold text-sm whitespace-nowrap">
                            إدارة المستخدمين
                        </a>
                    @endif
                    <a href="#"
                        class="px-4 py-2 hover:bg-primary-light rounded-t-lg transition text-sm font-medium whitespace-nowrap">قائمة
                        المسرحين</a>
                    <a href="#"
                        class="px-4 py-2 hover:bg-primary-light rounded-t-lg transition text-sm font-medium whitespace-nowrap">قائمة
                        الأشخاص المشبوهين بالدعم</a>
                    <a href="#"
                        class="px-4 py-2 hover:bg-primary-light rounded-t-lg transition text-sm font-medium whitespace-nowrap">قائمة
                        المتعاملين مع العناصر الإرهابية</a>
                    <a href="#"
                        class="px-4 py-2 hover:bg-primary-light rounded-t-lg transition text-sm font-medium whitespace-nowrap">قائمة
                        المراقبة الإدارية</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header section for title / actions -->
            @isset($header)
                <div class="mb-6 pb-4 border-b border-gray-200 flex justify-between items-center">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            {{ $slot }}
        </main>
    </div>

    <!-- Notification Toast (Example) -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg flex items-center space-x-3 space-x-reverse z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
</body>

</html>