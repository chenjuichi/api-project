<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];
    
    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany(Project::class,'students_projects');
    }    

    public function hasProject(...$projects)
    {
        foreach ($projects as $project) {
            if ($this->projects->contains('id', $project->id)) {
                return true;
            }
        }
        return false;
    }    

}
