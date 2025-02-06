<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_logo',
        'location',
        'about',
        'business_primary_category',
        'business_secondary_categories',
        'website',
        'technician_photo',
        'vehicle_photo',
        'facility_photo',
        'project_photo',
        'insurance_certificate',
        'license_certificate',
        'award_certificate',
        'conversation_call_number',
        'conversation_text_number',
        'conversation_email',
        'conversation_address',



    ];
}
