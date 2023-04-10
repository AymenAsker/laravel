<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name' =>  'نقل',
            'category_icon' =>  'mdi:bank-transfer',
        ]);
        Category::create([
            'category_name' =>  'طبية',
            'category_icon' =>  'material-symbols:medical-information',
        ]);
        Category::create([
            'category_name' =>  'بناء و مقاولات',
            'category_icon' =>  'mingcute:building-4-line',
        ]);
        Category::create([
            'category_name' =>  'اكل',
            'category_icon' =>  'maki:restaurant-pizza',
        ]);
        Category::create([
            'category_name' =>  'صناعة',
            'category_icon' =>  'maki:industry',
        ]);
        Category::create([
            'category_name' =>  'عقارات',
            'category_icon' =>  'mdi:cart-sale',
        ]);
        Category::create([
            'category_name' =>  'التعليم والتدريب',
            'category_icon' =>  'cil:education',
        ]);
    }
}
