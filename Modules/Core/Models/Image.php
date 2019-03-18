<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';
    protected $guarded = [];

    public static function createImage($filePath)
    {
        return self::create([
            'file_path'  => $filePath,
            'image_url'  => config('core.resource_url') . $filePath,
            'medium_url' => config('core.resource_url') . $filePath,
            'small_url'  => config('core.resource_url') . $filePath
        ]);
    }
}
