<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreServiceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $service = $this->route('service');
        $rules = [
            'form_data.name' => 'required|string|max:255',
            'form_data.email' => 'required|email|max:255',
            'form_data.mobile' => 'required|string|max:20',
            'form_data.address' => 'required|string|max:255',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'terms' => 'required|accepted',
        ];
        
        // Add service-specific validation rules
        if (Str::contains($service->slug, 'business-permit')) {
            $rules = array_merge($rules, [
                'form_data.business_name' => 'required|string|max:255',
                'form_data.business_type' => 'required|string|max:255',
                'form_data.business_address' => 'required|string|max:255',
                'form_data.business_nature' => 'required|string|max:255',
                'form_data.business_area' => 'required|numeric|min:0',
                'form_data.employees_count' => 'required|integer|min:1',
                'form_data.capitalization' => 'required|numeric|min:0',
            ]);
            
            if ($service->slug === 'business-permit-renewal') {
                $rules = array_merge($rules, [
                    'form_data.previous_permit' => 'required|string|max:255',
                    'form_data.expiry_date' => 'required|date',
                ]);
            }
            
            if ($service->slug === 'change-of-business-information') {
                $rules = array_merge($rules, [
                    'form_data.update_fields' => 'required|array|min:1',
                    'form_data.reason' => 'required|string|max:500',
                ]);
            }
        } elseif (Str::contains($service->slug, 'property-tax')) {
            $rules = array_merge($rules, [
                'form_data.tax_declaration_no' => 'required|string|max:255',
                'form_data.property_type' => 'required|string|max:255',
                'form_data.property_address' => 'required|string|max:255',
                'form_data.property_owner' => 'required|string|max:255',
                'form_data.owner_relation' => 'required|string|max:255',
            ]);
            
            if ($service->slug === 'real-property-tax-payment') {
                $rules = array_merge($rules, [
                    'form_data.payment_year' => 'required|integer|min:' . (date('Y') - 5) . '|max:' . date('Y'),
                    'form_data.payment_quarter' => 'required|string|max:255',
                ]);
            }
            
            if ($service->slug === 'tax-clearance') {
                $rules = array_merge($rules, [
                    'form_data.clearance_purpose' => 'required|string|max:255',
                ]);
                
                // If clearance_purpose is 'other', require other_purpose
                if ($this->input('form_data.clearance_purpose') === 'other') {
                    $rules['form_data.other_purpose'] = 'required|string|max:255';
                }
            }
        } elseif (in_array($service->slug, ['birth-certificate', 'marriage-certificate', 'death-certificate'])) {
            $rules = array_merge($rules, [
                'form_data.purpose' => 'required|string|max:255',
                'form_data.requestor_relation' => 'required|string|max:255',
                'form_data.num_copies' => 'required|integer|min:1',
            ]);
            
            // If purpose is 'other', require other_purpose
            if ($this->input('form_data.purpose') === 'other') {
                $rules['form_data.other_purpose'] = 'required|string|max:255';
            }
            
            if ($service->slug === 'birth-certificate') {
                $rules = array_merge($rules, [
                    'form_data.person_name' => 'required|string|max:255',
                    'form_data.date' => 'required|date',
                    'form_data.place' => 'required|string|max:255',
                    'form_data.sex' => 'required|string|in:male,female',
                    'form_data.mothers_name' => 'required|string|max:255',
                ]);
            } elseif ($service->slug === 'marriage-certificate') {
                $rules = array_merge($rules, [
                    'form_data.husband_name' => 'required|string|max:255',
                    'form_data.husband_birthdate' => 'required|date',
                    'form_data.wife_name' => 'required|string|max:255',
                    'form_data.wife_birthdate' => 'required|date',
                    'form_data.date' => 'required|date',
                    'form_data.place' => 'required|string|max:255',
                ]);
            } elseif ($service->slug === 'death-certificate') {
                $rules = array_merge($rules, [
                    'form_data.person_name' => 'required|string|max:255',
                    'form_data.sex' => 'required|string|in:male,female',
                    'form_data.date' => 'required|date',
                    'form_data.place' => 'required|string|max:255',
                    'form_data.date_of_birth' => 'required|date|before:form_data.date',
                    'form_data.civil_status' => 'required|string|max:255',
                ]);
            }
        } elseif ($service->slug === 'health-certificate') {
            $rules = array_merge($rules, [
                'form_data.occupation' => 'required|string|max:255',
                'form_data.employer' => 'required|string|max:255',
                'form_data.employer_address' => 'required|string|max:255',
                'form_data.certificate_type' => 'required|string|max:255',
                'form_data.birthdate' => 'required|date',
                'form_data.civil_status' => 'required|string|max:255',
                'form_data.sex' => 'required|string|in:male,female',
            ]);
        }
        
        return $rules;
    }
    
    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form_data.name' => 'full name',
            'form_data.email' => 'email address',
            'form_data.mobile' => 'mobile number',
            'form_data.address' => 'address',
            'form_data.business_name' => 'business name',
            'form_data.business_type' => 'business type',
            'form_data.business_address' => 'business address',
            'form_data.business_nature' => 'nature of business',
            'form_data.business_area' => 'floor area',
            'form_data.employees_count' => 'number of employees',
            'form_data.capitalization' => 'capitalization',
            'form_data.previous_permit' => 'previous permit number',
            'form_data.expiry_date' => 'permit expiry date',
            'form_data.update_fields' => 'fields to update',
            'form_data.reason' => 'reason for update',
            'form_data.tax_declaration_no' => 'tax declaration number',
            'form_data.property_type' => 'property type',
            'form_data.property_address' => 'property address',
            'form_data.property_owner' => 'property owner',
            'form_data.owner_relation' => 'relation to owner',
            'form_data.payment_year' => 'payment year',
            'form_data.payment_quarter' => 'payment quarter',
            'form_data.clearance_purpose' => 'purpose of tax clearance',
            'form_data.other_purpose' => 'other purpose',
            'form_data.purpose' => 'purpose',
            'form_data.requestor_relation' => 'requestor relation',
            'form_data.num_copies' => 'number of copies',
            'form_data.person_name' => 'full name',
            'form_data.date' => 'date',
            'form_data.place' => 'place',
            'form_data.sex' => 'sex',
            'form_data.mothers_name' => 'mother\'s name',
            'form_data.husband_name' => 'husband\'s name',
            'form_data.husband_birthdate' => 'husband\'s birthdate',
            'form_data.wife_name' => 'wife\'s name',
            'form_data.wife_birthdate' => 'wife\'s birthdate',
            'form_data.date_of_birth' => 'date of birth',
            'form_data.civil_status' => 'civil status',
            'form_data.occupation' => 'occupation',
            'form_data.employer' => 'employer/establishment',
            'form_data.employer_address' => 'employer/establishment address',
            'form_data.certificate_type' => 'certificate type',
            'form_data.birthdate' => 'date of birth',
        ];
    }
}