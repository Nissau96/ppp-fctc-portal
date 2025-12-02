<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    protected $fillable = ['project_id', 'status', 'note', 'updated_by'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
