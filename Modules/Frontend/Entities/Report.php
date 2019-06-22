<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];
    protected $table = 'reports';

    public function topic()
    {
    	return $this->belongsTo(Topic::class,'topic_id');
    }

    public static function getReport($total_question, $result, $topic)
    {
        if($total_question == 0) {
            return Report::where('topic_id', $topic)->first();
        }
        $point = ( (int)($result)/(int)($total_question) )* 100;
        if($point < 50) {
            $report_type = 1;
        } else if(50 < $point && $point < 70) {
            $report_type = 2;
        } else if(70 < $point && $point < 90) {
            $report_type = 3;
        } else {
            $report_type = 4;
        }
            
        $report = Report::where('topic_id', $topic)->where('report_type',$report_type)->first();
        return $report;
    }
}
