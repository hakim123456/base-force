<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Person;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['أحمد', 'محمد', 'عمر', 'علي', 'خالد', 'عبدالله', 'محمود', 'يوسف', 'حسن', 'حسين', 'إبراهيم', 'طارق', 'ياسين', 'وليد', 'سمير', 'مروان', 'زياد', 'أيمن', 'صلاح', 'حاتم'];
        $fathers = ['محمد', 'صالح', 'عبدالرحمن', 'حسن', 'علي', 'عمر', 'عبدالكريم', 'سالم', 'أحمد', 'مصطفى', 'طاهر', 'كمال', 'المنجي', 'عبدالقادر'];
        $surnames = ['الميساوي', 'الخضراوي', 'القرمازي', 'البولعابي', 'الفريضي', 'النصري', 'الهلالي', 'الصالحي', 'السليمي', 'المحمودي', 'العجلاني', 'الدربالي'];
        $addresses = ['حي النور', 'حي الزهور', 'حي الكرمة', 'وسط المدينة', 'حي المنار', 'حي البساتين', 'Ezzouhour', 'Al Karma', 'Ennour'];
        $jobs = ['فلاح', 'عامل يومي', 'تاجر', 'عاطل عن العمل', 'سائق', 'موظف', 'حرفي', 'ميكانيكي'];
        $education = ['ابتدائي', 'إعدادي', 'ثانوي', 'بدون', 'تكوين مهني'];

        $records = [];
        for ($i = 0; $i < 100; $i++) {
            // Randomly scatter around Kasserine
            // Kasserine base lat: 35.1676, lng: 8.8365
            // Offset roughly -0.1 to +0.1 (~10km)
            $latOffset = (mt_rand(-1000, 1000) / 10000); 
            $lngOffset = (mt_rand(-1000, 1000) / 10000);
            
            $lat = round(35.1676 + $latOffset, 7);
            $lng = round(8.8365 + $lngOffset, 7);

            $records[] = [
                'identifier' => '10' . rand(100000, 999999),
                'first_name' => $names[array_rand($names)],
                'father_name' => $fathers[array_rand($fathers)],
                'grandfather_name' => $fathers[array_rand($fathers)],
                'last_name' => $surnames[array_rand($surnames)],
                'dob' => rand(1, 28) . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . rand(1970, 2000),
                'address' => $addresses[array_rand($addresses)] . '، القصرين',
                'job' => $jobs[array_rand($jobs)],
                'phone' => '216' . rand(20000000, 99999999),
                'social' => 'Facebook, TikTok',
                'upbringing' => 'نشأ في مدينة القصرين',
                'education' => $education[array_rand($education)],
                'level' => 'متوسط',
                'work_history' => 'أعمال حرة ومتقطعة',
                'religion' => 'مسلم',
                'dawah' => 'غير محدد',
                'books' => 'لا يوجد',
                'travels' => 'لم يسافر خارج ولاية القصرين كثيراً',
                'friends' => 'علاقات محلية في الحي',
                'notes' => 'تم إنشاء هذا السجل تلقائياً لتجربة الخرائط الجغرافية في منطقة القصرين.',
                'latitude' => $lat,
                'longitude' => $lng,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Insert in chunks of 50
        foreach (array_chunk($records, 50) as $chunk) {
            Person::insert($chunk);
        }
    }
}
