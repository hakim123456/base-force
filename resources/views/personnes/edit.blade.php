<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('personnes.index') }}" class="text-gray-500 hover:text-primary transition-colors ml-3 border border-gray-300 rounded p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                تعديل بيانات الشخص: {{ $personne->first_name }} {{ $personne->last_name }}
            </h2>
        </div>
    </x-slot>

    <!-- Include Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form action="{{ route('personnes.update', $personne->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" dir="rtl">
                    <ul class="list-disc mr-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" dir="rtl">
                <!-- Profile & Location Column -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Photo Section -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 w-full border-b pb-2">الصورة الشخصية</h3>
                        <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-gray-50 shadow-sm mb-4 bg-gray-50 relative group">
                            @if($personne->photo)
                                <img id="photo-preview" src="{{ asset('storage/' . $personne->photo) }}" alt="صورة الشخص" class="w-full h-full object-cover">
                            @else
                                <img id="photo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($personne->first_name . ' ' . $personne->last_name) }}&background=1e40af&color=fff&size=200" alt="صورة الشخص" class="w-full h-full object-cover">
                            @endif
                            <label for="photo" class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </label>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <p class="text-xs text-gray-500 text-center">انقر على الصورة لتغييرها</p>
                    </div>

                    <!-- Geolocation Section -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <svg class="w-5 h-5 ml-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            الموقع الجغرافي
                        </h3>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">خط العرض (Lat)</label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $personne->latitude) }}" readonly
                                    class="w-full bg-gray-50 border-gray-200 rounded text-sm font-mono text-center">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">خط الطول (Lng)</label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $personne->longitude) }}" readonly
                                    class="w-full bg-gray-50 border-gray-200 rounded text-sm font-mono text-center">
                            </div>
                        </div>
                        <div id="map" class="w-full h-64 rounded-lg border border-gray-200 shadow-inner z-0"></div>
                        <p class="text-xs text-gray-500 mt-2 text-center">انقر على الخريطة لتغيير الموقع</p>
                    </div>
                </div>

                <!-- Main Details Section -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Essential Info -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            المعلومات الأساسية
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="identifier" class="block text-sm font-bold text-gray-700">رقم التعريف / بطاقة التعريف</label>
                                <input type="text" name="identifier" id="identifier" value="{{ old('identifier', $personne->identifier) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="first_name" class="block text-sm font-bold text-gray-700">الاسم</label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $personne->first_name) }}" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="father_name" class="block text-sm font-bold text-gray-700">اسم الأب</label>
                                <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $personne->father_name) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="grandfather_name" class="block text-sm font-bold text-gray-700">اسم الجد</label>
                                <input type="text" name="grandfather_name" id="grandfather_name" value="{{ old('grandfather_name', $personne->grandfather_name) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-bold text-gray-700">اللقب</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $personne->last_name) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="dob" class="block text-sm font-bold text-gray-700">تاريخ الولادة</label>
                                <input type="text" name="dob" id="dob" value="{{ old('dob', $personne->dob) }}" placeholder="DD/MM/YYYY"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Profession -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            الاتصال والوسط المهني
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700">أرقام الهاتف</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $personne->phone) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm text-left font-mono" dir="ltr">
                            </div>
                            <div>
                                <label for="job" class="block text-sm font-bold text-gray-700">المهنة الحالية</label>
                                <input type="text" name="job" id="job" value="{{ old('job', $personne->job) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-bold text-gray-700">العنوان الحالي بالتفصيل</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $personne->address) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="social" class="block text-sm font-bold text-gray-700">حسابات التواصل الاجتماعي</label>
                                <textarea name="social" id="social" rows="2"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm text-left font-mono" dir="ltr">{{ old('social', $personne->social) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Background & Education -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            الخلفية والتعليم
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="level" class="block text-sm font-bold text-gray-700">المستوى الدراسي</label>
                                <input type="text" name="level" id="level" value="{{ old('level', $personne->level) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="education" class="block text-sm font-bold text-gray-700">التكوين والشهادات</label>
                                    <textarea name="education" id="education" rows="2"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('education', $personne->education) }}</textarea>
                                </div>
                                <div>
                                    <label for="upbringing" class="block text-sm font-bold text-gray-700">النشأة والبيئة الاجتماعية</label>
                                    <textarea name="upbringing" id="upbringing" rows="2"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('upbringing', $personne->upbringing) }}</textarea>
                                </div>
                            </div>
                            <div>
                                <label for="work_history" class="block text-sm font-bold text-gray-700">تاريخ العمل والخبرات السابقة</label>
                                <textarea name="work_history" id="work_history" rows="3"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('work_history', $personne->work_history) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Activities & Environment -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2 2 2 0 012 2v.654M15 21a9 9 0 11-9-9"></path></svg>
                            النشاطات والمحيط السلوكي
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="religion" class="block text-sm font-bold text-gray-700">الالتزام الديني</label>
                                <input type="text" name="religion" id="religion" value="{{ old('religion', $personne->religion) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="dawah" class="block text-sm font-bold text-gray-700">النشاط الدعوي أو الفكري</label>
                                <input type="text" name="dawah" id="dawah" value="{{ old('dawah', $personne->dawah) }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="books" class="block text-sm font-bold text-gray-700">الكتب والميولات الفكرية</label>
                                <textarea name="books" id="books" rows="2"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('books', $personne->books) }}</textarea>
                            </div>
                            <div>
                                <label for="travels" class="block text-sm font-bold text-gray-700">السفر والتحركات</label>
                                <textarea name="travels" id="travels" rows="2"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('travels', $personne->travels) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="friends" class="block text-sm font-bold text-gray-700">الأصدقاء والمحيط القريب</label>
                                <textarea name="friends" id="friends" rows="2"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('friends', $personne->friends) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Administrative Notes -->
                    <div class="bg-yellow-50 p-6 rounded-xl shadow-sm border border-yellow-100 border-r-4 border-r-yellow-400">
                        <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            ملاحظات إدارية وأمنية هامة
                        </h3>
                        <textarea name="notes" id="notes" rows="4"
                            class="mt-1 block w-full rounded-lg border-yellow-200 bg-white shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm text-yellow-900">{{ old('notes', $personne->notes) }}</textarea>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 space-x-reverse pt-6">
                        <a href="{{ route('personnes.index') }}" 
                            class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                            إلغاء التعديل
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-10 py-3 bg-primary hover:bg-primary-dark border border-transparent rounded-xl font-bold text-white shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            حفظ التغييرات
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Image preview logic
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Map logic
        document.addEventListener('DOMContentLoaded', function() {
            var initialLat = {{ $personne->latitude ?? 35.1723 }}; // Default to Kasserine if null
            var initialLng = {{ $personne->longitude ?? 8.8324 }};
            
            var map = L.map('map').setView([initialLat, initialLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

            // Handle map click
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                marker.setLatLng([lat, lng]);
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
            });

            // Handle marker drag
            marker.on('dragend', function(e) {
                var lat = marker.getLatLng().lat;
                var lng = marker.getLatLng().lng;
                
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
            });
        });
    </script>

    <style>
        .text-primary { color: #1e40af; }
        .bg-primary { background-color: #1e40af; }
        .bg-primary-dark { background-color: #1a368e; }
        .border-primary { border-color: #1e40af; }
        .focus-ring-primary { --tw-ring-color: #1e40af; }
    </style>
</x-app-layout>
