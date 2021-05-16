<?php

namespace App\Service;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Fileupload{

    public function video($file){

        $success = Cloudinary::uploadVideo($file,["folder"=>"/wesonline/module/"]);
        if ($success) {
            return $success;
        }else{
            throw new \Exception('Error');
        }
    }
    public function testing(){
        return "hello";
    }


    public function image($file){

        $success = Cloudinary::upload($file,["folder"=>"/wesonline/image/"]);
        if ($success) {
            return $success;
        }else{
            throw new \Exception('Error');
        }
    }

    public function document($file){

        $success = Cloudinary::uploadFile($file,["folder"=>"/wesonline/document/"]);
        if ($success) {
            return $success;
        }else{
            throw new \Exception('Error');
        }
    }

    public function deleteFile($id){
        $success = Cloudinary::destroy($id);
        if ($success) {
            return $success;
        }else{
            throw new \Exception('Error');
        }
    }
}
