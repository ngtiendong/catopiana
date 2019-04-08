<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $guarded = [];
    protected $table = 'curriculums';

    public function topic()
    {
    	return $this->belongsTo(Topic::class,'topic_id');
    }
}
