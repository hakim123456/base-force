<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            قائمة الأشخاص
        </h2>
        @if(Auth::user()->isAdmin() || Auth::user()->isManager())
        <div>
            <a href="{{ route('personnes.create') }}"
                class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-light border border-transparent rounded-md font-bold text-sm text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة شخص جديد
            </a>
        </div>
        @endif
    </x-slot>

    <div x-data="datatable(@js($personnes))" class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 shadow-sm rounded-lg">
        <!-- Search and Filters -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="relative w-full md:w-96">
                <input type="text" x-model="search" @input="currentPage = 1" placeholder="بحث بالاسم، اللقب..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center space-x-2 space-x-reverse">
                <span class="text-sm text-gray-500">عرض</span>
                <select x-model="perPage" @change="currentPage = 1"
                    class="border-gray-300 rounded-md text-sm focus:ring-primary focus:border-primary">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-500">عناصر</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-right">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-bold text-sm">
                        <tr>
                            <th scope="col" @click="sortBy('id')"
                                class="px-6 py-4 cursor-pointer hover:bg-gray-100 select-none">
                                <div class="flex items-center">
                                    المعرف
                                </div>
                            </th>
                            <th scope="col" @click="sortBy('last_name')"
                                class="px-6 py-4 cursor-pointer hover:bg-gray-100 select-none">
                                <div class="flex items-center">اللقب</div>
                            </th>
                            <th scope="col" @click="sortBy('first_name')"
                                class="px-6 py-4 cursor-pointer hover:bg-gray-100 select-none">
                                <div class="flex items-center">الاسم</div>
                            </th>
                            <th scope="col" class="px-6 py-4">الهاتف</th>
                            <th scope="col" class="px-6 py-4 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        <template x-for="(item, index) in paginatedItems" :key="item.id">
                            <tr class="hover:bg-gray-50 transition-colors"
                                :class="{'bg-white': index % 2 === 0, 'bg-gray-50/30': index % 2 !== 0}">
                                <td class="px-6 py-4 font-bold text-gray-900" x-text="item.id"></td>
                                <td class="px-6 py-4" x-text="item.last_name"></td>
                                <td class="px-6 py-4" x-text="item.first_name"></td>
                                <td class="px-6 py-4" x-text="item.phone || '-'"></td>
                                <td class="px-6 py-4 flex items-center justify-center space-x-3 space-x-reverse">
                                
                                    <a :href="'/personnes/' + item.id" class="text-green-600 hover:text-green-800 transition-colors bg-green-50 hover:bg-green-100 rounded p-2" title="عرض التفاصيل">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                
                                    @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                                    <a :href="'/personnes/' + item.id + '/edit'"
                                        class="text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 hover:bg-blue-100 rounded p-2"
                                            title="تعديل">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                    </a>
                                    
                                    <form :action="'/personnes/' + item.id" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 rounded p-2"
                                            title="حذف">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        </template>
                        <tr x-show="paginatedItems.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">لا توجد بيانات</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
             <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-between items-center" x-show="totalPages > 1">
                <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1 border rounded" :class="{'opacity-50 cursor-not-allowed': currentPage === 1}">السابق</button>
                <span class="text-sm">صفحة <span x-text="currentPage"></span> من <span x-text="totalPages"></span></span>
                <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1 border rounded" :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}">التالي</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('datatable', (initialData) => ({
                items: initialData,
                search: '',
                sortCol: 'id',
                sortAsc: true,
                perPage: 10,
                currentPage: 1,

                get filteredItems() {
                    let result = this.items;
                    if (this.search !== '') {
                        result = result.filter(item => {
                            return Object.values(item).some(val =>
                                String(val).toLowerCase().includes(this.search.toLowerCase())
                            );
                        });
                    }
                    result = result.sort((a, b) => {
                        let modifier = this.sortAsc ? 1 : -1;
                        if (a[this.sortCol] < b[this.sortCol]) return -1 * modifier;
                        if (a[this.sortCol] > b[this.sortCol]) return 1 * modifier;
                        return 0;
                    });
                    return result;
                },

                get paginatedItems() {
                    let start = (this.currentPage - 1) * this.perPage;
                    let end = start + parseInt(this.perPage);
                    return this.filteredItems.slice(start, end);
                },

                get totalPages() {
                    return Math.max(1, Math.ceil(this.filteredItems.length / this.perPage));
                },

                sortBy(col) {
                    if (this.sortCol === col) {
                        this.sortAsc = !this.sortAsc;
                    } else {
                        this.sortCol = col;
                        this.sortAsc = true;
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                }
            }));
        });
    </script>
</x-app-layout>
