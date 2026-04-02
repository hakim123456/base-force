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
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-2xl border border-gray-100">
        <!-- Logo / Title -->
        <div class="flex flex-col items-center justify-center mb-8">
            <div class="h-16 w-16 bg-primary text-white flex items-center justify-center rounded-full mb-4 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">تطبيقة الخزائن الرقمية</h1>
            <p class="text-gray-500 mt-2 text-sm">مرحباً بك، يرجى تسجيل الدخول</p>
        </div>

        {{ $slot }}
    </div>

</body>
</html>
