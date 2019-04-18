<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $table = 'questions';

    public static function getListQuestion($topic, $level)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
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
        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'type' => $curriculum->type
        ];
    }

    public static function getListQuestionAudio($topic, $level)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
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
        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'type' => $curriculum->type
        ];
    }

    public static function getListQuestionPosition($topic, $level)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();

        $list_question = Question::where('curriculum_id', $curriculum->id)->get()->toArray();
        $raw_data = [];

        foreach ($list_question as $question) {
//            dd($question['question'], $topic, $curriculum, $list_question);
            $question = \GuzzleHttp\json_decode($question['question'], true);
            $raw_data[] = [
                $question['left'],
                $question['right']
            ];
        }
        return [
            'curriculum_id' => $curriculum->id, // fix
            'raw_data' => $raw_data,
            'type' => 2
        ];
    }

    public static function getLessLevelQuestion($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
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
            ];
        }
        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'type' => $curriculum->type
        ];
    }

    public static function getLessLevelQuestionAudio($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
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

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'type' => $curriculum->type
        ];
    }

    public static function getLessLevelQuestionPosition($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', '<=', $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];
        if($curriculum == null){
            return $raw_data;
        }

        $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->get()->toArray();

        foreach ($list_question as $question) {
//            dd($question['question'], $topic, $curriculum, $list_question);
            $question = \GuzzleHttp\json_decode($question['question'], true);
            $raw_data[] = [
                $question['left'],
                $question['right']
            ];
        }
        return [
            'curriculum_id' => $curriculum->id, // fix
            'raw_data' => $raw_data,
            'type' => 2
        ];
    }
}
