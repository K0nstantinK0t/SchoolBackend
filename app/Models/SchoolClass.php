<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id'];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }
}
