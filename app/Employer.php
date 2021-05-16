<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = "employer";
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function anoouncement(){
        return $this->hasMany(Announcement::class);
    }

    public function internship(){
        return $this->hasMany(Internship::class);
    }

    public function webinar(){
        return $this->hasMany(Webinar::class);
    }

    public function employer_student()
    {
        return $this->belongsToMany(Student::class);
    }
}
