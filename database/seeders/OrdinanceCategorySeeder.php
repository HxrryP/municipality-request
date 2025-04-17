<?php

namespace Database\Seeders;

use App\Models\OrdinanceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdinanceCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Administrative Ordinances',
                'description' => 'Ordinances related to administrative matters.'
            ],
            [
                'name' => 'Public Safety and Order',
                'description' => 'Ordinances related to public safety and order.'
            ],
            [
                'name' => 'Zoning and Land Use',
                'description' => 'Ordinances related to zoning and land use.'
            ],
            [
                'name' => 'Business and Licensing',
                'description' => 'Ordinances related to business operations and licensing.'
            ],
            [
                'name' => 'Education and Cultural',
                'description' => 'Ordinances related to education and cultural matters.'
            ],
        ];

        foreach ($categories as $category) {
            OrdinanceCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}