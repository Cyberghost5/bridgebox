<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'school_class_id');
    }
}
