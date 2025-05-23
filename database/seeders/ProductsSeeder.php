<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */


    public function run(): void
    {

         // استخدم ID صالح لمستخدم موجود في جدول users
         $userId = 1; // غيّره حسب الحاجة

         $products = [
             [
                 'product_name' => 'Buffalo Milk',
                 'category' => 'Milk',
                 'unit' => 0,
                 'storage_location' => 'Farm',
                 'created_by' => $userId,
             ],
             [
                 'product_name' => 'Cow Milk',
                 'category' => 'Milk',
                 'unit' => 0,
                 'storage_location' => 'Farm',
                 'created_by' => $userId,
             ],
             [
                 'product_name' => 'eggs',
                 'category' => 'eggs',
                 'unit' => 0,
                 'storage_location' => 'Farm',
                 'created_by' => $userId,
             ],

             [
                 'product_name' => 'Buffalo Milk',
                 'category' => 'Milk',
                 'unit' => 0,
                 'storage_location' => 'Sale Point',
                 'created_by' => $userId,
             ],
             [
                 'product_name' => 'Cow Milk',
                 'category' => 'Milk',
                 'unit' => 0,
                 'storage_location' => 'Sale Point',
                 'created_by' => $userId,
             ],
             [
                 'product_name' => 'eggs',
                 'category' => 'eggs',
                 'unit' => 0,
                 'storage_location' => 'Sale Point',
                 'created_by' => $userId,
             ],

             [
                'product_name' => 'dates',
                'category' => 'dates',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'dates',
                'category' => 'dates',
                'unit' => 0,
                'storage_location' => 'Sale Point',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'clover',
                'category' => 'clover',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'hay',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'corn',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'gasoline',
                'category' => 'gasoline',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
             [
                'product_name' => 'gas',
                'category' => 'gas',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'soybean',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'soybean_hulls',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'bran',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'silage',
                'category' => 'feed',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'ghee',
                'category' => 'ghee',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'ghee',
                'category' => 'ghee',
                'unit' => 0,
                'storage_location' => 'Sale Point',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'Cheese',
                'category' => 'Cheese',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'Cheese',
                'category' => 'Cheese',
                'unit' => 0,
                'storage_location' => 'Sale Point',
                'created_by' => $userId,
            ],
            [
                'product_name' => 'fertilizer',
                'category' => 'fertilizer',
                'unit' => 0,
                'storage_location' => 'Farm',
                'created_by' => $userId,
            ],
         ];

         foreach ($products as $product) {
            Product::create($product);
         }

    }
}
