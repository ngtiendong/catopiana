<?php

namespace Modules\Frontend\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $table = 'beta_curriculum_questions';

    public static function getListQuestion($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->select('introduction_video')->first();
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', 1]
        ])->orderBy('level', 'desc')->first();
        $list_question = Question::where('curriculum_id', $curriculum->id)->take(10)->get()->toArray();
        $raw_data = [];
        $result = [];
        foreach ($list_question as $question) {
            if ($question['correct_answer']) {
                $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            } else {
                $answer = \GuzzleHttp\json_decode($question['wrong_answer'], true);
            }
            shuffle($answer);
            //Save answer
            array_push($result, array_search($question['correct_answer'], $answer));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer,
            ];
        }

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionFree($topic)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic] // 15
        ])->orderBy('level', 'desc')->first();
        $question = Question::where('curriculum_id', $curriculum->id)->inRandomOrder()->take(200)->get()->toArray();
        shuffle($question);
        $video = CurriculumVideo::inRandomOrder()->first();
        $list_question_video = VideoQuestion::where('curriculum_video_id', $video->id)->get()->toArray();
        $list_question = array_merge($list_question_video, $question);        
        $raw_data = [];
        $result = [];
        foreach ($list_question as $question) {
            if($question['question_type'] == 1) {
                $answers = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
                shuffle($answers);
                //Save answer
                array_push($result, array_search($question['correct_answer'], $answers));
               foreach($answers as $key => $answer){
                   $answers[$key] = asset($answer);
               }

               $raw_data[] = [
                   'question' => $question['question'],
                   'answers' => $answers,
                   'question_image' =>  asset($question['question_image']),
                   'answer_image' =>  asset($question['question_image']),
                   'question_type' =>  $question['question_type']
               ];
           } elseif ($question['question_type'] == 2) {
                $question_content = \GuzzleHttp\json_decode($question['question'], true);
                shuffle($question_content['left']);
                shuffle($question_content['right']);
                $item = [
                    'left' => $question_content['left'],
                    'right' => $question_content['right'],
                    'question_type' => $question['question_type']
                ];
                $raw_data[] = $item;
                $correct_answer = \GuzzleHttp\json_decode($question['correct_answer'], true);
                $result_item = [];
                foreach ($correct_answer as $pair) {
                    array_push($result_item, [array_search($pair[0], $item['left']), array_search($pair[1], $item['right'])]);
                }
                array_push($result, $result_item);
           } else { 
                if ($question['correct_answer']) {
                    $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
                } else {
                    $answer = \GuzzleHttp\json_decode($question['wrong_answer'], true);
                }
                shuffle($answer);
                //Save answer
                array_push($result, array_search($question['correct_answer'], $answer));
                $raw_data[] = [
                    'question' => $question['question'],
                    'answers' => $answer,
                    'question_type' =>  $question['question_type']
                ];
            } 
        }

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type,
            'video' => $video->video_url
        ];
    }

    public static function getListQuestionIq ($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->select('introduction_video')->first();
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', 1]
        ])->orderBy('level', 'desc')->first();
        $list_question = Question::where('curriculum_id', $curriculum->id)->get()->toArray();
        $raw_data = [];
        $result = [];
        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            shuffle($answer);
            //Save answer
            array_push($result, array_search($question['correct_answer'], $answer));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer
            ];
        }

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionAudio($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->first();
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', 1]
        ])->orderBy('level', 'desc')->first();
        $list_question = Question::where('curriculum_id', $curriculum->id)->take(10)->get()->toArray();
        $raw_data = [];
        $result = [];
        foreach ($list_question as $question) {
           $answers = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            shuffle($answers);
            //Save answer
            array_push($result, array_search($question['correct_answer'], $answers));
           foreach($answers as $key => $answer){
               $answers[$key] = asset($answer);
           }

           $raw_data[] = [
               'question' => $question['question'],
               'answers' => $answers,
               'question_image' =>  asset($question['question_image']),
               'answer_image' =>  asset($question['question_image'])
           ];
       }

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionPosition($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->select('introduction_video')->first();
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', 1]
        ])->orderBy('level', 'desc')->first();

        $list_question = Question::where('curriculum_id', $curriculum->id)->take(10)->get()->toArray();
        $raw_data = [];
        $result = [];
        foreach ($list_question as $question) {
            $question_content = \GuzzleHttp\json_decode($question['question'], true);
            shuffle($question_content['left']);
            shuffle($question_content['right']);
            $item = [
                'left' => $question_content['left'],
                'right' => $question_content['right']
            ];
            $raw_data[] = $item;
            $correct_answer = \GuzzleHttp\json_decode($question['correct_answer'], true);
            $result_item = [];
            foreach ($correct_answer as $pair) {
                array_push($result_item, [array_search($pair[0], $item['left']), array_search($pair[1], $item['right'])]);
            }
            array_push($result, $result_item);
        }

        return [
            'curriculum_id' => $curriculum->id, // fix
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => 2,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getLessLevelQuestion($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];
        $result = [];
        if($curriculum == null){
            return $raw_data;
        }
        $qty_question = 10 - (int)($index);
        if($level > 1) {
            $list_question = Question::where('curriculum_id', $curriculum->id)->take($qty_question)->get()->toArray();
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question)->get()->toArray();
        }
        if(sizeof($list_question) < $qty_question){
            $curriculum = Curriculum::where([
                ['topic_id', $topic],
                ['level','<=', $level - 1]
            ])->orderBy('level', 'desc')->first();
             $list_question_more = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question - sizeof($list_question))->get()->toArray();
            $list_question = array_merge($list_question, $list_question_more);
        }
        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            shuffle($answer);
            //Save answer
            array_push($result, array_search($question['correct_answer'], $answer));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer
            ];

        }
        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type
        ];
    }

    public static function getLessLevelQuestionIq($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];
        $result = [];
        if($curriculum == null){
            return $raw_data;
        }
        $qty_question = 30 - (int)($index);

        if($level > 1) {
            $list_question = Question::where('curriculum_id', $curriculum->id)->take($qty_question)->get()->toArray();
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question)->get()->toArray();
        }
        if(sizeof($list_question) < $qty_question){
            $curriculum = Curriculum::where([
                ['topic_id', $topic],
                ['level','<=', $level - 1]
            ])->orderBy('level', 'desc')->first();
             $list_question_more = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question - sizeof($list_question))->get()->toArray();
            $list_question = array_merge($list_question, $list_question_more);
        }
        foreach ($list_question as $question) {
            $answer = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
            shuffle($answer);
            //Save answer
            array_push($result, array_search($question['correct_answer'], $answer));
            $raw_data[] = [
                'question' => $question['question'],
                'answers' => $answer
            ];
        }
        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type
        ];
    }

    public static function getLessLevelQuestionAudio($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level',  $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];
        $result = [];
        if($curriculum == null){
            return $raw_data;
        }
        $qty_question = 10 - (int)($index);
        if($level > 1) {
            $list_question = Question::where('curriculum_id', $curriculum->id)->take($qty_question)->get()->toArray();
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question)->get()->toArray();
        }
        if(sizeof($list_question) < $qty_question){
            $curriculum = Curriculum::where([
                ['topic_id', $topic],
                ['level','<=', $level - 1]
            ])->orderBy('level', 'desc')->first();
             $list_question_more = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question - sizeof($list_question))->get()->toArray();
            $list_question = array_merge($list_question, $list_question_more);
        }
       foreach ($list_question as $question) {
           $answers = array_merge([$question['correct_answer']], \GuzzleHttp\json_decode($question['wrong_answer'], true));
           shuffle($answers);
           //Save answer
           array_push($result, array_search($question['correct_answer'], $answers));
           foreach($answers as $key => $answer){
               $answers[$key] = asset($answer);
           }
           $raw_data[] = [
               'question' => $question['question'],
               'answers' => $answers,
               'question_image' =>  asset($question['question_image']),
               'answer_image' =>  asset($question['question_image'])
           ];
       }

        return [
            'curriculum_id' => $curriculum->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $curriculum->type
        ];
    }

    public static function getLessLevelQuestionPosition($topic, $level, $index)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level',  $level]
        ])->orderBy('level', 'desc')->first();
        $raw_data = [];
        $result = [];
        if($curriculum == null){
            return $raw_data;
        }
        $qty_question = 10 - (int)($index) ;
        if($level > 1) {
            $list_question = Question::where('curriculum_id', $curriculum->id)->take($qty_question)->get()->toArray();
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question)->get()->toArray();
        }
        if(sizeof($list_question) < $qty_question){
            $curriculum = Curriculum::where([
                ['topic_id', $topic],
                ['level','<=', $level - 1]
            ])->orderBy('level', 'desc')->first();
             $list_question_more = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question - sizeof($list_question))->get()->toArray();
            $list_question = array_merge($list_question, $list_question_more);
        }
        foreach ($list_question as $question) {
            $question_content = \GuzzleHttp\json_decode($question['question'], true);
            shuffle($question_content['left']);
            shuffle($question_content['right']);
            $item = [
                'left' => $question_content['left'],
                'right' => $question_content['right']
            ];
            $raw_data[] = $item;
            $correct_answer = \GuzzleHttp\json_decode($question['correct_answer'], true);
            $result_item = [];
            foreach ($correct_answer as $pair) {
                array_push($result_item, [array_search($pair[0], $item['left']), array_search($pair[1], $item['right'])]);
            }
            array_push($result, $result_item);
        }
        return [
            'curriculum_id' => $curriculum->id, // fix
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => 2
        ];
    }
}
