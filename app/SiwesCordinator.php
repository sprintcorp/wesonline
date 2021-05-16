<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiwesCordinator extends Model
{
    protected $table = "siwes_cordinator";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class,'institution_id');
    }
}
