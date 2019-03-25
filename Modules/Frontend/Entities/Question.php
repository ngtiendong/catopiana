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
        ])->orderBy('level', 'desc')->first();

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

    public static function getListQuestionPosition($type, $level)
    {
        $raw_data = [];
        for ($i=1; $i<7; $i++){
            $left = [
                'test/images/1r.png',
                'test/images/2r.png',
                'test/images/3r.png',
            ];
            $right = [
                'test/images/4r.png',
                'test/images/5r.png',
                'test/images/6r.png',
            ];
            $raw_data[] = [$left,$right];
        }
        return $raw_data;
    }


    public static function getLessLevelQuestion($type, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['type', 1],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();

        $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->get()->toArray();

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

    public static function getLessLevelQuestionAudio($type, $level, $index)
    {
        $raw_data = [];
        for ($i=7; $i<13; $i++){
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

    public static function getLessLevelQuestionPosition($type, $level, $index)
    {
        $raw_data = [];
        for ($i=1; $i<7; $i++){
            $left = [
                'test/images/7r.png',
                'test/images/8r.png',
                'test/images/9r.png',
            ];
            $right = [
                'test/images/10r.png',
                'test/images/11r.png',
                'test/images/12r.png',
            ];
            $raw_data[] = [$left,$right];
        }
        return $raw_data;
    }
}
