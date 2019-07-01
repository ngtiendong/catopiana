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
        $data = Question::listQuestion($topic, 1, 10);
        // data processing
        $result_process = Question::processQuestion($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionIq ($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->select('introduction_video')->first();
        $data = Question::listQuestion($topic, 1, 30);
        // data processing
        $result_process = Question::processQuestion($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionAudio($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->first();
        $data = Question::listQuestion($topic, 1, 10);
        // data processing
        $result_process = Question::processAudio($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getListQuestionPosition($topic, $level)
    {
        $topic_video = Topic::where('id',$topic)->select('introduction_video')->first();
        $data = Question::listQuestion($topic, 1, 10);
        // data processing      
        $result_process = Question::processPosition($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id, // fix
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => 2,
            'video' => $topic_video->introduction_video
        ];
    }

    public static function getLessLevelQuestion($topic, $level, $index)
    {
        $data = Question::changeQuestion($topic, $level, $index, 10);
        if(sizeof($data['list_question']) == 0) {
            return [];
        }
        // data processing
        $result_process = Question::processQuestion($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type
        ];
    }

    public static function getLessLevelQuestionIq($topic, $level, $index)
    {
        $data = Question::changeQuestion($topic, $level, $index, 30);
        if(sizeof($data['list_question']) == 0) {
            return [];
        }
        // data processing
        $result_process = Question::processQuestion($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type
        ];
    }

    public static function getLessLevelQuestionAudio($topic, $level, $index)
    {
        $data = Question::changeQuestion($topic, $level, $index, 10);
        if(sizeof($data['list_question']) == 0) {
            return [];
        }
        // data processing
        $result_process = Question::processAudio($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => $data['curriculum']->type
        ];
    }

    public static function getLessLevelQuestionPosition($topic, $level, $index)
    {
        $data = Question::changeQuestion($topic, $level, $index, 10);
        if(sizeof($data['list_question']) == 0) {
            return [];
        }
        // data processing
        $result_process = Question::processPosition($data['list_question']);

        return [
            'curriculum_id' => $data['curriculum']->id, // fix
            'raw_data' => $result_process['raw_data'],
            'result' => $result_process['result'],
            'type' => 2
        ];
    }

    public static function changeQuestion($topic, $level, $index, $qty)
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level',  $level]
        ])->orderBy('level', 'desc')->first();

        if($curriculum == null){
            return [];
        }
        $qty_question = $qty - (int)($index);
        if($level > 1) {
            $list_question = Question::where('curriculum_id', $curriculum->id)->take($qty_question)->get()->toArray();
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question)->get()->toArray();
        }
        while(sizeof($list_question) < $qty_question){
            $level -= 1;
            $curriculum = Curriculum::where([
                ['topic_id', $topic],
                ['level','<=', $level]
            ])->orderBy('level', 'desc')->first();
             $list_question_more = Question::where('curriculum_id', $curriculum->id)->where('index','>',$index)->take($qty_question - sizeof($list_question))->get()->toArray();
            $list_question = array_merge($list_question, $list_question_more);
        }

        return [
            'curriculum' => $curriculum,
            'list_question' => $list_question
        ];
    }


    public static function listQuestion($topic, $level, $qty, $init = true) 
    {
        $curriculum = Curriculum::where([
            ['topic_id', $topic],
            ['level', $level]
        ])->orderBy('level', 'desc')->first();
        if($init) {
            $list_question = Question::where('curriculum_id', $curriculum->id);
        } else {
            $list_question = Question::where('curriculum_id', $curriculum->id)->inRandomOrder();
        }
        $data = [
            'curriculum' => $curriculum,
            'list_question' => $list_question->take($qty)->get()->toArray()
        ];

        return $data;
    }

    public static function processPosition($list_question)
    {
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
            'result' => $result,
            'raw_data' => $raw_data
        ];
    }

    public static function processQuestion($list_question)
    {
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
            'result' => $result,
            'raw_data' => $raw_data
        ];
    }

    public static function processAudio($list_question)
    {
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
            'result' => $result,
            'raw_data' => $raw_data
        ];
    }
    
    public static function getListQuestionFree($topic)
    {
        $data = Question::listQuestion($topic, 1, 200, false);
        $question = $data['list_question'];
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
            'curriculum_id' => $data['curriculum']->id,
            'raw_data' => $raw_data,
            'result' => $result,
            'type' => $data['curriculum']->type,
            'video' => $video->video_url
        ];
    }
}
