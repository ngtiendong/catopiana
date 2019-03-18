<?php

namespace Modules\Core\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\Image;

class ImageController extends ApiController
{
    /**
     * API upload image
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $filePathInfo = pathinfo($file->getClientOriginalName());
        $fileName = $filePathInfo['filename'];
        $fileExt = $filePathInfo['extension'];
        // get file_path, domain
        $fileName = (10000*microtime(true)) . '_' . str_slug($fileName) . '.' . $fileExt;

        $savePath = $fileName;

        // Create file
        if (Storage::disk('files')->put($savePath, file_get_contents($file->getRealPath()))) {
            // Create image record
            $fileUrl = Storage::disk('files')->url($savePath);

            $image = Image::createImage($fileUrl);

            return $this->successResponse(['image' => $image]);
        } else {
            return $this->errorResponse([]);
        }
    }
}
