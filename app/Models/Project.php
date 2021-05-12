<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'duration'];

    public $timestamps = false;

    public function students()
    {
        return $this->belongsToMany(Student::class,'students_projects');
    }    
}
