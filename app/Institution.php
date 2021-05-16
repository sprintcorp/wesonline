<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = "institution";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function supervisor()
    {
        return $this->hasMany(SiwesSupervisor::class);
    }

    public function cordinator()
    {
        return $this->hasMany(SiwesCordinator::class);
    }
}
