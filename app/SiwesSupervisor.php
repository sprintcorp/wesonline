<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiwesSupervisor extends Model
{
    protected $table = "siwes_supervisor";
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class,'institution_id');
    }

    public function student()
    {
        return $this->belongsToMany(Student::class);
    }
}
