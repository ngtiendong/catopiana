<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $table = 'questions';

    public static function getListQuestion($type, $level)
    {
        $curriculum = Curriculum::where([
            ['type', 1],
            ['level', '<=', $level]
        ])->orderBy('level')->first();

        $list_question = Question::where('curriculum_id', $curriculum->id)->get()->toArray();

        $raw_data = [];
        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            $raw_data[] = [
                'question' => $question['question'],
                'answer' => $answer
            ];
        }
        return $raw_data;
    }
}
