<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalSupervisor extends Model
{
    protected $table = "external_cordinator";
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
