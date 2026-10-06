<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'segment',
        'interest'
    ];

    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_custom_field', 'custom_field_id');
    }
}
