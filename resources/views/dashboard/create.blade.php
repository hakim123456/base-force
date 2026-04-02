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

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        <form action="{{ route('dashboard.index') }}" method="POST">
            @csrf
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Right Column (Personal Details) -->
                <div class="space-y-5">
                    <h3 class="text-lg font-bold text-primary border-b pb-2">المعلومات الشخصية</h3>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الاسم</label>
                        <input type="text" name="first_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل الاسم">
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
                        <label class="block text-sm font-bold text-gray-700 mb-1">اسم الأم</label>
                        <input type="text" name="mother_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="أدخل اسم الأم">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">تاريخ الولادة</label>
                        <input type="date" name="birth_date" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm">
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
                        <textarea name="social_media" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="روابط أو حسابات التواصل"></textarea>
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
                        <input type="text" name="current_level" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="المستوى الأكاديمي أو التعليمي">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">مجال العمل السابق والحالي</label>
                        <textarea name="work_history" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تفاصيل الأعمال السابقة والحالية"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المجال الديني</label>
                        <input type="text" name="religious_field" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="التوجه أو النشاط الديني">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المشاركة في الأعمال الدعوية</label>
                        <input type="text" name="dawah_participation" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary text-sm" placeholder="تفاصيل المشاركات">
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
</x-app-layout>
