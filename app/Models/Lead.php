<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'job_title',
        'source',
        'status',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
