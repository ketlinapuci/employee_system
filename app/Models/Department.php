<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Define the relationship to the parent department
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    // Define the relationship to the child departments
    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    // // Get all employees under this department
    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }
}
