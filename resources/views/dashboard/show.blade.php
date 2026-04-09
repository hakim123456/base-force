<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard.index') }}"
                class="text-gray-500 hover:text-primary transition-colors ml-3 border border-gray-300 rounded p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                الملف التفصيلي: {{ $person->first_name }} {{ $person->father_name }} {{ $person->last_name }}
            </h2>
        </div>
        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
            <a href="{{ route('dashboard.edit', $person->id) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md font-bold text-sm text-white shadow-sm transition-colors">
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                تعديل البيانات
            </a>
        @endif
    </x-slot>

    <!-- Include Leaflet CSS for map display -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Include Quill Snow Theme for consistent formatting -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" dir="rtl">

            <!-- Right Column - Profile & Map (Matching Edit Disposition) -->
            <div class="md:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="border border-gray-100 bg-white rounded-xl shadow-sm p-6 flex flex-col items-center">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-100 shadow-sm mb-4 bg-gray-50">
                        @if($person->photo)
                            <img src="{{ asset('storage/' . $person->photo) }}" alt="صورة الشخص"
                                class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($person->first_name . ' ' . $person->last_name) }}&background=1e40af&color=fff&size=200&font-size=0.3"
                                alt="صورة الشخص" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 text-center">
                        {{ $person->first_name }} {{ $person->father_name }} {{ $person->last_name }}
                    </h3>
                    <p class="text-sm font-medium text-gray-500 mt-1">المعرف: {{ $person->identifier ?? 'غير متوفر' }}</p>
                    <span class="mt-3 px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded flex items-center">
                        <span class="w-2 h-2 rounded-full bg-red-600 ml-2"></span>
                        تحت المراقبة الإدارية
                    </span>
                </div>

                <!-- Geolocation Section (Moved to Right Column like Edit) -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-lg font-bold text-primary flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            الموقع الجغرافي
                        </h3>
                    </div>

                    @if($person->latitude && $person->longitude)
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-gray-50 border border-gray-200 p-2 rounded text-center">
                                <span class="block text-gray-500 text-[10px] font-bold">Latitude</span>
                                <span class="text-sm font-mono text-gray-800">{{ $person->latitude }}</span>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 p-2 rounded text-center">
                                <span class="block text-gray-500 text-[10px] font-bold">Longitude</span>
                                <span class="text-sm font-mono text-gray-800">{{ $person->longitude }}</span>
                            </div>
                        </div>
                        <div id="map" class="w-full h-64 rounded-lg border border-gray-200 shadow-inner z-0"></div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $person->latitude }},{{ $person->longitude }}"
                            target="_blank"
                            class="mt-3 w-full py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-bold transition flex items-center justify-center">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                </path>
                            </svg>
                            فتح في خرائط جوجل
                        </a>

                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var lat = {{ $person->latitude }};
                                var lng = {{ $person->longitude }};
                                var map = L.map('map').setView([lat, lng], 13);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OpenStreetMap'
                                }).addTo(map);
                                L.marker([lat, lng]).addTo(map);
                            });
                        </script>
                    @else
                        <div class="py-8 text-center text-gray-400 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            <p class="text-xs">الموقع الجغرافي غير مسجل</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Left Column - Detailed Information (Matching Edit Disposition) -->
            <div class="md:col-span-2 space-y-6">
                <!-- Essential Information Card -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-6 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        المعلومات الأساسية
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الاسم واللقب</span>
                            <p class="text-gray-800 font-bold text-base">{{ $person->first_name }} {{ $person->last_name }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">اسم الأب والجد</span>
                            <p class="text-gray-800 font-medium">{{ $person->father_name ?? '-' }} {{ $person->grandfather_name ?? '' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">اسم الأم ولقبها</span>
                            <p class="text-gray-800 font-medium">{{ $person->mother_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الجنس</span>
                            <p class="text-gray-800 font-medium">{{ $person->gender ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الحالة الاجتماعية</span>
                            <p class="text-gray-800 font-medium">{{ $person->marital_status ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">اسم ولقب الزوج/الزوجة</span>
                            <p class="text-gray-800 font-medium">{{ $person->spouse_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">تاريخ الولادة</span>
                            <p class="text-gray-800 font-medium">{{ $person->dob ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">المهنة</span>
                            <p class="text-gray-800 font-medium">{{ $person->job ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">المستوى الدراسي</span>
                            <p class="text-gray-800 font-medium">{{ $person->level ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الالتزام الديني</span>
                            <p class="text-gray-800 font-medium">{{ $person->religion ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact & Location Card -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-6 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        معلومات الاتصال والإقامة
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">البلد</span>
                            <p class="text-gray-800 font-medium">{{ $person->country ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الولاية</span>
                            <p class="text-gray-800 font-medium">{{ $person->governorate ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">المعتمدية</span>
                            <p class="text-gray-800 font-medium">{{ $person->delegation ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">العمادة</span>
                            <p class="text-gray-800 font-medium">{{ $person->sector ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">العنوان بالتفصيل</span>
                            <p class="text-gray-800">{{ $person->address ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">أرقام الهاتف</span>
                            <p class="text-gray-800 font-mono" dir="ltr">{{ $person->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <span class="block text-gray-400 font-bold mb-1 text-xs">حسابات التواصل الاجتماعي</span>
                            <p class="text-gray-800 font-mono" dir="ltr">{{ $person->social ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Background & History Card -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-6 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        الخلفية والتكوين والنشأة
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">النشأة والبيئة الاجتماعية</span>
                            <div class="text-gray-800 bg-gray-50 rounded-lg p-3 border border-gray-100 whitespace-pre-wrap leading-relaxed">
                                {{ $person->upbringing ?? 'لا توجد بيانات مسجلة' }}
                            </div>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1 text-xs">الدراسة والشهادات والتكوين</span>
                            <div class="text-gray-800 bg-gray-50 rounded-lg p-3 border border-gray-100 whitespace-pre-wrap leading-relaxed">
                                {{ $person->education ?? 'لا توجد بيانات مسجلة' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Administrative Notes Card -->
                @if($person->notes)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm p-6 text-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-1.5 h-full bg-yellow-400"></div>
                        <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            الملاحظات الإدارية والأمنية
                        </h3>
                        <div class="text-yellow-900 ql-editor" style="padding: 0; min-height: auto;">
                            {!! $person->notes !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .ql-editor {
            direction: rtl;
            text-align: right;
            font-family: inherit;
        }
        .ql-editor p {
            margin-bottom: 0.5rem;
        }
    </style>
</x-app-layout>