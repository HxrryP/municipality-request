<?php

namespace Database\Seeders;

use App\Models\Ordinance;
use App\Models\OrdinanceCategory;
use Illuminate\Database\Seeder;

class OrdinanceSeeder extends Seeder
{
    public function run()
    {
        // Sample ordinances for each category
        $ordinances = [
            // Administrative
            [
                'category_slug' => 'administrative-ordinances',
                'ordinances' => [
                    [
                        'title' => 'Municipal Administrative Code',
                        'content' => 'This ordinance establishes the administrative code for the Municipality of Anilao.',
                        'ordinance_number' => '2024-001',
                        'date_approved' => '2024-01-15',
                    ],
                ]
            ],
            // Public Safety
            [
                'category_slug' => 'public-safety-and-order',
                'ordinances' => [
                    [
                        'title' => 'Curfew Ordinance',
                        'content' => 'This ordinance establishes a curfew for minors in the Municipality of Anilao.',
                        'ordinance_number' => '2024-002',
                        'date_approved' => '2024-01-20',
                    ],
                    [
                        'title' => 'Anti-Smoking Ordinance',
                        'content' => 'This ordinance prohibits smoking in public places in the Municipality of Anilao.',
                        'ordinance_number' => '2024-003',
                        'date_approved' => '2024-02-05',
                    ],
                ]
            ],
            // Zoning
            [
                'category_slug' => 'zoning-and-land-use',
                'ordinances' => [
                    [
                        'title' => 'Zoning Ordinance',
                        'content' => 'This ordinance establishes zoning regulations for the Municipality of Anilao.',
                        'ordinance_number' => '2024-004',
                        'date_approved' => '2024-02-10',
                    ],
                ]
            ],
            // Business
            [
                'category_slug' => 'business-and-licensing',
                'ordinances' => [
                    [
                        'title' => 'Business Tax Ordinance',
                        'content' => 'This ordinance establishes business tax rates for the Municipality of Anilao.',
                        'ordinance_number' => '2024-005',
                        'date_approved' => '2024-02-15',
                    ],
                ]
            ],
            // Education
            [
                'category_slug' => 'education-and-cultural',
                'ordinances' => [
                    [
                        'title' => 'Educational Scholarship Ordinance',
                        'content' => 'This ordinance establishes scholarship programs for deserving students in Anilao.',
                        'ordinance_number' => '2024-006',
                        'date_approved' => '2024-03-01',
                    ],
                ]
            ],
        ];

        foreach ($ordinances as $categoryData) {
            $category = OrdinanceCategory::where('slug', $categoryData['category_slug'])->first();
            
            foreach ($categoryData['ordinances'] as $ordinance) {
                Ordinance::create([
                    'category_id' => $category->id,
                    'title' => $ordinance['title'],
                    'content' => $ordinance['content'],
                    'ordinance_number' => $ordinance['ordinance_number'],
                    'date_approved' => $ordinance['date_approved'],
                ]);
            }
        }
    }
}