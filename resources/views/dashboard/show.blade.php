<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-primary transition-colors ml-3 border border-gray-300 rounded p-1">
                <!-- RTL Arrow Right -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                الملف التفصيلي
            </h2>
        </div>
    </x-slot>

    <!-- Include Leaflet CSS for map display -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="max-w-7xl mx-auto py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Right Column - Profile Card -->
            <div class="md:col-span-1 border border-gray-100 bg-white rounded-xl shadow-sm p-6 flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-100 shadow-sm mb-4 bg-gray-50">
                    @if($person->photo)
                        <img src="{{ asset('storage/' . $person->photo) }}" alt="صورة الشخص" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($person->first_name . ' ' . $person->last_name) }}&background=1e40af&color=fff&size=200&font-size=0.3" alt="صورة الشخص" class="w-full h-full object-cover">
                    @endif
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ $person->first_name }} {{ $person->last_name }}</h3>
                <p class="text-sm font-medium text-gray-500 mt-1">المعرف: {{ $person->identifier ?? 'غير متوفر' }}</p>
                <span class="mt-3 px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded flex items-center">
                    <span class="w-2 h-2 rounded-full bg-red-600 ml-2"></span>
                    تحت المراقبة الإدارية
                </span>

                <div class="w-full mt-6 space-y-4 text-sm text-gray-700">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="font-bold text-gray-500">تاريخ الولادة</span>
                        <span>{{ $person->dob ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="font-bold text-gray-500">المهنة</span>
                        <span>{{ $person->job ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="font-bold text-gray-500">مستوى الدراسة</span>
                        <span>{{ $person->level ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Left Column - Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Info Section 1 -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-4 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        معلومات الاتصال والإقامة
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">العنوان الحالي</span>
                            <p class="text-gray-800">{{ $person->address ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">أرقام الهاتف</span>
                            <p class="text-gray-800" dir="ltr">{{ $person->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2 mt-2">
                            <span class="block text-gray-400 font-bold mb-1">وسائل التواصل الاجتماعي</span>
                            <p class="text-gray-800" dir="ltr">{{ $person->social ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Geolocation Section - NEW -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-lg font-bold text-primary flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            الموقع الجغرافي
                        </h3>
                        @if($person->latitude && $person->longitude)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $person->latitude }},{{ $person->longitude }}" target="_blank" class="px-3 py-1 bg-green-100 text-green-700 hover:bg-green-200 rounded text-xs font-bold transition flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                فتح في Google Maps
                            </a>
                        @endif
                    </div>
                    
                    @if($person->latitude && $person->longitude)
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-50 border p-2 rounded">
                                <span class="block text-gray-500 text-xs">Latitude</span>
                                <span class="font-bold text-gray-800" dir="ltr">{{ $person->latitude }}</span>
                            </div>
                            <div class="bg-gray-50 border p-2 rounded">
                                <span class="block text-gray-500 text-xs">Longitude</span>
                                <span class="font-bold text-gray-800" dir="ltr">{{ $person->longitude }}</span>
                            </div>
                        </div>
                        <div id="map" class="w-full h-80 rounded-xl border border-gray-300 shadow-inner z-0"></div>
                        
                        <!-- Leaflet JS logic for Show Page -->
                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var lat = {{ $person->latitude }};
                                var lng = {{ $person->longitude }};
                                
                                var map = L.map('map').setView([lat, lng], 14);
                                
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 19,
                                    attribution: '© OpenStreetMap'
                                }).addTo(map);
                                
                                L.marker([lat, lng]).addTo(map)
                                    .bindPopup(`<b>{{ $person->first_name }} {{ $person->last_name }}</b><br>الموقع المسجل`)
                                    .openPopup();
                            });
                        </script>
                    @else
                        <div class="py-10 text-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p>لا يوجد موقع جغرافي مسجل لهذا الشخص.</p>
                        </div>
                    @endif
                </div>

                <!-- Info Section 2 -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-4 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        الخلفية والتكوين
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">النشأة</span>
                            <p class="text-gray-800 bg-gray-50 rounded p-3">{{ $person->upbringing ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">الدراسة والتكوين</span>
                            <p class="text-gray-800 bg-gray-50 rounded p-3">{{ $person->education ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <span class="block text-gray-400 font-bold mb-1">التاريخ المهني</span>
                            <p class="text-gray-800 bg-gray-50 rounded p-3">{{ $person->work_history ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Section 3 -->
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 text-sm">
                    <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-3 mb-4 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        النشاط والسفر والمحيط الاجتماعي
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">المجال الديني والدعوي</span>
                            <p class="text-gray-800 border-r-2 border-primary pr-3 py-1 bg-blue-50/20">{{ $person->religion ?? '-' }} <br> {{ $person->dawah ?? '' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">الكتب الحاضرة في محيطه</span>
                            <p class="text-gray-800 border-r-2 border-primary pr-3 py-1 bg-blue-50/20">{{ $person->books ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">السفر</span>
                            <p class="text-gray-800 border-r-2 border-primary pr-3 py-1 bg-blue-50/20">{{ $person->travels ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="block text-gray-400 font-bold mb-1">الأصدقاء والمقربين</span>
                            <p class="text-gray-800 border-r-2 border-primary pr-3 py-1 bg-blue-50/20">{{ $person->friends ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Alert/Notes Section -->
                @if($person->notes)
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm p-6 text-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-1.5 h-full bg-yellow-400"></div>
                    <h3 class="text-lg font-bold text-yellow-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        الملاحظات الإدارية والأمنية
                    </h3>
                    <p class="text-yellow-900 leading-relaxed">
                        {{ $person->notes }}
                    </p>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
