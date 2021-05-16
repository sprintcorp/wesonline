<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $table = "internship";
    protected $guarded = [];

    public function employer()
    {
        return $this->belongsTo(Employer::class,'employer_id');
    }

    public function student_internship()
    {
        return $this->belongsToMany(Student::class);
    }
}
