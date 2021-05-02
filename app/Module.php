<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = "module";
    protected $guarded = [];
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
