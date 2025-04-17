<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Business Permits',
                'description' => 'Services related to business permits and licenses.'
            ],
            [
                'name' => 'Real Property Tax',
                'description' => 'Services related to real property tax payments and clearances.'
            ],
            [
                'name' => 'Local Civil Registry',
                'description' => 'Services for birth, marriage, and death certificates.'
            ],
            [
                'name' => 'Occupation Permit/Health',
                'description' => 'Services related to health certificates and occupational permits.'
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}