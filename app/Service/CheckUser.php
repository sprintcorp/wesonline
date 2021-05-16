<?php

namespace App\Service;


use App\User;

class CheckUser{

    public function checkUserMail($mail){

        $user = User::where('email',$mail)->first();
        if($user){
            return $user;
        }else{
            return false;
        }
    }

}
