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
    ];
}
