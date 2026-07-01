<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'evidence_image',
        'status',
        'assigned_officer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
