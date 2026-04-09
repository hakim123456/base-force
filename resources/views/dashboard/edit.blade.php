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
                تعديل بيانات الشخص: {{ $person->first_name }} {{ $person->last_name }}
            </h2>
        </div>
    </x-slot>

    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Include Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form id="edit-person-form" action="{{ route('dashboard.update', $person->id) }}" method="POST" enctype="multipart/form-data">
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
                <!-- Right Column (Photo & Map) -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Photo Section -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 w-full border-b pb-2">الصورة الشخصية</h3>
                        <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-gray-50 shadow-sm mb-4 bg-gray-50 relative group">
                            @if($person->photo)
                                <img id="photo-preview" src="{{ asset('storage/' . $person->photo) }}" alt="صورة الشخص" class="w-full h-full object-cover">
                            @else
                                <img id="photo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($person->first_name . ' ' . $person->last_name) }}&background=1e40af&color=fff&size=200" alt="صورة الشخص" class="w-full h-full object-cover">
                            @endif
                            <label for="photo" class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </label>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <p class="text-xs text-gray-500 text-center">انقر على الصورة لتغييرها</p>
                    </div>

                    <!-- Geolocation Section -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <svg class="w-5 h-5 ml-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            الموقع الجغرافي
                        </h3>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">خط العرض</label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $person->latitude) }}" readonly class="w-full bg-gray-50 border-gray-200 rounded text-sm font-mono text-center">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">خط الطول</label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $person->longitude) }}" readonly class="w-full bg-gray-50 border-gray-200 rounded text-sm font-mono text-center">
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
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            المعلومات الأساسية
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="identifier" class="block text-sm font-bold text-gray-700">رقم التعريف / بطاقة التعريف</label>
                                <input type="text" name="identifier" id="identifier" value="{{ old('identifier', $person->identifier) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="first_name" class="block text-sm font-bold text-gray-700">الاسم <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $person->first_name) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="father_name" class="block text-sm font-bold text-gray-700">اسم الأب</label>
                                <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $person->father_name) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="grandfather_name" class="block text-sm font-bold text-gray-700">اسم الجد</label>
                                <input type="text" name="grandfather_name" id="grandfather_name" value="{{ old('grandfather_name', $person->grandfather_name) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-bold text-gray-700">اللقب</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $person->last_name) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            <div>
                                <label for="dob" class="block text-sm font-bold text-gray-700">تاريخ الولادة</label>
                                <input type="date" name="dob" id="dob" value="{{ old('dob', $person->dob) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Location & Contact -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            العنوان والاتصال
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700">رقم الهاتف</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $person->phone) }}" dir="ltr" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm text-left font-mono">
                            </div>
                            <div>
                                <label for="job" class="block text-sm font-bold text-gray-700">المهنة</label>
                                <input type="text" name="job" id="job" value="{{ old('job', $person->job) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                            
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">البلد (Pays)</label>
                                    <select name="country" id="country" onchange="handleCountryChange()" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                        <option value="">-- اختر البلد --</option>
                                        <option value="تونس" {{ old('country', $person->country) == 'تونس' ? 'selected' : '' }}>تونس (Tunisie)</option>
                                        <option value="أخرى" {{ old('country', $person->country) == 'أخرى' ? 'selected' : '' }}>بلد آخر (Autre)</option>
                                    </select>
                                </div>

                                <div id="tunisia-regions" class="grid grid-cols-1 md:grid-cols-3 gap-4 md:col-span-2">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">الولاية (Gouvernorat)</label>
                                        <select name="governorate" id="governorate" onchange="handleGovernorateChange()" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                            <option value="">-- اختر الولاية --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">المعتمدية (Délégation)</label>
                                        <select name="delegation" id="delegation" onchange="handleDelegationChange()" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                            <option value="">-- اختر المعتمدية --</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">العمادة (Secteur/Imada)</label>
                                        <select name="sector" id="sector" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                            <option value="">-- اختر العمادة --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-bold text-gray-700">العنوان الحالي بالتفصيل</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $person->address) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Background & Social -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-primary mb-6 border-b border-gray-100 pb-3 flex items-center">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            الخلفية والتعليم والنشاطات
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="level" class="block text-sm font-bold text-gray-700">المستوى الدراسي</label>
                                    <input type="text" name="level" id="level" value="{{ old('level', $person->level) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                </div>
                                <div>
                                    <label for="religion" class="block text-sm font-bold text-gray-700">الالتزام الديني</label>
                                    <input type="text" name="religion" id="religion" value="{{ old('religion', $person->religion) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="education" class="block text-sm font-bold text-gray-700">التكوين والشهادات</label>
                                    <textarea name="education" id="education" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('education', $person->education) }}</textarea>
                                </div>
                                <div>
                                    <label for="upbringing" class="block text-sm font-bold text-gray-700">النشأة والبيئة الاجتماعية</label>
                                    <textarea name="upbringing" id="upbringing" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">{{ old('upbringing', $person->upbringing) }}</textarea>
                                </div>
                            </div>
                            <div>
                                <label for="social" class="block text-sm font-bold text-gray-700">حسابات التواصل الاجتماعي</label>
                                <textarea name="social" id="social" rows="2" dir="ltr" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm text-left font-mono">{{ old('social', $person->social) }}</textarea>
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">ملاحظات إدارية وأمنية هامة</label>
                                <div id="editor-container" class="bg-white" style="height: 200px;"></div>
                                <textarea name="notes" id="notes" class="hidden">{{ old('notes', $person->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 space-x-reverse pt-6">
                        <a href="{{ route('dashboard.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                            إلغاء التعديل
                        </a>
                        <button type="submit" class="inline-flex items-center px-10 py-3 bg-primary hover:bg-primary-dark border border-transparent rounded-xl font-bold text-white shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            حفظ التغييرات
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        // Tunisian Administrative Data (Synced with create.blade.php)
        const tunisiaData = {
            "بن عروس": {
                "بن عروس": [
                    "بن عروس الشرقية",
                    "حي ابن عرفة",
                    "المهيري",
                    "بن عروس الغربية",
                    "سيدي بن عروس",
                    "حي الإسكان"
                ],
                "المدينة الجديدة": [
                    "المدينة الجديدة 1",
                    "المدينة الجديدة 2",
                    "سيدي مصباح",
                    "الياسمينات",
                    "الرابطة"
                ],
                "المروج": [
                    "المروج 1",
                    "المروج 3",
                    "المروج 4",
                    "المروج 5",
                    "بئر القصعة",
                    "فرحات حشاد"
                ],
                "حمام الأنف": [
                    "حمام الأنف المدينة",
                    "حمام الأنف المدينة 2",
                    "حمام الأنف بوقرنين",
                    "فرحات حشاد",
                    "حمام الأنف الملعب",
                    "حي محمد علي"
                ],
                "حمام الشط": [
                    "بئر الباي",
                    "برج السدرية",
                    "حمام الشط"
                ],
                "بومهل البساتين": [
                    "بومهل",
                    "البساتين",
                    "البساتين الغربية",
                    "شالة"
                ]
            },

            "نابل": {
                "نابل": [
                    "الأسواق",
                    "النور",
                    "بئر شلوف",
                    "نيابوليس",
                    "الحدائق",
                    "الهادي شاكر"
                ],
                "دار شعبان الفهري": [
                    "دار شعبان",
                    "الفهري",
                    "الفرينين",
                    "عمرون"
                ],
                "بني خيار": [
                    "بني خيار",
                    "ديار بن سالم",
                    "المعمورة",
                    "الصمعة",
                    "حلفاء"
                ],
                "قربة": [
                    "بني عياش",
                    "قرعة ساسي",
                    "ديار الحجاج",
                    "قربة الشرقية",
                    "قربة الغربية",
                    "تازركة",
                    "بوجريدة",
                    "بولدين"
                ]
            },

            "بنزرت": {
                "بنزرت الشمالية": [
                    "حسن النوري",
                    "الحبيب بوقطفة",
                    "الكرنيش",
                    "المدينة",
                    "الشيخ إدريس",
                    "القنال",
                    "بوبكر باكير",
                    "عين مريم",
                    "الحبيب حداد",
                    "المؤتمر",
                    "الهناء",
                    "15 أكتوبر",
                    "جزيرة جالطة"
                ],
                "جرزونة": [
                    "جرزونة الغربية",
                    "جرزونة الشرقية",
                    "جرزونة الشمالية",
                    "جرزونة الجنوبية"
                ],
                "بنزرت الجنوبية": [
                    "تسكراية",
                    "فرحات حشاد",
                    "مرنيصة",
                    "هيشر",
                    "سيدي عامر",
                    "اللواتة",
                    "باب ماطر",
                    "حي الجلاء",
                    "المصيدة",
                    "سيدي أحمد"
                ]
            },

            "سوسة": {
                "سوسة المدينة": [
                    "بوجعفر",
                    "المدينة",
                    "علي البلهوان",
                    "محمد معروف",
                    "خزامة"
                ],
                "الزاوية القصيبة الثريات": [
                    "زاوية سوسة",
                    "قصيبة سوسة",
                    "الثريات"
                ],
                "سوسة الرياض": [
                    "الزهور",
                    "حي الرياض",
                    "حمام معروف"
                ],
                "سوسة جوهرة": [
                    "وادي بليبان",
                    "سهلول",
                    "حشاد",
                    "الهادي شاكر",
                    "بوحسينة",
                    "محمد القروي"
                ]
            },
            "المنستير": {
                "المنستير": [
                    "المدينة",
                    "المدينة 2",
                    "باب الغربي",
                    "الربط",
                    "الحلية",
                    "الحلية 2",
                    "صقانس",
                    "خنيس",
                    "خنيس الشمالية"
                ],
                "جمال": [
                    "جمال القبلية",
                    "جمال الجوفية",
                    "جمال الشرقية",
                    "جمال الغربية",
                    "زاوية قنطش",
                    "بئر الطيب",
                    "منزل كامل",
                    "الهدادرة",
                    "الطيايرة"
                ]
            },

            "المهدية": {
                "المهدية": [
                    "المهدية",
                    "زويلة",
                    "زويلة الجنوبية",
                    "رجيش",
                    "رجيش الجنوبية",
                    "شيبة",
                    "السعد",
                    "الجواودة",
                    "الزهراء",
                    "الزقانة",
                    "هيبون",
                    "الرمل",
                    "الحكايمة الشرقية",
                    "الحكايمة الغربية"
                ],
                "الشابة": [
                    "الشابة الشمالية",
                    "الشابة الجنوبية",
                    "السعفات"
                ]
            },

            "صفاقس": {
                "صفاقس المدينة": [
                    "المدينة",
                    "باب البحر",
                    "الحي الخيري",
                    "البساتين",
                    "الربض",
                    "15 نوفمبر",
                    "عين شيخ روحه",
                    "الحي التعويضي",
                    "مركز قدور",
                    "مركز الباشا",
                    "سيدي عباس",
                    "محمد علي"
                ],
                "ساقية الزيت": [
                    "ساقية الزيت",
                    "مركز بوعصيدة",
                    "السدرة",
                    "الأنس",
                    "الشيحية",
                    "تنيور",
                    "سيدي صالح"
                ]
            },

            "القيروان": {
                "القيروان الشمالية": [
                    "الأنصار",
                    "الجامع الشمالية",
                    "الجامع الجنوبية",
                    "القبلية الشمالية",
                    "الجبلية الشمالية",
                    "الجبلية الجنوبية",
                    "المنشية",
                    "الأغالبة",
                    "الباطن",
                    "ذراع التمار",
                    "المتبسطة",
                    "الغابات"
                ],
                "القيروان الجنوبية": [
                    "المنصورة الشمالية",
                    "المنصورة الجنوبية",
                    "القبلية الجنوبية",
                    "مرق الليل",
                    "رقادة",
                    "زرود",
                    "التبان",
                    "أولاد نهار",
                    "الخزازية",
                    "المخصومة",
                    "النبش",
                    "زعفرانة",
                    "الخضراء",
                    "الحمام",
                    "بريكات العرقوب"
                ]
            },

            "قفصة": {
                "قفصة الشمالية": [
                    "قطيس",
                    "الرحيبة",
                    "الرحيبة الجنوبية",
                    "قصور الإخوة",
                    "المتكيدس",
                    "الفج",
                    "منزل ميمون"
                ],
                "المتلوي": [
                    "المتلوي المركز",
                    "المتلوي المحطة",
                    "السقي القبلي",
                    "حي الأمل الغربي",
                    "حي الأمل الشرقي",
                    "المزيرعة",
                    "وادي الأرطة",
                    "المقرون",
                    "الثالجة",
                    "ريشة النعام"
                ]
            },

            "قابس": {
                "قابس المدينة": [
                    "المنطقة الأولى",
                    "المنطقة الثانية",
                    "المنطقة الثالثة",
                    "المنطقة الرابعة",
                    "شط سيدي عبد السلام"
                ],
                "الحامة": [
                    "المنطقة الشمالية",
                    "القصر",
                    "المنطقة الشرقية 1",
                    "المنطقة الشرقية 2",
                    "المنطقة القبلية",
                    "فرحات حشاد",
                    "شانشو",
                    "البحاير",
                    "بشيمة البرج",
                    "بشيمة القلب",
                    "بوعطوش",
                    "الحبيب ثامر",
                    "المنطقة الغربية"
                ]
            },

            "مدنين": {
                "مدنين الشمالية": [
                    "بني غزيل",
                    "2 ماي",
                    "مدنين الغربية",
                    "20 مارس",
                    "مدنين الشمالية",
                    "أم التمر الغربية",
                    "أم التمر الشرقية",
                    "كوتين"
                ],
                "جرجيس": [
                    "جرجيس",
                    "2 مارس",
                    "الطاهر صفر",
                    "الجدارية",
                    "البساتين",
                    "السويحل",
                    "وادي التياب",
                    "حسي الجربي",
                    "خوي الغدير",
                    "حمادي",
                    "هشام الحمادي",
                    "الغرابات",
                    "القريبيس",
                    "حمادي بوتفاحة",
                    "العقلة",
                    "شماخ"
                ]
            },

            "توزر": {
                "توزر": [
                    "مسغونة",
                    "الزبدة",
                    "الهبائلة",
                    "الهوادف",
                    "القيطنة",
                    "رأس الذراع حلبة",
                    "الازدهار",
                    "حي المطار",
                    "الشابية",
                    "الحضر"
                ],
                "نفطة": [
                    "الشافعي الشريف",
                    "غرة جوان",
                    "الواحة",
                    "السنى",
                    "العيون",
                    "التحرير",
                    "الأصيل",
                    "الخضر بن حسين"
                ]
            },

            "تطاوين": {
                "تطاوين الشمالية": [
                    "النزهة",
                    "التضامن",
                    "النصر",
                    "وادي القمح",
                    "برورمت",
                    "تلالت",
                    "وادي الغار",
                    "المعونة",
                    "الزهراء",
                    "قطوفة",
                    "خاتمة",
                    "السعادة",
                    "القلعة الشرقية",
                    "القلعة الغربية",
                    "بني بلال"
                ],
                "تطاوين الجنوبية": [
                    "تطاوين المدينة",
                    "تطاوين العليا",
                    "المزطورية الجنوبية",
                    "المزطورية الشمالية",
                    "غرغار",
                    "حي البر",
                    "قصر المقابلة",
                    "شنني الجديدة",
                    "شنني",
                    "الدويرات",
                    "المسرب",
                    "الرقبة",
                    "رأس الوادي",
                    "بئر الثلاثين",
                    "بني بركة"
                ]
            },

            "قبلي": {
                "قبلي الجنوبية": [
                    "قبلي الجنوبية",
                    "بازمة",
                    "جمنة الشمالية",
                    "جمنة الجنوبية",
                    "بشلى",
                    "جرسين",
                    "البليدات",
                    "بني محمد",
                    "جنعورة"
                ],
                "دوز الجنوبية": [
                    "دوز الغربية",
                    "العذارة",
                    "غليسية",
                    "نويل الشمالية",
                    "نويل الجنوبية"
                ]
            }
        };

        const savedValues = {
            country: "{{ old('country', $person->country) }}",
            governorate: "{{ old('governorate', $person->governorate) }}",
            delegation: "{{ old('delegation', $person->delegation) }}",
            sector: "{{ old('sector', $person->sector) }}"
        };

        function populateGovernorates() {
            const govSelect = document.getElementById('governorate');
            govSelect.innerHTML = '<option value="">-- اختر الولاية --</option>';
            Object.keys(tunisiaData).forEach(gov => {
                const option = document.createElement('option');
                option.value = gov;
                option.textContent = gov;
                if (gov === savedValues.governorate) option.selected = true;
                govSelect.appendChild(option);
            });
        }

        function handleCountryChange(isInit = false) {
            const country = document.getElementById('country').value;
            const regionsDiv = document.getElementById('tunisia-regions');
            if (country === 'تونس') {
                regionsDiv.style.display = 'grid';
                populateGovernorates();
                if (isInit && savedValues.governorate) {
                    handleGovernorateChange(true);
                }
            } else {
                regionsDiv.style.display = 'none';
                clearSelect('governorate');
                clearSelect('delegation');
                clearSelect('sector');
            }
        }

        function handleGovernorateChange(isInit = false) {
            const gov = document.getElementById('governorate').value;
            const delSelect = document.getElementById('delegation');
            clearSelect('delegation');
            clearSelect('sector');

            if (gov && tunisiaData[gov]) {
                Object.keys(tunisiaData[gov]).forEach(del => {
                    const option = document.createElement('option');
                    option.value = del;
                    option.textContent = del;
                    if (isInit && del === savedValues.delegation) option.selected = true;
                    delSelect.appendChild(option);
                });
                if (isInit && savedValues.delegation) {
                    handleDelegationChange(true);
                }
            }
        }

        function handleDelegationChange(isInit = false) {
            const gov = document.getElementById('governorate').value;
            const del = document.getElementById('delegation').value;
            const secSelect = document.getElementById('sector');
            clearSelect('sector');

            if (gov && del && tunisiaData[gov][del]) {
                tunisiaData[gov][del].forEach(sec => {
                    const option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
                    if (isInit && sec === savedValues.sector) option.selected = true;
                    secSelect.appendChild(option);
                });
            }
        }

        function clearSelect(id) {
            const select = document.getElementById(id);
            const placeholder = id === 'governorate' ? '-- اختر الولاية --' : 
                                id === 'delegation' ? '-- اختر المعتمدية --' : '-- اختر العمادة --';
            select.innerHTML = `<option value="">${placeholder}</option>`;
        }

        // Map Logic
        var initialLat = {{ $person->latitude ?? 33.8869 }};
        var initialLng = {{ $person->longitude ?? 9.5375 }};
        var map = L.map('map').setView([initialLat, initialLng], (initialLat === 33.8869 ? 6 : 13));

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
        });

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoords(position.lat, position.lng);
        });

        function updateCoords(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        }

        // Quill Initialization
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'اكتب الملاحظات هنا...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'direction': 'rtl' }, { 'align': [] }],
                    ['link', 'clean']
                ]
            }
        });

        // Set initial content
        var initialNotes = document.getElementById('notes').value;
        if (initialNotes) {
            quill.root.innerHTML = initialNotes;
        }

        // Sync Quill with hidden textarea on form submit
        document.getElementById('edit-person-form').onsubmit = function() {
            document.getElementById('notes').value = quill.root.innerHTML;
        };

        // Image Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            handleCountryChange(true);
        });
    </script>

    <style>
        .text-primary { color: #1e40af; }
        .bg-primary { background-color: #1e40af; }
        .bg-primary-dark { background-color: #1a368e; }
        .focus\:ring-primary:focus { --tw-ring-opacity: 1; --tw-ring-color: rgb(30 64 175 / var(--tw-ring-opacity)); }
        .focus\:border-primary:focus { border-color: #1e40af; }
        
        /* Quill RTL Fix */
        .ql-editor {
            direction: rtl;
            text-align: right;
        }
    </style>
</x-app-layout>