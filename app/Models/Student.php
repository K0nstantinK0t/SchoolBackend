<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'surname',
        'birthday',
        'school_class_id',
    ];
    public function SchoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
