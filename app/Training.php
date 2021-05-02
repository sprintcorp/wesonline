<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = "training";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class);
    }
}
