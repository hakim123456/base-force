<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('dashboard.index') }}"
                class="text-gray-500 hover:text-primary transition-colors ml-3 border border-gray-300 rounded p-1">
                <!-- RTL Arrow Right -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                إضافة عنصر جديد
            </h2>
        </div>
    </x-slot>

    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Include Quill -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mb-6">
        <form id="create-person-form" action="{{ route('dashboard.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Right Column (Personal Details) -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2">المعلومات الشخصية</h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الصورة الشخصية</label>
                        <input type="file" name="photo"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                        <p class="text-xs text-gray-500 mt-1">تنسيقات مدعومة: JPG, PNG, GIF (الحد الأقصى 2 ميجابايت)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المعرف (رقم بطاقة تعريف وطنية
                            )</label>
                        <input type="text" name="identifier"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل المعرف">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الاسم</label>
                        <input type="text" name="first_name" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل الاسم">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اللقب</label>
                        <input type="text" name="last_name"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل اللقب">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اسم الأب</label>
                        <input type="text" name="father_name"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل اسم الأب">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">اسم الجد</label>
                        <input type="text" name="grandfather_name"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل اسم الجد">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">تاريخ الولادة</label>
                        <input type="date" name="dob"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المهنة</label>
                        <input type="text" name="job"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل المهنة">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">البلد (Pays)</label>
                        <select name="country" id="country" onchange="handleCountryChange()"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                            <option value="">-- اختر البلد --</option>
                            <option value="تونس" selected>تونس (Tunisie)</option>
                            <option value="أخرى">بلد آخر (Autre)</option>
                        </select>
                    </div>

                    <div id="tunisia-regions" class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">الولاية (Gouvernorat)</label>
                            <select name="governorate" id="governorate" onchange="handleGovernorateChange()"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                                <option value="">-- اختر الولاية --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">المعتمدية (Délégation)</label>
                            <select name="delegation" id="delegation" onchange="handleDelegationChange()"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                                <option value="">-- اختر المعتمدية --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">العمادة (Secteur/Imada)</label>
                            <select name="sector" id="sector"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
                                <option value="">-- اختر العمادة --</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">العنوان الحالي (Adresse)</label>
                        <input type="text" name="address"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أدخل العنوان الحالي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">أرقام الهاتف</label>
                        <input type="text" name="phone"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="أرقام الهاتف (مفصولة بفاصلة)">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">وسائل التواصل الاجتماعي</label>
                        <textarea name="social" rows="2"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="روابط أو حسابات التواصل"></textarea>
                    </div>
                </div>

                <!-- Left Column (Additional Details) -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2">التفاصيل الإضافية والنشاطات</h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">النشأة</label>
                        <input type="text" name="upbringing"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="تاريخ وبيئة النشأة">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الدراسة</label>
                        <input type="text" name="education"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="المسار الدراسي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المستوى الحالي</label>
                        <input type="text" name="level"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="المستوى الأكاديمي أو التعليمي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">مجال العمل السابق والحالي</label>
                        <textarea name="work_history" rows="2"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="تفاصيل الأعمال السابقة والحالية"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المجال الديني</label>
                        <input type="text" name="religion"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="التوجه أو النشاط الديني">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المشاركة في الأعمال الدعوية</label>
                        <input type="text" name="dawah"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="تفاصيل المشاركات">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الكتب</label>
                        <input type="text" name="books"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="الكتب المميزة أو التي يقرؤها">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">السفر</label>
                        <input type="text" name="travels"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="تاريخ الوجهات والسفر">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الأصدقاء</label>
                        <input type="text" name="friends"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm"
                            placeholder="شبكة المعارف والأصدقاء المقربين">
                    </div>

                    <!-- Administrative Notes with Quill -->
                    <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 border-r-4 border-r-yellow-400">
                        <label class="block text-sm font-bold text-yellow-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            ملاحظات إدارية وأمنية هامة
                        </label>
                        <!-- Quill editor container -->
                        <div id="notes-editor"
                            style="min-height:150px; direction:rtl; font-family:Tahoma,Arial,sans-serif; font-size:14px;">
                        </div>
                        <!-- Hidden textarea to submit content -->
                        <textarea name="notes" id="notes" class="hidden"></textarea>
                    </div>
                </div>

                <!-- Bottom Section (Geolocation) -->
                <div class="md:col-span-2 space-y-5 border-t pt-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2 flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        الموقع الجغرافي (Géolocalisation)
                    </h3>
                    <p class="text-sm text-gray-500">انقر على الخريطة لتحديد الموقع أو استخدم زر تحديد الموقع التلقائي.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">خط العرض (Latitude)</label>
                            <input type="text" id="latitude" name="latitude"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm bg-gray-50"
                                placeholder="مثال: 36.8065" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">خط الطول (Longitude)</label>
                            <input type="text" id="longitude" name="longitude"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm bg-gray-50"
                                placeholder="مثال: 10.1815" readonly>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" onclick="getCurrentLocation()"
                            class="mb-3 px-4 py-2 bg-blue-100 text-blue-800 font-bold text-sm rounded-lg hover:bg-blue-200 transition flex items-center">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            تحديد موقعي الحالي
                        </button>
                        <div id="map" class="w-full h-80 rounded-xl border border-gray-300 shadow-inner z-0"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end rounded-b-xl">
                <a href="{{ route('dashboard.index') }}"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 ml-3 transition">
                    إلغاء
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-primary border border-transparent rounded-lg shadow-sm text-sm font-bold text-white hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    إضافة عنصر
                </button>
            </div>
        </form>
    </div>

    <!-- Leaflet JS logic -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Tunisia Administrative Data
        const tunisiaData = {
            "تونس": {
                "تونس المدينة": ["المدينة", "الباشا", "القصبة", "سيدي بومنديل", "المركاض", "تربة الباي", "الزاوية", "نهج القصبة"],
                "باب البحر": ["باب البحر", "نهج قانا", "الحفصية", "شارع الحبيب بورقيبة"],
                "باب سويقة": ["باب سويقة", "باب سعدون", "نهج الحلفاوين", "نهج باب بودرور"],
                "العمران": ["العمران", "سيدي جبالي", "طريق قرطاج"],
                "العمران الأعلى": ["العمران الأعلى", "العمران الأعلى 2", "قرية الرمان"],
                "التحرير": ["التحرير 1", "التحرير 2", "التحرير 3", "التحرير 4"],
                "المنزه": ["المنزه 1", "المنزه 5", "المنزه 6", "المنزه 9"],
                "حي الخضراء": ["حي الخضراء 1", "حي الخضراء 2", "الشرقية"],
                "باردو": ["باردو الشمالي", "باردو الجنوبي", "بوشوشة"],
                "السيجومي": ["السيجومي", "حي الزهور", "حي الزهور 4"],
                "الزهور": ["الزهور 1", "الزهور 2", "الزهور 3"],
                "الحرايرية": ["الحرايرية", "العقبة", "غدير القلة"],
                "سيدي حسين": ["سيدي حسين", "الجيارة", "عطار"],
                "الوردية": ["الوردية 1", "الوردية 2", "الوردية 3"],
                "الكبارية": ["الكبارية 1", "الكبارية 2", "الكبارية 3", "المروج 2"],
                "سيدي البشير": ["سيدي البشير", "معقل الزعيم", "حي الأنف"],
                "جبل الجلود": ["جبل الجلود", "حي القرجاني", "السيجومي 2"],
                "حلق الوادي": ["حلق الوادي", "حلق الوادي الكازينو", "خير الدين"],
                "الكرم": ["الكرم الشرقي", "الكرم الغربي", "عين زغوان"],
                "قرطاج": ["قرطاج المدينة", "قرطاج الياسمينة", "سيدي بو سعيد"],
                "المرسى": ["المرسى المدينة", "المرسى الشاطئ", "المرسى الرياض", "سيدي عبد العزيز"]
            },
            "أريانة": {
                "أريانة المدينة": ["أريانة المدينة", "حي المستقبل", "المنزه 5", "المنزه 6"],
                "سكرة": ["سكرة", "دار فضال", "برج الوزير", "حي الفتح"],
                "رواد": ["رواد", "حي الغزالة", "حي شاكر", "برج الطويل"],
                "قلعة الأندلس": ["قلعة الأندلس", "قنطرة بنزرت", "المصيدة"],
                "سيدي ثابت": ["سيدي ثابت", "بجاوة", "سبالة بن عمار"],
                "حي التضامن": ["حي التضامن", "حي البساتين"],
                "المنيهلة": ["المنيهلة", "الصنهاجي", "البساتين"]
            },
            "بن عروس": {
                "بن عروس": ["بن عروس الشرقية", "بن عروس الغربية", "حي ابن سيناء"],
                "رادس": ["رادس المدينة", "رادس الملاحة", "رادس الغابة"],
                "مقرين": ["مقرين الرياض", "مقرين العليا", "مقرين شاكر"],
                "الزهراء": ["الزهراء المدينة", "حي الحبيب", "برج لوزير"],
                "حمام الأنف": ["حمام الأنف المدينة", "بوقرنين"],
                "حمام الشط": ["حمام الشط", "برج السدرية"],
                "بومهل البساتين": ["بومهل", "البساتين"],
                "فوشانة": ["فوشانة", "المغيرة"],
                "المحمدية": ["المحمدية", "حي النسيم"],
                "المدينة الجديدة": ["المدينة الجديدة 1", "المدينة الجديدة 2"],
                "المروج": ["المروج 1", "المروج 3", "المروج 4", "المروج 5"],
                "مرناق": ["مرناق", "خليدية", "جبل الرصاص"]
            },
            "منوبة": {
                "منوبة": ["منوبة", "الدندان", "منوبة الوسطى"],
                "وادي الليل": ["وادي الليل", "المنصورة", "حي الورد"],
                "دوار هيشر": ["دوار هيشر", "حي الشباب"],
                "المرناقية": ["المرناقية", "سيدي علي الحطاب"],
                "برج العامري": ["برج العامري", "برج النور"],
                "الجديدة": ["الجديدة", "الحبيبية"],
                "طبربة": ["طبربة", "حي الاندلس"],
                "البطان": ["البطان", "المريسة"]
            },
            "نابل": {
                "نابل": ["نابل المدينة", "نابل الشمالية"],
                "دار شعبان الفهري": ["دار شعبان", "الفهري"],
                "بني خيار": ["بني خيار", "المعمورة"],
                "قربة": ["قربة المدينة", "قربة الشرقية"],
                "منزل تميم": ["منزل تميم", "وديان"],
                "المائدة": ["المائدة الشمالية", "المائدة الجنوبية"],
                "قليبية": ["قليبية المدينة", "وادي الخطف"],
                "حمام الأغزاز": ["حمام الأغزاز", "وزدرة"],
                "الهوارية": ["الهوارية", "صاحب الجبل"],
                "منزل بوزلفة": ["منزل بوزلفة", "سيدي التومي"],
                "بني خلاد": ["بني خلاد", "زاوية الجديدي"],
                "سليمان": ["سليمان المدينة", "سليمان الشاطئ", "بوشراي"],
                "قرمبالية": ["قرمبالية", "فندق الجديد"],
                "بوعرقوب": ["بوعرقوب", "المريسة"],
                "الحمامات": ["الحمامات المدينة", "المرازقة", "حي الياسمين"]
            },
            "القصرين": {
                "القصرين الشمالية": ["القصرين المدينة", "حي النور", "الخضراء"],
                "القصرين الجنوبية": ["الزهور", "حي الفتح", "بوزقام"],
                "سبيطلة": ["سبيطلة", "الخضراء", "الاثار"],
                "سبيبة": ["سبيبة", "حي الاندلس"],
                "جدليان": ["جدليان", "حي النسيم"],
                "تالة": ["تالة المدينة", "تالة الشرقية", "تالة الغربية"],
                "العيون": ["العيون", "بوشبكة"],
                "حيدرة": ["حيدرة", "المحطة"],
                "فوسانة": ["فوسانة", "بودرياس"],
                "فريانة": ["فريانة المدينة", "تلابت"],
                "ماجل بلعباس": ["ماجل بلعباس", "حي الوحدة"]
            },
            "بنزرت": {
                "بنزرت الشمالية": ["بنزرت المدينة", "حي الجلاء"],
                "بنزرت الجنوبية": ["بنزرت الجنوبية", "حي الجلاء"],
                "منزل بورقيبة": ["منزل بورقيبة المدينة", "حي النجاح"],
                "ماطر": ["ماطر المدينة", "حي النصر"],
                "غزالة": ["غزالة", "العرب"],
                "سجنان": ["سجنان", "المصيدة"]
            },
            "سوسة": {
                "سوسة المدينة": ["سوسة المدينة", "حي الرياض"],
                "سوسة جوهرة": ["سوسة جوهرة", "حي سهلول"],
                "سوسة الرياض": ["حي الرياض", "حي الزهور"],
                "حمام سوسة": ["حمام سوسة المدينة", "المنشية"],
                "مساكن": ["مساكن المدينة", "حي النور"],
                "القلعة الكبرى": ["القلعة الكبرى", "حي الزيتون"]
            },
            "المنستير": {
                "المنستير": ["المنستير المدينة", "حي الربط"],
                "المكنين": ["المكنين المدينة", "حي الزيتون"],
                "جمال": ["جمال المدينة", "حي الفتح"],
                "قصر هلال": ["قصر هلال المدينة", "حي النسيم"]
            },
            "المهدية": {
                "المهدية": ["المهدية المدينة", "حي رجيش"],
                "الجم": ["الجم المدينة", "حي الاثار"],
                "قصور الساف": ["قصور الساف", "سلقطة"]
            },
            "صفاقس": {
                "صفاقس المدينة": ["صفاقس المدينة", "طريق تونس"],
                "صفاقس الغربية": ["صفاقس الغربية", "حي الحبيب"],
                "صفاقس الجنوبية": ["صفاقس الجنوبية", "طريق قابس"],
                "ساقية الزيت": ["ساقية الزيت", "ساقية الداير"]
            },
            "سيدي بوزيد": {
                "سيدي بوزيد الشرقية": ["سيدي بوزيد المدينة", "الأسودة"],
                "سيدي بوزيد الغربية": ["سيدي بوزيد الغربية", "حي الخضراء"],
                "سبيطلة": ["سبيطلة", "الخضراء"],
                "الرقاب": ["الرقاب", "السعيدة"]
            },
            "القيروان": {
                "القيروان الشمالية": ["القيروان المدينة", "حي النصر"],
                "القيروان الجنوبية": ["حي الحجام", "المنصورة"],
                "بوحجلة": ["بوحجلة المدينة", "حي الفتح"]
            },
            "قابس": {
                "قابس المدينة": ["قابس المدينة", "حي المنارة"],
                "قابس الجنوبية": ["قابس الجنوبية", "حي الأمل"],
                "مارث": ["مارث المدينة", "مطماطة القديمة"]
            },
            "مدنين": {
                "مدنين الشمالية": ["مدنين المدينة", "حي النصر"],
                "مدنين الجنوبية": ["مدنين الجنوبية", "حي الفتح"],
                "جرجيس": ["جرجيس المدينة", "جرجيس الشمالية"],
                "جربة حومة السوق": ["حومة السوق المدينة", "حي السواقي"],
                "جربة ميدون": ["ميدون", "حي الصداقة"]
            },
            "تطاوين": {
                "تطاوين الشمالية": ["تطاوين المدينة", "حي النور"],
                "تطاوين الجنوبية": ["حي المهرجان", "حي النسيم"],
                "غمراسن": ["غمراسن المدينة", "حي الفتح"]
            },
            "توزر": {
                "توزر": ["توزر المدينة", "حي القناية"],
                "نفطة": ["نفطة المدينة", "حي الرياض"],
                "دقاش": ["دقاش المدينة", "حي النور"]
            },
            "قبلي": {
                "قبلي الشمالية": ["قبلي المدينة", "حي النصر"],
                "قبلي الجنوبية": ["قبلي الجنوبية", "حي الفتح"],
                "دوز": ["دوز المدينة", "دوز الشمالية"]
            },
            "قفصة": {
                "قفصة المدينة": ["قفصة المدينة", "حي الدوالي"],
                "قفصة الجنوبية": ["حي القصر", "حي الشباب"],
                "المتلوي": ["المتلوي المدينة", "حي الثالجة"]
            },
            "باجة": {
                "باجة الشمالية": ["باجة المدينة", "حي الفتح"],
                "باجة الجنوبية": ["حي النصر", "حي الخضراء"],
                "مجاز الباب": ["مجاز الباب المدينة", "حي الاندلس"]
            },
            "جندوبة": {
                "جندوبة الشمالية": ["جندوبة المدينة", "حي الزهور"],
                "بوسالم": ["بوسالم المدينة", "حي الفتح"],
                "طبرقة": ["طبرقة المدينة", "حي المرجان"]
            },
            "الكاف": {
                "الكاف الشرقية": ["الكاف المدينة", "حي الشرفة"],
                "الكاف الغربية": ["حي البساتين", "حي النصر"],
                "تاجروين": ["تاجروين المدينة", "حي الفتح"]
            },
            "سليانة": {
                "سليانة الشمالية": ["سليانة المدينة", "حي النصر"],
                "سليانة الجنوبية": ["حي الفتح", "حي الخضراء"],
                "بوعرادة": ["بوعرادة المدينة", "حي الرياض"]
            },
            "زغوان": {
                "زغوان": ["زغوان المدينة", "حي النسيم"],
                "الفحص": ["الفحص المدينة", "حي الفتح"],
                "الناظور": ["الناظور المدينة", "حي النور"]
            }
        };

        function populateGovernorates() {
            const govSelect = document.getElementById('governorate');
            govSelect.innerHTML = '<option value="">-- اختر الولاية --</option>';
            Object.keys(tunisiaData).forEach(gov => {
                const option = document.createElement('option');
                option.value = gov;
                option.textContent = gov;
                govSelect.appendChild(option);
            });
        }

        function handleCountryChange() {
            const country = document.getElementById('country').value;
            const regionsDiv = document.getElementById('tunisia-regions');
            if (country === 'تونس') {
                regionsDiv.style.display = 'grid';
                populateGovernorates();
            } else {
                regionsDiv.style.display = 'none';
                clearSelect('governorate');
                clearSelect('delegation');
                clearSelect('sector');
            }
        }

        function handleGovernorateChange() {
            const gov = document.getElementById('governorate').value;
            const delSelect = document.getElementById('delegation');
            clearSelect('delegation');
            clearSelect('sector');
            if (gov && tunisiaData[gov]) {
                Object.keys(tunisiaData[gov]).forEach(del => {
                    const option = document.createElement('option');
                    option.value = del;
                    option.textContent = del;
                    delSelect.appendChild(option);
                });
            }
        }

        function handleDelegationChange() {
            const gov = document.getElementById('governorate').value;
            const del = document.getElementById('delegation').value;
            const secSelect = document.getElementById('sector');
            clearSelect('sector');
            if (gov && del && tunisiaData[gov][del]) {
                tunisiaData[gov][del].forEach(sec => {
                    const option = document.createElement('option');
                    option.value = sec;
                    option.textContent = sec;
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

        // Map initialization
        var map = L.map('map').setView([36.8065, 10.1815], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        map.on('click', function (e) {
            var lat = e.latlng.lat.toFixed(7);
            var lng = e.latlng.lng.toFixed(7);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
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
                }, function () {
                    alert("Erreur de géolocalisation.");
                });
            } else {
                alert("La géolocalisation n'est pas supportée par votre navigateur.");
            }
        }

        // Initialize dropdowns on page load
        document.addEventListener('DOMContentLoaded', function () {
            handleCountryChange();
        });
    </script>


    <!-- Quill initialization -->
    "باب البحر": ["باب البحر", "نهج قانا", "الحفصية", "شارع الحبيب بورقيبة"],
    "باب سويقة": ["باب سويقة", "باب سعدون", "نهج الحلفاوين", "نهج باب بودرور"],
    "العمران": ["العمران", "سيدي جبالي", "طريق قرطاج"],
    "العمران الأعلى": ["العمران الأعلى", "العمران الأعلى 2", "قرية الرمان"],
    "التحرير": ["التحرير 1", "التحرير 2", "التحرير 3", "التحرير 4"],
    "المنزه": ["المنزه 1", "المنزه 5", "المنزه 6", "المنزه 9"],
    "حي الخضراء": ["حي الخضراء 1", "حي الخضراء 2", "الشرقية"],
    "باردو": ["باردو الشمالي", "باردو الجنوبي", "بوشوشة"],
    "السيجومي": ["السيجومي", "حي الزهور", "حي الزهور 4"],
    "الزهور": ["الزهور 1", "الزهور 2", "الزهور 3"],
    "الحرايرية": ["الحرايرية", "العقبة", "غدير القلة"],
    "سيدي حسين": ["سيدي حسين", "الجيارة", "عطار"],
    "الوردية": ["الوردية 1", "الوردية 2", "الوردية 3"],
    "الكبارية": ["الكبارية 1", "الكبارية 2", "الكبارية 3", "المروج 2"],
    "سيدي البشير": ["سيدي البشير", "معقل الزعيم", "حي الأنف"],
    "جبل الجلود": ["جبل الجلود", "حي القرجاني", "السيجومي 2"],
    "حلق الوادي": ["حلق الوادي", "حلق الوادي الكازينو", "خير الدين"],
    "الكرم": ["الكرم الشرقي", "الكرم الغربي", "عين زغوان"],
    "قرطاج": ["قرطاج المدينة", "قرطاج الياسمينة", "سيدي بو سعيد"],
    "المرسى": ["المرسى المدينة", "المرسى الشاطئ", "المرسى الرياض", "سيدي عبد العزيز"]
    },
    "أريانة": {
    "أريانة المدينة": ["أريانة المدينة", "حي المستقبل", "المنزه 5", "المنزه 6"],
    "سكرة": ["سكرة", "دار فضال", "برج الوزير", "حي الفتح"],
    "رواد": ["رواد", "حي الغزالة", "حي شاكر", "برج الطويل"],
    "قلعة الأندلس": ["قلعة الأندلس", "قنطرة بنزرت", "المصيدة"],
    "سيدي ثابت": ["سيدي ثابت", "بجاوة", "سبالة بن عمار"],
    "حي التضامن": ["حي التضامن", "حي البساتين"],
    "المنيهلة": ["المنيهلة", "الصنهاجي", "البساتين"]
    },
    "بن عروس": {
    "بن عروس": ["بن عروس الشرقية", "بن عروس الغربية", "حي ابن سيناء"],
    "رادس": ["رادس المدينة", "رادس الملاحة", "رادس الغابة"],
    "مقرين": ["مقرين الرياض", "مقرين العليا", "مقرين شاكر"],
    "الزهراء": ["الزهراء المدينة", "حي الحبيب", "برج لوزير"],
    "حمام الأنف": ["حمام الأنف المدينة", "بوقرنين"],
    "حمام الشط": ["حمام الشط", "برج السدرية"],
    "بومهل البساتين": ["بومهل", "البساتين"],
    "فوشانة": ["فوشانة", "المغيرة"],
    "المحمدية": ["المحمدية", "حي النسيم"],
    "المدينة الجديدة": ["المدينة الجديدة 1", "المدينة الجديدة 2"],
    "المروج": ["المروج 1", "المروج 3", "المروج 4", "المروج 5"],
    "مرناق": ["مرناق", "خليدية", "جبل الرصاص"]
    },
    "منوبة": {
    "منوبة": ["منوبة", "الدندان", "منوبة الوسطى"],
    "وادي الليل": ["وادي الليل", "المنصورة", "حي الورد"],
    "دوار هيشر": ["دوار هيشر", "حي الشباب"],
    "المرناقية": ["المرناقية", "سيدي علي الحطاب"],
    "برج العامري": ["برج العامري", "برج النور"],
    "الجديدة": ["الجديدة", "الحبيبية"],
    "طبربة": ["طبربة", "حي الاندلس"],
    "البطان": ["البطان", "المريسة"]
    },
    "نابل": {
    "نابل": ["نابل المدينة", "نابل الشمالية"],
    "دار شعبان الفهري": ["دار شعبان", "الفهري"],
    "بني خيار": ["بني خيار", "المعمورة"],
    "قربة": ["قربة المدينة", "قربة الشرقية"],
    "منزل تميم": ["منزل تميم", "وديان"],
    "المائدة": ["المائدة الشمالية", "المائدة الجنوبية"],
    "قليبية": ["قليبية المدينة", "وادي الخطف"],
    "حمام الأغزاز": ["حمام الأغزاز", "وزدرة"],
    "الهوارية": ["الهوارية", "صاحب الجبل"],
    "منزل بوزلفة": ["منزل بوزلفة", "سيدي التومي"],
    "بني خلاد": ["بني خلاد", "زاوية الجديدي"],
    "سليمان": ["سليمان المدينة", "سليمان الشاطئ", "بوشراي"],
    "قرمبالية": ["قرمبالية", "فندق الجديد"],
    "بوعرقوب": ["بوعرقوب", "المريسة"],
    "الحمامات": ["الحمامات المدينة", "المرازقة", "حي الياسمين"]
    },
    "القصرين": {
    "القصرين الشمالية": [
    "النور الشرقي",
    "النور الغربي",
    "البساتين",
    "الخضراء",
    "العريش",
    "بولعابة"
    ],
    "القصرين الجنوبية": [
    "العويجة",
    "بولهيجات",
    "مقدودش",
    "بوزقام",
    "سيدي حراث",
    "الدغرة"
    ],
    "الزهور": [
    "الزهور الشرقي 1",
    "الزهور الشرقي 2",
    "الزهور الغربي 1",
    "الزهور الغربي 2",
    "الزهور الغربي 3",
    "الزهور الغربي 4"
    ],
    "حاسي الفريد": [
    "حاسي الفريد",
    "الهشيم",
    "خنقة الجازية",
    "السلوم",
    "الكامور"
    ],
    "سبيطلة": [
    "سبيطلة",
    "حي السرور",
    "سمامة",
    "الرخمات",
    "القنة",
    "الدولاب",
    "الشرائع",
    "مشرق الشمس",
    "الوساعية",
    "الخضراء",
    "الآثار",
    "المزراة",
    "القرعة الحمراء",
    "القصر"
    ],
    "سبيبة": [
    "سبيبة",
    "الأحواز",
    "وادي الحطب",
    "إبراهيم الزهار",
    "عين زيان",
    "الثماد",
    "عين الخمائسية"
    ],
    "جدليان": [
    "جدليان",
    "فج تربح",
    "عين الحمادنة",
    "محرزة",
    "عين أم الجدور"
    ],
    "العيون": [
    "العيون",
    "القرين",
    "البرك",
    "البواجر",
    "توشة",
    "عين السلسلة"
    ],
    "تالة": [
    "تالة الشرقية",
    "تالة الغربية",
    "الدشرة",
    "عين الجديدة",
    "برماجنة",
    "وادي الرشح",
    "الجوي",
    "الحماد",
    "زلفان",
    "بو الأحناش",
    "سيدي محمد",
    "ولجة الظل",
    "الشافعي"
    ],
    "حيدرة": [
    "حيدرة",
    "الطباقة",
    "المكيمن",
    "الأجرد",
    "الصري",
    "عين الدفلة"
    ],
    "فوسانة": [
    "فوسانة",
    "فوسانة الأحواز",
    "خمودة الشمالية",
    "خمودة الجنوبية",
    "أولاد محفوظ",
    "أفران",
    "المزيرعة",
    "العذيرة",
    "الحازة",
    "البريكة",
    "بودرياس",
    "عين الجنان",
    "الرطيبات"
    ],
    "فريانة": [
    "فريانة",
    "العرق",
    "الأحواش",
    "الصخيرات",
    "العرعار",
    "حناشي",
    "قارة النعام",
    "بوشبكة",
    "أم علي",
    "بوحية",
    "تلابت",
    "عبد العظيم"
    ],
    "ماجل بلعباس": [
    "ماجل بلعباس الشمالية",
    "ماجل بلعباس الجنوبية",
    "أم الأقصاب",
    "الناظور",
    "هنشير أم الخير",
    "صولة",
    "قروع الجدرة"
    ]
    },
    "بنزرت": {
    "بنزرت الشمالية": ["بنزرت المدينة", "حي الجلاء"],
    "بنزرت الجنوبية": ["بنزرت الجنوبية", "حي الجلاء"],
    "منزل بورقيبة": ["منزل بورقيبة المدينة", "حي النجاح"],
    "ماطر": ["ماطر المدينة", "حي النصر"],
    "غزالة": ["غزالة", "العرب"],
    "سجنان": ["سجنان", "المصيدة"]
    },
    "سوسة": {
    "سوسة المدينة": ["سوسة المدينة", "حي الرياض"],
    "سوسة جوهرة": ["سوسة جوهرة", "حي سهلول"],
    "سوسة الرياض": ["حي الرياض", "حي الزهور"],
    "حمام سوسة": ["حمام سوسة المدينة", "المنشية"],
    "مساكن": ["مساكن المدينة", "حي النور"],
    "القلعة الكبرى": ["القلعة الكبرى", "حي الزيتون"]
    },
    "المنستير": {
    "المنستير": ["المنستير المدينة", "حي الربط"],
    "المكنين": ["المكنين المدينة", "حي الزيتون"],
    "جمال": ["جمال المدينة", "حي الفتح"],
    "قصر هلال": ["قصر هلال المدينة", "حي النسيم"]
    },
    "المهدية": {
    "المهدية": ["المهدية المدينة", "حي رجيش"],
    "الجم": ["الجم المدينة", "حي الاثار"],
    "قصور الساف": ["قصور الساف", "سلقطة"]
    },
    "صفاقس": {
    "صفاقس المدينة": ["صفاقس المدينة", "طريق تونس"],
    "صفاقس الغربية": ["صفاقس الغربية", "حي الحبيب"],
    "صفاقس الجنوبية": ["صفاقس الجنوبية", "طريق قابس"],
    "ساقية الزيت": ["ساقية الزيت", "ساقية الداير"]
    },
    "سيدي بوزيد": {
    "سيدي بوزيد الشرقية": ["سيدي بوزيد المدينة", "الأسودة"],
    "سيدي بوزيد الغربية": ["سيدي بوزيد الغربية", "حي الخضراء"],
    "سبيطلة": ["سبيطلة", "الخضراء"],
    "الرقاب": ["الرقاب", "السعيدة"]
    },
    "القيروان": {
    "القيروان الشمالية": ["القيروان المدينة", "حي النصر"],
    "القيروان الجنوبية": ["حي الحجام", "المنصورة"],
    "بوحجلة": ["بوحجلة المدينة", "حي الفتح"]
    },
    "قابس": {
    "قابس المدينة": ["قابس المدينة", "حي المنارة"],
    "قابس الجنوبية": ["قابس الجنوبية", "حي الأمل"],
    "مارث": ["مارث المدينة", "مطماطة القديمة"]
    },
    "مدنين": {
    "مدنين الشمالية": ["مدنين المدينة", "حي النصر"],
    "مدنين الجنوبية": ["مدنين الجنوبية", "حي الفتح"],
    "جرجيس": ["جرجيس المدينة", "جرجيس الشمالية"],
    "جربة حومة السوق": ["حومة السوق المددينة", "حي السواقي"],
    "جربة ميدون": ["ميدون", "حي الصداقة"]
    },
    "تطاوين": {
    "تطاوين الشمالية": ["تطاوين المدينة", "حي النور"],
    "تطاوين الجنوبية": ["حي المهرجان", "حي النسيم"],
    "غمراسن": ["غمراسن المدينة", "حي الفتح"]
    },
    "توزر": {
    "توزر": ["توزر المدينة", "حي القناية"],
    "نفطة": ["نفطة المدينة", "حي الرياض"],
    "دقاش": ["دقاش المدينة", "حي النور"]
    },
    "قبلي": {
    "قبلي الشمالية": ["قبلي المدينة", "حي النصر"],
    "قبلي الجنوبية": ["قبلي الجنوبية", "حي الفتح"],
    "دوز": ["دوز المدينة", "دوز الشمالية"]
    },
    "قفصة": {
    "قفصة المدينة": ["قفصة المدينة", "حي الدوالي"],
    "قفصة الجنوبية": ["حي القصر", "حي الشباب"],
    "المتلوي": ["المتلوي المدينة", "حي الثالجة"]
    },
    "باجة": {
    "باجة الشمالية": ["باجة المدينة", "حي الفتح"],
    "باجة الجنوبية": ["حي النصر", "حي الخضراء"],
    "مجاز الباب": ["مجاز الباب المدينة", "حي الاندلس"]
    },
    "جندوبة": {
    "جندوبة الشمالية": ["جندوبة المدينة", "حي الزهور"],
    "بوسالم": ["بوسالم المدينة", "حي الفتح"],
    "طبرقة": ["طبرقة المدينة", "حي المرجان"]
    },
    "الكاف": {
    "الكاف الشرقية": ["الكاف المدينة", "حي الشرفة"],
    "الكاف الغربية": ["حي حي البساتين", "حي النصر"],
    "تاجروين": ["تاجروين المدينة", "حي الفتح"]
    },
    "سليانة": {
    "سليانة الشمالية": ["سليانة المدينة", "حي النصر"],
    "سليانة الجنوبية": ["حي الفتح", "حي الخضراء"],
    "بوعرادة": ["بوعرادة المدينة", "حي الرياض"]
    },
    "زغوان": {
    "زغوان": ["زغوان المدينة", "حي النسيم"],
    "الفحص": ["الفحص المدينة", "حي الفتح"],
    "الناظور": ["الناظور المدينة", "حي النور"]
    }
    };

    function populateGovernorates() {
    const govSelect = document.getElementById('governorate');
    govSelect.innerHTML = '<option value="">-- اختر الولاية --</option>';
    Object.keys(tunisiaData).forEach(gov => {
    const option = document.createElement('option');
    option.value = gov;
    option.textContent = gov;
    govSelect.appendChild(option);
    });
    }

    function handleCountryChange() {
    const country = document.getElementById('country').value;
    const regionsDiv = document.getElementById('tunisia-regions');
    if (country === 'تونس') {
    regionsDiv.style.display = 'grid';
    populateGovernorates();
    } else {
    regionsDiv.style.display = 'none';
    clearSelect('governorate');
    clearSelect('delegation');
    clearSelect('sector');
    }
    }

    function handleGovernorateChange() {
    const gov = document.getElementById('governorate').value;
    const delSelect = document.getElementById('delegation');
    clearSelect('delegation');
    clearSelect('sector');

    if (gov && tunisiaData[gov]) {
    Object.keys(tunisiaData[gov]).forEach(del => {
    const option = document.createElement('option');
    option.value = del;
    option.textContent = del;
    delSelect.appendChild(option);
    });
    }
    }

    function handleDelegationChange() {
    const gov = document.getElementById('governorate').value;
    const del = document.getElementById('delegation').value;
    const secSelect = document.getElementById('sector');
    clearSelect('sector');

    if (gov && del && tunisiaData[gov][del]) {
    tunisiaData[gov][del].forEach(sec => {
    const option = document.createElement('option');
    option.value = sec;
    option.textContent = sec;
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

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
    handleCountryChange();
    });


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker;

    // Événement clic sur la carte
    map.on('click', function (e) {
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
    navigator.geolocation.getCurrentPosition(function (position) {
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
    }, function (error) {
    alert("Erreur de géolocalisation. Veuillez autoriser l'accès ou cliquer sur la carte.");
    });
    } else {
    alert("La géolocalisation n'est pas supportée par votre navigateur.");
    }
    }
    </script>

    <!-- Quill initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var notesTextarea = document.getElementById('notes');
            var quill = new Quill('#notes-editor', {
                theme: 'snow',
                direction: 'rtl',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['link'],
                        ['clean']
                    ]
                },
                placeholder: 'أدخل الملاحظات الإدارية والأمنية هنا...'
            });

            // Sync Quill → hidden textarea on every text change (real-time)
            quill.on('text-change', function () {
                notesTextarea.value = quill.root.innerHTML;
            });

            // Also sync on form submit as a safety net
            var form = document.getElementById('create-person-form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    notesTextarea.value = quill.root.innerHTML;
                });
            }
        });
    </script>

    <style>
        /* Quill editor styling to match yellow theme */
        #notes-editor {
            background: #ffffff;
            border: 1px solid #fde68a;
            border-radius: 0 0 0.5rem 0.5rem;
            color: #78350f;
            min-height: 150px;
        }

        .ql-toolbar {
            border: 1px solid #fde68a !important;
            border-radius: 0.5rem 0.5rem 0 0 !important;
            background: #fefce8;
        }

        .ql-container {
            border: 1px solid #fde68a !important;
            border-top: none !important;
            border-radius: 0 0 0.5rem 0.5rem !important;
            font-family: Tahoma, Arial, sans-serif;
            font-size: 14px;
        }

        .ql-editor {
            min-height: 120px;
            direction: rtl;
            text-align: right;
            color: #78350f;
        }

        .ql-editor.ql-blank::before {
            color: #b45309;
            opacity: 0.6;
            font-style: normal;
        }
    </style>
</x-app-layout>