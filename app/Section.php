<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = "section";
    protected $guarded = [];
    public function training()
    {
        return $this->belongsTo(Training::class,'training_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function module()
    {
        return $this->hasMany(Module::class);
    }
}
