<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = "employer";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
