<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Business Permits
        $businessCategory = ServiceCategory::where('slug', 'business-permits')->first();
        $businessServices = [
            [
                'name' => 'New Business Permit',
                'description' => 'Application for a new business permit',
                'fee' => 1500.00,
                'processing_days' => 3,
                'requirements' => [
                    'Barangay Clearance',
                    'DTI/SEC Registration',
                    'Community Tax Certificate',
                    'Occupancy Permit',
                    'Fire Safety Inspection Certificate',
                    'Sanitary Permit'
                ]
            ],
            [
                'name' => 'Business Permit Renewal',
                'description' => 'Renewal of existing business permit',
                'fee' => 1000.00,
                'processing_days' => 2,
                'requirements' => [
                    'Previous Business Permit',
                    'Tax Clearance',
                    'Barangay Clearance',
                    'Fire Safety Inspection Certificate'
                ]
            ],
            [
                'name' => 'Change of Business Information',
                'description' => 'Update business information on existing permit',
                'fee' => 500.00,
                'processing_days' => 2,
                'requirements' => [
                    'Letter of Request',
                    'Current Business Permit',
                    'Supporting Documents for Changes'
                ]
            ]
        ];

        foreach ($businessServices as $service) {
            Service::create([
                'category_id' => $businessCategory->id,
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'fee' => $service['fee'],
                'processing_days' => $service['processing_days'],
                'requires_approval' => true,
                'requirements' => $service['requirements'],
            ]);
        }

        // Real Property Tax
        $propertyCategory = ServiceCategory::where('slug', 'real-property-tax')->first();
        $propertyServices = [
            [
                'name' => 'Real Property Tax Payment',
                'description' => 'Payment of real property taxes',
                'fee' => 0.00, // Fee depends on property value
                'processing_days' => 1,
                'requirements' => [
                    'Tax Declaration',
                    'Previous Receipt (for continuing payments)'
                ]
            ],
            [
                'name' => 'Tax Clearance',
                'description' => 'Get tax clearance certificate for real property',
                'fee' => 100.00,
                'processing_days' => 1,
                'requirements' => [
                    'Proof of Tax Payment',
                    'Valid ID'
                ]
            ]
        ];

        foreach ($propertyServices as $service) {
            Service::create([
                'category_id' => $propertyCategory->id,
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'fee' => $service['fee'],
                'processing_days' => $service['processing_days'],
                'requires_approval' => true,
                'requirements' => $service['requirements'],
            ]);
        }

        // Local Civil Registry
        $registryCategory = ServiceCategory::where('slug', 'local-civil-registry')->first();
        $registryServices = [
            [
                'name' => 'Birth Certificate',
                'description' => 'Request for birth certificate copy',
                'fee' => 150.00,
                'processing_days' => 1,
                'requirements' => [
                    'Valid ID',
                    'Request Form'
                ]
            ],
            [
                'name' => 'Marriage Certificate',
                'description' => 'Request for marriage certificate copy',
                'fee' => 150.00,
                'processing_days' => 1,
                'requirements' => [
                    'Valid ID',
                    'Request Form'
                ]
            ],
            [
                'name' => 'Death Certificate',
                'description' => 'Request for death certificate copy',
                'fee' => 150.00,
                'processing_days' => 1,
                'requirements' => [
                    'Valid ID',
                    'Request Form'
                ]
            ]
        ];

        foreach ($registryServices as $service) {
            Service::create([
                'category_id' => $registryCategory->id,
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'fee' => $service['fee'],
                'processing_days' => $service['processing_days'],
                'requires_approval' => false,
                'requirements' => $service['requirements'],
            ]);
        }

        // Health Certificate
        $healthCategory = ServiceCategory::where('slug', 'occupation-permit-health')->first();

        if (!$healthCategory) {
            $healthCategory = ServiceCategory::create([
                'name' => 'Occupation Permit Health',
                'slug' => 'occupation-permit-health',
            ]);
        }

        $healthServices = [
            [
                'name' => 'Health Certificate',
                'description' => 'Request for health certificate',
                'fee' => 200.00,
                'processing_days' => 2,
                'requirements' => [
                    'Medical Examination Results',
                    'Valid ID',
                    'Chest X-ray',
                    'Stool and Urine Sample Results'
                ]
            ]
        ];

        foreach ($healthServices as $service) {
            Service::create([
                'category_id' => $healthCategory->id,
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'fee' => $service['fee'],
                'processing_days' => $service['processing_days'],
                'requires_approval' => true,
                'requirements' => $service['requirements'],
            ]);
        }
    }
}