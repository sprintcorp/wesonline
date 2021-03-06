<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "role";
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
