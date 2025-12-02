<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'registration_id',
        'mda',
        'sector',
        'title',
        'description',
        'cost',
        'objective',
        'location',
        'phase',
        'status',
        'expected_start',
        'expected_end',
        'date_of_submission',
        'date_of_entry',
        'attachments',
        'comments',
        'created_by'
    ];

    protected $casts = [
        'attachments' => 'array',
        'date_of_submission' => 'date',
        'date_of_entry' => 'date',
        'expected_start' => 'date',
        'expected_end' => 'date',
        'cost' => 'decimal:2',
    ];

    public function updates()
    {
        return $this->hasMany(ProjectUpdate::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
