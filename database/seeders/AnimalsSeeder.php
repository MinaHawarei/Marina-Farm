<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            ['animal_code' => 'B001', 'type' => 'Buffalo', 'breed' => 'طبيعي', 'age' => 2, 'weight' => 550, 'pen_id' => 'رضاعة', 'health_status' => 'جيدة', 'gender' => 'انثي', 'origin' => 'O001', 'arrival_date' => now(), 'status' => 'pregnant', 'insemination_type' => 'طبيعي', 'created_by' => 1],
            ['animal_code' => 'C002', 'type' => 'Cow', 'breed' => 'صماعي', 'age' => 3, 'weight' => 450, 'pen_id' => 'فطام', 'health_status' => 'متوسطة', 'gender' => 'انثي', 'origin' => 'O002', 'arrival_date' => now(), 'status' => 'calf', 'insemination_type' => 'صناعي', 'created_by' => 1],
            ['animal_code' => 'CH003', 'type' => 'Chicken', 'breed' => 'طبيعي', 'age' => 1, 'weight' => 2.5, 'pen_id' => 'دجاج', 'health_status' => 'جيدة', 'gender' => 'ذكر', 'origin' => 'O003', 'arrival_date' => now(), 'status' => 'fattening', 'insemination_type' => 'غير ملقحة', 'created_by' => 1],
            ['animal_code' => 'B004', 'type' => 'Buffalo', 'breed' => 'طبيعي', 'age' => 4, 'weight' => 600, 'pen_id' => 'حلاب', 'health_status' => 'جيدة', 'gender' => 'انثي', 'origin' => 'O004', 'arrival_date' => now(), 'status' => 'dairy', 'insemination_type' => 'طبيعي', 'created_by' => 1],
            // أضف المزيد من الحيوانات هنا
        ];

        // تكرار إنشاء بيانات وهمية للوصول إلى 20 نموذجًا
        for ($i = 5; $i <= 20; $i++) {
            $animals[] = [
                'animal_code' => 'B' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'type' => 'Buffalo',
                'breed' => 'طبيعي',
                'age' => random_int(1, 5),
                'weight' => random_int(400, 700),
                'pen_id' => 'حلوب',
                'health_status' => 'جيدة',
                'gender' => 'انثي',
                'origin' => 'O' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'arrival_date' => now(),
                'status' => 'pregnant',
                'insemination_type' => 'طبيعي',
                'created_by' => 1,
            ];
        }

        // إدخال البيانات إلى جدول animals
        DB::table('animals')->insert($animals);
    }
}
