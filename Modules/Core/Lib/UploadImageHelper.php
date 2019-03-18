<?php
/**
 * Created by PhpStorm.
 * User: nguyentiendong
 * Date: 10/1/18
 * Time: 23:07
 */

namespace Modules\Core\Lib;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Support\Facades\Artisan;


class UploadImageHelper
{
    /**
     * Upload media
     * @return array
     */
    public static function uploadMultipleMedia()
    {
        $media = array();
        if (!empty($_POST['caption'])) {
            for ($i = 0; $i < count($_POST['caption']); $i++) {
                if (!empty($_FILES['file']['name'][$i])) {
                    $name = Auth::id() . "_" . md5(microtime()) . $_FILES['file']['name'][$i];
                    $width = 0;
                    $height = 0;
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], public_path('/img/products/') . $name)) {
                        // Resize image
                        if (strpos($_FILES['file']['type'][$i], 'image') !== false) {
                            $imgInfo = Image::make('img/products/' . $name);
                            if($imgInfo->getWidth() > env('WIDTH_FILE_IMG')){
                                $thumbnail = $imgInfo->resize(env('WIDTH_FILE_IMG'), null, function ($constraint){
                                    $constraint->aspectRatio();
                                });
                                $thumbnail->save('img/products/' . $name);
                                $width = $thumbnail->getWidth();
                                $height = $thumbnail->getHeight();
                            }
                            else {
                                $width = $imgInfo->getWidth();
                                $height = $imgInfo->getHeight();
                            }
                        }

                        $media[] = array(
                            'caption' => $_POST['caption'][$i],
                            'link' => $name,
                            'width'=>$width,
                            'height'=>$height
                        );
                    }
                }else if(!empty($_POST['link'][$i])){
                    try{
//                        dd($_POST['link'][$i]);
                        $imgInfo = @Image::make('img/products/' . $_POST['link'][$i]);
                        $media[] = array(
                            'caption' => $_POST['caption'][$i],
                            'link' => $_POST['link'][$i],
                            'width'=>$imgInfo->getWidth(),
                            'height'=>$imgInfo->getHeight()
                        );
                    }
                    catch(NotReadableException $ex){
                        continue;
                    }

                }

            }
        }
        return $media;
    }

    /**
     * @param $request
     * @param $key
     * @param string $old_image
     * @return string
     */
    public function uploadImage($request, $key, $old_image = '')
    {
        if ($request->hasFile($key)) {
            if ($key=="thumbnail") {
                $thumbnailArr = [];

                foreach ($request->file($key) as $key => $image_value) {
                    $thumbnailArr[] = $this->singleImage($request, $image_value);
                }

                return \GuzzleHttp\json_encode($thumbnailArr);

            } else {
                return $this->singleImage($request, $request->file($key));
            }
        }
        else {
            return $old_image;
        }
    }

    /**
     * @param $request
     * @param string $image
     * @return string name thumbnail of post
     */
    public function singleImage($request, $key, $image = ''){
        if ($request->hasFile($key)) {
            $img = $request->file($key)->getClientOriginalName();
            $thumbnail = Image::make($request->file($key)->getRealPath());
            $thumbnail->save('img/products/'.$key.'_' . $img);
            $image = $key.'_' . $img;
            $array = array(
                'caption'=>'',
                'link'=>$image,
                'width'=>$thumbnail->width(),
                'height'=>$thumbnail->height()
            );
            return \GuzzleHttp\json_encode($array);
        }
        else {
            return $image;
        }
    }


}
