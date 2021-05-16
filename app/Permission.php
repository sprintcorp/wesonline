<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permission";
    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function user_permission()
    {
        return $this->belongsToMany(User::class);
    }
}
