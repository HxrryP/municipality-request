@props(['service'])

@php
    $formType = '';
    
    if (Str::contains($service->slug, 'business-permit')) {
        $formType = 'business-permit';
    } elseif (Str::contains($service->slug, 'property-tax')) {
        $formType = 'property-tax';
    } elseif (in_array($service->slug, ['birth-certificate', 'marriage-certificate', 'death-certificate'])) {
        $formType = 'certificate';
    } elseif (Str::contains($service->slug, 'health-certificate')) {
        $formType = 'health-certificate';
    }
@endphp

<!-- Business Permit Forms -->
@if($formType === 'business-permit')
    <div class="mb-6 border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Business Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                <input type="text" name="form_data[business_name]" id="business_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="business_type" class="block text-sm font-medium text-gray-700">Business Type</label>
                <select name="form_data[business_type]" id="business_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Business Type</option>
                    <option value="sole_proprietorship">Sole Proprietorship</option>
                    <option value="partnership">Partnership</option>
                    <option value="corporation">Corporation</option>
                    <option value="cooperative">Cooperative</option>
                </select>
            </div>

            <div class="col-span-2">
                <label for="business_address" class="block text-sm font-medium text-gray-700">Business Address</label>
                <input type="text" name="form_data[business_address]" id="business_address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="business_nature" class="block text-sm font-medium text-gray-700">Nature of Business</label>
                <input type="text" name="form_data[business_nature]" id="business_nature" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="business_area" class="block text-sm font-medium text-gray-700">Floor Area (sqm)</label>
                <input type="number" name="form_data[business_area]" id="business_area" min="0" step="0.01" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="employees_count" class="block text-sm font-medium text-gray-700">Number of Employees</label>
                <input type="number" name="form_data[employees_count]" id="employees_count" min="1" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="capitalization" class="block text-sm font-medium text-gray-700">Capital/Investment (₱)</label>
                <input type="number" name="form_data[capitalization]" id="capitalization" min="0" step="0.01" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
        </div>

        @if($service->slug === 'business-permit-renewal')
            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-800 mb-3">Previous Permit Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="previous_permit" class="block text-sm font-medium text-gray-700">Previous Permit Number</label>
                        <input type="text" name="form_data[previous_permit]" id="previous_permit" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date of Previous Permit</label>
                        <input type="date" name="form_data[expiry_date]" id="expiry_date" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>
            </div>
        @endif

        @if($service->slug === 'change-of-business-information')
            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-800 mb-3">Information to Update</h4>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="update_name" name="form_data[update_fields][]" value="business_name" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="update_name" class="font-medium text-gray-700">Business Name</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="update_address" name="form_data[update_fields][]" value="business_address" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="update_address" class="font-medium text-gray-700">Business Address</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="update_nature" name="form_data[update_fields][]" value="business_nature" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="update_nature" class="font-medium text-gray-700">Nature of Business</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="update_area" name="form_data[update_fields][]" value="business_area" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="update_area" class="font-medium text-gray-700">Floor Area</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Update</label>
                        <textarea name="form_data[reason]" id="reason" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                    </div>
                </div>
            </div>
        @endif
    </div>

<!-- Property Tax Forms -->
@elseif($formType === 'property-tax')
    <div class="mb-6 border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Property Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tax_declaration_no" class="block text-sm font-medium text-gray-700">Tax Declaration Number</label>
                <input type="text" name="form_data[tax_declaration_no]" id="tax_declaration_no" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="property_type" class="block text-sm font-medium text-gray-700">Property Type</label>
                <select name="form_data[property_type]" id="property_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Property Type</option>
                    <option value="residential">Residential</option>
                    <option value="agricultural">Agricultural</option>
                    <option value="commercial">Commercial</option>
                    <option value="industrial">Industrial</option>
                </select>
            </div>

            <div class="col-span-2">
                <label for="property_address" class="block text-sm font-medium text-gray-700">Property Address</label>
                <input type="text" name="form_data[property_address]" id="property_address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="property_owner" class="block text-sm font-medium text-gray-700">Property Owner's Name</label>
                <input type="text" name="form_data[property_owner]" id="property_owner" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="owner_relation" class="block text-sm font-medium text-gray-700">Requestor's Relation to Owner</label>
                <select name="form_data[owner_relation]" id="owner_relation" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Relation</option>
                    <option value="self">Self (I am the owner)</option>
                    <option value="authorized_representative">Authorized Representative</option>
                    <option value="relative">Relative</option>
                    <option value="tenant">Tenant</option>
                    <option value="other">Other</option>
                </select>
            </div>

            @if($service->slug === 'real-property-tax-payment')
                <div>
                    <label for="payment_year" class="block text-sm font-medium text-gray-700">Payment for Year</label>
                    <select name="form_data[payment_year]" id="payment_year" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select Year</option>
                        @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="payment_quarter" class="block text-sm font-medium text-gray-700">Payment for Quarter</label>
                    <select name="form_data[payment_quarter]" id="payment_quarter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select Quarter</option>
                        <option value="full_year">Full Year</option>
                        <option value="q1">Q1 - First Quarter</option>
                        <option value="q2">Q2 - Second Quarter</option>
                        <option value="q3">Q3 - Third Quarter</option>
                        <option value="q4">Q4 - Fourth Quarter</option>
                    </select>
                </div>
            @endif

            @if($service->slug === 'tax-clearance')
                <div>
                    <label for="clearance_purpose" class="block text-sm font-medium text-gray-700">Purpose of Tax Clearance</label>
                    <select name="form_data[clearance_purpose]" id="clearance_purpose" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select Purpose</option>
                        <option value="sale">Sale/Transfer of Property</option>
                        <option value="loan">Loan Application</option>
                        <option value="building_permit">Building Permit Application</option>
                        <option value="requirement">Legal Requirement</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div id="other_purpose_field" style="display: none;">
                    <label for="other_purpose" class="block text-sm font-medium text-gray-700">Specify Other Purpose</label>
                    <input type="text" name="form_data[other_purpose]" id="other_purpose" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            @endif
        </div>
    </div>

<!-- Certificate Forms (Birth, Marriage, Death) -->
@elseif($formType === 'certificate')
    <div class="mb-6 border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Certificate Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($service->slug === 'birth-certificate')
                <div>
                    <label for="person_name" class="block text-sm font-medium text-gray-700">Full Name of Person</label>
                    <input type="text" name="form_data[person_name]" id="person_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="form_data[date]" id="date_of_birth" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Place of Birth</label>
                    <input type="text" name="form_data[place]" id="place_of_birth" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="City/Municipality, Province" required>
                </div>

                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                    <select name="form_data[sex]" id="sex" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="mothers_name" class="block text-sm font-medium text-gray-700">Mother's Full Maiden Name</label>
                    <input type="text" name="form_data[mothers_name]" id="mothers_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="fathers_name" class="block text-sm font-medium text-gray-700">Father's Full Name</label>
                    <input type="text" name="form_data[fathers_name]" id="fathers_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <p class="mt-1 text-xs text-gray-500">Leave blank if not applicable</p>
                </div>
            
            @elseif($service->slug === 'marriage-certificate')
                <div class="col-span-2">
                    <h4 class="text-md font-medium text-gray-800 mb-3">Husband's Information</h4>
                </div>

                <div>
                    <label for="husband_name" class="block text-sm font-medium text-gray-700">Husband's Full Name</label>
                    <input type="text" name="form_data[husband_name]" id="husband_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="husband_birthdate" class="block text-sm font-medium text-gray-700">Husband's Birthdate</label>
                    <input type="date" name="form_data[husband_birthdate]" id="husband_birthdate" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div class="col-span-2">
                    <h4 class="text-md font-medium text-gray-800 mb-3 mt-4">Wife's Information</h4>
                </div>

                <div>
                    <label for="wife_name" class="block text-sm font-medium text-gray-700">Wife's Full Maiden Name</label>
                    <input type="text" name="form_data[wife_name]" id="wife_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="wife_birthdate" class="block text-sm font-medium text-gray-700">Wife's Birthdate</label>
                    <input type="date" name="form_data[wife_birthdate]" id="wife_birthdate" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div class="col-span-2">
                    <h4 class="text-md font-medium text-gray-800 mb-3 mt-4">Marriage Details</h4>
                </div>

                <div>
                    <label for="date_of_marriage" class="block text-sm font-medium text-gray-700">Date of Marriage</label>
                    <input type="date" name="form_data[date]" id="date_of_marriage" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="place_of_marriage" class="block text-sm font-medium text-gray-700">Place of Marriage</label>
                    <input type="text" name="form_data[place]" id="place_of_marriage" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="City/Municipality, Province" required>
                </div>
            
            @elseif($service->slug === 'death-certificate')
                <div>
                    <label for="deceased_name" class="block text-sm font-medium text-gray-700">Deceased Person's Full Name</label>
                    <input type="text" name="form_data[person_name]" id="deceased_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                    <select name="form_data[sex]" id="sex" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="date_of_death" class="block text-sm font-medium text-gray-700">Date of Death</label>
                    <input type="date" name="form_data[date]" id="date_of_death" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="place_of_death" class="block text-sm font-medium text-gray-700">Place of Death</label>
                    <input type="text" name="form_data[place]" id="place_of_death" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="City/Municipality, Province" required>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="form_data[date_of_birth]" id="date_of_birth" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>

                <div>
                    <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                    <select name="form_data[civil_status]" id="civil_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="">Select Status</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="widowed">Widowed</option>
                        <option value="divorced">Legally Separated/Divorced</option>
                    </select>
                </div>
            @endif

            <!-- Common fields for all certificate types -->
            <div class="col-span-2">
                <h4 class="text-md font-medium text-gray-800 mb-3 mt-4">Request Details</h4>
            </div>

            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose of Request</label>
                <select name="form_data[purpose]" id="purpose" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Purpose</option>
                    <option value="passport">Passport Application</option>
                    <option value="school">School Requirement</option>
                    <option value="employment">Employment</option>
                    <option value="claim">Claim Benefits/Insurance</option>
                    <option value="legal">Legal Purposes</option>
                    <option value="travel">Travel</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div id="other_purpose_field" style="display: none;">
                <label for="other_purpose" class="block text-sm font-medium text-gray-700">Specify Other Purpose</label>
                <input type="text" name="form_data[other_purpose]" id="other_purpose" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="requestor_relation" class="block text-sm font-medium text-gray-700">Requestor's Relation</label>
                <select name="form_data[requestor_relation]" id="requestor_relation" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Relation</option>
                    <option value="self">Self</option>
                    <option value="parent">Parent</option>
                    <option value="spouse">Spouse</option>
                    <option value="child">Child</option>
                    <option value="authorized_representative">Authorized Representative</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="num_copies" class="block text-sm font-medium text-gray-700">Number of Copies</label>
                <input type="number" name="form_data[num_copies]" id="num_copies" min="1" value="1" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
        </div>
    </div>

<!-- Health Certificate Forms -->
@elseif($formType === 'health-certificate')
    <div class="mb-6 border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Health Certificate Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="occupation" class="block text-sm font-medium text-gray-700">Occupation</label>
                <input type="text" name="form_data[occupation]" id="occupation" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="employer" class="block text-sm font-medium text-gray-700">Employer/Establishment</label>
                <input type="text" name="form_data[employer]" id="employer" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="employer_address" class="block text-sm font-medium text-gray-700">Employer/Establishment Address</label>
                <input type="text" name="form_data[employer_address]" id="employer_address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="certificate_type" class="block text-sm font-medium text-gray-700">Certificate Type</label>
                <select name="form_data[certificate_type]" id="certificate_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Type</option>
                    <option value="food_handler">Food Handler</option>
                    <option value="food_establishment">Food Establishment</option>
                    <option value="massage_spa">Massage/Spa</option>
                    <option value="salon_parlor">Beauty Salon/Parlor</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="birthdate" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="form_data[birthdate]" id="birthdate" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                <select name="form_data[civil_status]" id="civil_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="widowed">Widowed</option>
                    <option value="divorced">Legally Separated/Divorced</option>
                </select>
            </div>

            <div>
                <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                <select name="form_data[sex]" id="sex" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="col-span-2">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History (if any)</label>
                <textarea name="form_data[medical_history]" id="medical_history" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
        </div>
    </div>
@else
    <!-- Default form fields if service type not recognized -->
    <div class="mb-6 border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
        
        <div>
            <label for="additional_details" class="block text-sm font-medium text-gray-700">Additional Details</label>
            <textarea name="form_data[additional_details]" id="additional_details" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
        </div>
    </div>
@endif

<script>
    // Show "other purpose" field when "Other" is selected in purpose dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const purposeDropdown = document.getElementById('purpose');
        const clearancePurposeDropdown = document.getElementById('clearance_purpose');
        const otherPurposeField = document.getElementById('other_purpose_field');
        
        if (purposeDropdown) {
            purposeDropdown.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherPurposeField.style.display = 'block';
                } else {
                    otherPurposeField.style.display = 'none';
                }
            });
        }
        
        if (clearancePurposeDropdown) {
            clearancePurposeDropdown.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherPurposeField.style.display = 'block';
                } else {
                    otherPurposeField.style.display = 'none';
                }
            });
        }
    });
</script>