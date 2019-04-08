<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = [];
    protected $table = 'topic';

    public function curriculums()
    {
    	return $this->hasMany(Curriculum::class,'topic_id');
    }

}
