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
            ['topic_id', 2],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();
        $list_question = Question::where('curriculum_id', $curriculum->id)->get()->toArray();
        $raw_data = [];
        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer
                // trả về thêm inđex, level 
                // 'question_index' => $question['index'],
                // 'question_id' => $question['id'],
                // 'question_curriculum' => $question['curriculum_id']
            ];
        }
        return $raw_data;
    }

    public static function getListQuestionAudio($type, $level)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $type],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();
        $list_question = Question::where('curriculum_id', $curriculum->id)->get()->toArray();
        $raw_data = [];
        foreach ($list_question as $question) {
            $answers = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            foreach($answers as $key => $answer){
                $answers[$key] = asset($answer);
            }
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answers,
                'question_image' =>  asset('/Catopiana_files/images/sound.png'),
                'answer_image' =>  asset('/Catopiana_files/images/sound-answer.jpg')
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
            ['topic_id', 2],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];

        if($curriculum == null){
            return $raw_data;
        }
        $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->get()->toArray();

        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer
                // trả về thêm inđex, level 
                // 'question_index' => $question['index'],
                // 'question_id' => $question['id'],
                // 'question_curriculum' => $question['curriculum_id']

            ];
        }
        return $raw_data;
    }

    public static function getLessLevelQuestionAudio($type, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $type],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];

        if($curriculum == null){
            return $raw_data;
        }
        $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->get()->toArray();

        foreach ($list_question as $question) {
            $answers = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            foreach($answers as $key => $answer){
                $answers[$key] = asset($answer);
            }
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answers,
                'question_image' =>  asset('/Catopiana_files/images/sound.png'),
                'answer_image' =>  asset('/Catopiana_files/images/sound-answer.jpg')
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
