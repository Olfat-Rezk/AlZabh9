<?php
namespace App\Http\Traits;


trait ApiResponses {
    public function success(string $message ,int $statusCode = 200)
    {
        return response()->json([
            "success"=>true,
            "message"=>$message,
            "data"=>(object)[],
            "errors"=>(object)[]
        ],$statusCode);
    }

    public function error( $errors , string $message = "" ,int $statusCode = 422)
    {
        return response()->json([
            "success"=>false,
            "message"=>$message,
            "data"=>(object)[],
            "errors"=>$errors
        ],$statusCode);
    }

    public function data(array $data , string $message = "" ,int $statusCode = 200)
    {
        return response()->json([
            "success"=>true,
            "message"=>$message,
            "data"=>(object)$data,
            "errors"=>(object)[]
        ],$statusCode);
    }
    public function saveImage($photo,$folder){
        $file_extention =$photo->getClientOriginalExtention();
        $file_name =time().'.'. $file_extention;
        $path = $folder;
        $photo->mov($path,$file_name);
        return $file_name;
    }

    public function uploadMedia($media,$dir){
        $newMediaName = $media->hashName();
        $media->mov(public_path('\images\{$dir}'),$newMediaName);
        return $newMediaName;

    }

    public function removeImage($media_path){
        if(file_exists($media_path)){
            unlink($media_path);
            return true;
        }
        return false;


    }






}
