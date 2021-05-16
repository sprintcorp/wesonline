<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employee";
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class,'employer_id');
    }

    public function employee_student()
    {
        return $this->belongsToMany(Student::class);
    }
}
