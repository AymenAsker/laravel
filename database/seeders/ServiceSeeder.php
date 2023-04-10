<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'تاكسي',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'حافلة',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'صهريج مياه',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'طانطة',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'بورتر',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'تندرا',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'شكوانطة',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'رافعت سيارات',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  1,
            'service_name' =>  'شاحنة شفط',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  2,
            'service_name' =>  'صيدليات',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  2,
            'service_name' =>  'مصحات',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  2,
            'service_name' =>  'اسعاف',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  4,
            'service_name' =>  'مطاعم',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  4,
            'service_name' =>  'منزلي',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  3,
            'service_name' =>  'سباكة',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  3,
            'service_name' =>  'زواق',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  3,
            'service_name' =>  'حدادة - لحام',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  3,
            'service_name' =>  'نجارة وصيانة أثاث',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  6,
            'service_name' =>  'منازل للبيع',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  6,
            'service_name' =>  'أراضي للبيع',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  6,
            'service_name' =>  'منازل للايجار',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
        Service::create([
            'category_id' =>  7,
            'service_name' =>  'دروس خصوصية',
            'service_icon' =>  'mdi:bank-transfer',
        ]);

        Service::create([
            'category_id' =>  7,
            'service_name' =>  'روضات',
            'service_icon' =>  'mdi:bank-transfer',
        ]);
    }
}
