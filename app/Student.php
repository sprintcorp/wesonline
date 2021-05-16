<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "student";
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function school()
    {
        return $this->belongsTo(Institution::class,'institution_id');
    }

    public function employer_student()
    {
        return $this->belongsToMany(Employer::class);
    }

    public function supervisor()
    {
        return $this->belongsToMany(SiwesSupervisor::class);
    }

    public function employee_student()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function student_internship()
    {
        return $this->belongsToMany(Internship::class);
    }
}
