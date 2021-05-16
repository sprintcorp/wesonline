<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = "announcement";
    protected $guarded = [];
    public function employer()
    {
        return $this->belongsTo(Employer::class,'employer_id');
    }
}
