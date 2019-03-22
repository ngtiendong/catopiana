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
                'answers' => $answer
            ];
        }
        return $raw_data;
    }

    public static function getListQuestionAudio($type, $level)
    {
        $raw_data = [];
        for ($i=1; $i<7; $i++){
            $raw_data[] = [
                'question' => asset('/test/audios/cau'. $i.'/question.mov'),
                'answers' => [
                    asset('/test/audios/cau'. $i.'/A.mov'),
                    asset('/test/audios/cau'. $i.'/B.mov'),
                    asset('/test/audios/cau'. $i.'/C.mov'),
                ],
                'question_image' =>  asset('/Catopiana_files/images/sound.png'),
                'answer_image' =>  asset('/Catopiana_files/images/sound-answer.jpg'),
                'correct' => 0
            ];
        }
        return $raw_data;
    }
}
