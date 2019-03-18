<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = ["type", "name", "object_ids"];

    /**
     * The relationship
     */
    public function user_groups()
    {
        return $this->hasMany('Modules\Core\Models\UserGroup', 'group_id');
    }

    const TYPE_COMPAPNY = 0;
    const TYPE_AGENCY = 1;

    public function getTypeName() {
        if ($this->type == Group::TYPE_COMPAPNY)
            return "Nhân viên công ty";
        elseif ($this->type == Group::TYPE_AGENCY)
            return "Nhân viên đại lý";
        else
            return "";
    }

}
