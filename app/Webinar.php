<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $table = "webinar";
    protected $guarded = [];
    public function employer()
    {
        return $this->belongsTo(Employer::class,'employer_id');
    }
}
