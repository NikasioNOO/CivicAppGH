<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 04/11/2016
 * Time: 09:29 PM
 */

namespace CivicApp\Utilities;


use Illuminate\Http\UploadedFile;
use Image;
use File;

 class ImageHelper {

    public  static function StoreImage(UploadedFile $file, $targetPath)
    {
        $method = 'StorePhoto';

        Logger::startMethod($method);

        try {
            if ($file->isValid()) {
                $originalName = $file->getClientOriginalName();
                $extension    = $file->getClientOriginalExtension();
                $filename     = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
                $filename     = ImageHelper::sanitize($filename);
                $filename     = ImageHelper::createUniqueFilename($filename, $extension, $targetPath);

                $img = Image::make($file);
                $img->resize(800,null,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($targetPath. $filename);
                //$file->move(env('PHOTOS_PATH'), $filename);
                Logger::endMethod($method);

                return $targetPath . $filename;

            } else {
                throw new \Exception($file->getErrorMessage());
            }

        }catch (\Exception $ex)
        {
            Logger::logError($method,'Error'.$ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }

    }

     public static function createUniqueFilename( $filename, $extension, $targetPath )
     {
         $imageToken = substr(sha1(mt_rand()), 0, 5);
         $newFileName = $filename.'_'.$imageToken.'.'.$extension;
         $image_path = $targetPath . $newFileName . '.' . $extension;
         while( File::exists( $image_path ))
         {
             $imageToken = substr(sha1(mt_rand()), 0, 5);
             $newFileName = $filename.'_'.$imageToken.'.'.$extension;
             $image_path = $targetPath . $newFileName;
         }

         return $newFileName . '.' . $extension;
     }

    public static function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"];
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;

    }





}