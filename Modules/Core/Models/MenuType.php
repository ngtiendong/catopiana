<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
    protected $guarded = [];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -1;

    public function getStatusName()
    {
        if ($this->status == self::STATUS_ACTIVE)
            return "Đang kích hoạt";
        elseif ($this->status == self::STATUS_INACTIVE)
            return "Không sử dụng";
        else
            return "Đã xóa";
    }

    /**
     * Get list active menu types
     */
    public static function getListActive()
    {
        return self::where('status', self::STATUS_ACTIVE)->get();
    }
}
