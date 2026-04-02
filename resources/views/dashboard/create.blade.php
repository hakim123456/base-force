<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-primary transition-colors ml-3 border border-gray-300 rounded p-1">
                <!-- RTL Arrow Right -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                إضافة عنصر جديد
            </h2>
        </div>
    </x-slot>

    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6">
        <form action="{{ route('dashboard.store') }}" method="POST">
            @csrf
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Right Column (Personal Details) -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2">المعلومات الشخصية</h3>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المعرف (الهوية)</label>
                        <input type="text" name="identifier" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل المعرف">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الاسم</label>
                        <input type="text" name="first_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل الاسم">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اللقب</label>
                        <input type="text" name="last_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل اللقب">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اسم الأب</label>
                        <input type="text" name="father_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل اسم الأب">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اسم الجد</label>
                        <input type="text" name="grandfather_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل اسم الجد">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">تاريخ الولادة</label>
                        <input type="date" name="dob" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المهنة</label>
                        <input type="text" name="job" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل المهنة">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">العنوان الحالي</label>
                        <input type="text" name="address" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل العنوان الحالي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">أرقام الهاتف</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أرقام الهاتف (مفصولة بفاصلة)">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">وسائل التواصل الاجتماعي</label>
                        <textarea name="social" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="روابط أو حسابات التواصل"></textarea>
                    </div>
                </div>

                <!-- Left Column (Additional Details) -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2">التفاصيل الإضافية والنشاطات</h3>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">النشأة</label>
                        <input type="text" name="upbringing" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تاريخ وبيئة النشأة">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الدراسة</label>
                        <input type="text" name="education" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="المسار الدراسي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المستوى الحالي</label>
                        <input type="text" name="level" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="المستوى الأكاديمي أو التعليمي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">مجال العمل السابق والحالي</label>
                        <textarea name="work_history" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تفاصيل الأعمال السابقة والحالية"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المجال الديني</label>
                        <input type="text" name="religion" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="التوجه أو النشاط الديني">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المشاركة في الأعمال الدعوية</label>
                        <input type="text" name="dawah" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تفاصيل المشاركات">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الكتب</label>
                        <input type="text" name="books" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="الكتب المميزة أو التي يقرؤها">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">السفر</label>
                        <input type="text" name="travels" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تاريخ الوجهات والسفر">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الأصدقاء</label>
                        <input type="text" name="friends" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="شبكة المعارف والأصدقاء المقربين">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الملاحظات</label>
                        <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أي ملاحظات إضافية ضرورية..."></textarea>
                    </div>
                </div>
                
                <!-- Bottom Section (Geolocation) -->
                <div class="md:col-span-2 space-y-5 border-t pt-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        الموقع الجغرافي (Géolocalisation)
                    </h3>
                    <p class="text-sm text-gray-500">انقر على الخريطة لتحديد الموقع أو استخدم زر تحديد الموقع التلقائي.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">خط العرض (Latitude)</label>
                            <input type="text" id="latitude" name="latitude" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm bg-gray-50" placeholder="مثال: 36.8065" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">خط الطول (Longitude)</label>
                            <input type="text" id="longitude" name="longitude" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm bg-gray-50" placeholder="مثال: 10.1815" readonly>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" onclick="getCurrentLocation()" class="mb-3 px-4 py-2 bg-blue-100 text-blue-800 font-bold text-sm rounded-lg hover:bg-blue-200 transition flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            تحديد موقعي الحالي
                        </button>
                        <div id="map" class="w-full h-80 rounded-xl border border-gray-300 shadow-inner z-0"></div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end rounded-b-xl">
                <a href="{{ route('dashboard.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 ml-3 transition">
                    إلغاء
                </a>
                <button type="submit" class="px-6 py-2 bg-primary border border-transparent rounded-lg shadow-sm text-sm font-bold text-white hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    إضافة عنصر
                </button>
            </div>
        </form>
    </div>

    <!-- Leaflet JS logic -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialiser la carte sur Tunis par défaut
        var map = L.map('map').setView([36.8065, 10.1815], 7); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        // Événement clic sur la carte
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(7);
            var lng = e.latlng.lng.toFixed(7);
            
            // Mise à jour des inputs
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            // Placement du marker
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });

        // Géolocalisation automatique
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude.toFixed(7);
                    var lng = position.coords.longitude.toFixed(7);
                    
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    
                    var newLatLng = new L.LatLng(lat, lng);
                    map.setView(newLatLng, 13);
                    
                    if (marker) {
                        marker.setLatLng(newLatLng);
                    } else {
                        marker = L.marker(newLatLng).addTo(map);
                    }
                }, function(error) {
                    alert("Erreur de géolocalisation. Veuillez autoriser l'accès ou cliquer sur la carte.");
                });
            } else {
                alert("La géolocalisation n'est pas supportée par votre navigateur.");
            }
        }
    </script>
</x-app-layout>
