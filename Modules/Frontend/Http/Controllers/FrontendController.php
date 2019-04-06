<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\Entities\Question;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
//        dd(auth()->guard('customers')->user()->username);
        return view('frontend::home');
    }

    /**
     * Display a position page
     * @return Response
     */
    public function position()
    {
        $type_and_topic=$this->getTopicAndTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::position', compact('type_and_topic'));
    }

    /**
     * Display a creative page
     * @return Response
     */
    public function test()
    {
        $type_and_topic=$this->getTopicAndTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::test', compact('type_and_topic'));
    }

     /**
     * Display a music page
     * @return Response
     */
    public function music()
    {
        $type_and_topic=$this->getTopicAndTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::music', compact('type_and_topic'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('frontend::create');
    }

    public function getListQuestion(Request $request)
    {
        $params = $request->all();
        if (!empty($params['type']) || !empty($params['level'])) {
            if ($params['topic'] == "1"){
                //Audio
                $raw_data = Question::getListQuestionAudio($params['topic'], $params['level']);
            }elseif ($params['topic'] == "8") {
                //Position
                $raw_data = Question::getListQuestionPosition($params['topic'], $params['level']);
            }
            else {
                $raw_data = Question::getListQuestion($params['topic'], $params['level']);
            }
//            dd($raw_data);
            return [
                'status' => 1,
                'question_data' => $raw_data['raw_data'],
                'type' => $raw_data['type']
            ];
        } else {
            return [
                'status' => 0
            ];
        }


    }

    public function getListLessLevelQuestion(Request $request)
    {
        $params = $request->all();
        if (!empty($params['topic']) && !empty($params['topic']) && !empty($params['index'])) {
            if ($params['topic'] == "1"){
                //Audio
                $raw_data = Question::getLessLevelQuestionAudio($params['topic'], $params['level'], $params['index']);

            } elseif($params['topic'] == "8") {
                //Position
                $raw_data = Question::getLessLevelQuestionPosition($params['topic'], $params['level'], $params['index']);
            }
            else {
                $raw_data = Question::getLessLevelQuestion($params['topic'], $params['level'], $params['index']);
            }
            if (!empty($raw_data['raw_data'])) {
                return [
                    'status' => 1,
                    'question_data' => $raw_data['raw_data'],
                    'type' => $raw_data['type']
                ];
            } else {
                return [
                    'status' => 1,
                    'question_data' => $raw_data,
                ];
            }

        }
        return [
            'status' => 0
        ];



    }

    public function getQA(Request $request)
    {
        $level = $request->level;
        $questionAnswer = [
            'question' => asset('/test/images/'.$level.'age/'. $request->num.'A.png'),
            'answers' => [
                asset('/test/images/'.$level.'age/'. $request->num.'A.png'),
                asset('/test/images/'.$level.'age/'. $request->num.'BCD.png'),
                asset('/test/images/'.$level.'age/'. $request->num.'BCD.png'),
                asset('/test/images/'.$level.'age/'. $request->num.'BCD.png'),
            ],
            'correct' => 0
        ];
        return response()->json($questionAnswer,200);
    }

    public function getQAAudio(Request $request)
    {
        $questionAnswer = [
            'question' => asset('/test/audios/cau'. $request->num.'/question.mov'),
            'answers' => [
                asset('/test/audios/cau'. $request->num.'/A.mov'),
                asset('/test/audios/cau'. $request->num.'/B.mov'),
                asset('/test/audios/cau'. $request->num.'/C.mov'),
            ],
            'question_image' =>  asset('/Catopiana_files/images/sound.png'),
            'answer_image' =>  asset('/Catopiana_files/images/sound-answer.jpg'),
            'correct' => 0
        ];
        return response()->json($questionAnswer,200);
    }

    public function getTopicAndTypeId($name)
    {
        switch ($name) {
            case 'music':
                return [
                    'topic' => "1",
                    'type' => "1"
                ];
                break;
            case 'iq':
                return [
                    'topic' => "2",
                    'type' => "0"
                ];
                break;
            case 'creative':
                return [
                    'topic' => "3",
                    'type' => "0"
                ];
                break;
            case 'difference':
                return [
                    'topic' => "4",
                    'type' => "0"
                ];
                break;
            case 'common':
                return [
                    'topic' => "5",
                    'type' => "0"
                ];
                break;
            case 'memory':
                return [
                    'topic' => "6",
                    'type' => "0"
                ];
                break;
            case 'language':
                return [
                    'topic' => "7",
                    'type' => "0"
                ];
                break;
            case 'position':
                return [
                    'topic' => "8",
                    'type' => "2"
                ];
                break;
            default:
                return 0;
                break;
        }


    }
}
