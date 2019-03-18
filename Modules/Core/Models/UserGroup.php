<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = ["user_id", "group_id"];

    /**
     * The relationship
     */
    public function group()
    {
        return $this->belongsTo('Modules\Core\Models\Group', 'group_id');
    }
    public function user()
    {
        return $this->belongsTo('Modules\Core\Models\User', 'user_id');
    }
}
