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
        $type=$this->getTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::position', compact('type'));
    }

    /**
     * Display a creative page
     * @return Response
     */
    public function test()
    {
        $type=$this->getTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::test', compact('type'));
    }

     /**
     * Display a music page
     * @return Response
     */
    public function music()
    {
        $type=$this->getTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::music', compact('type'));
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
            if ($params['type'] == "1"){
                //Audio
                $raw_data = Question::getListQuestionAudio($params['type'], $params['level']);
            }elseif ($params['type'] == "8") {
                //Position
                $raw_data = Question::getListQuestionPosition($params['type'], $params['level']);
            }
            else {
                $raw_data = Question::getListQuestion($params['type'], $params['level']);
            }
//            dd($raw_data);
            return [
                'status' => 1,
                'question_data' => $raw_data
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
        if (!empty($params['type']) && !empty($params['level']) && !empty($params['index'])) {
            if ($params['type'] == "1"){
                //Audio
                $raw_data = Question::getLessLevelQuestionAudio($params['type'], $params['level'], $params['index']);
                
            } elseif($params['type'] == "8") {
                //Position
                $raw_data = Question::getLessLevelQuestionPosition($params['type'], $params['level'], $params['index']);
            }
            else {
                $raw_data = Question::getLessLevelQuestion($params['type'], $params['level'], $params['index']);
            }
            return [
                'status' => 1,
                'question_data' => $raw_data
            ];
        } else {
            return [
                'status' => 0
            ];
        }


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

    public function getTypeId($name)
    {
        switch ($name) {
            case 'music':
                return 1;
                break;
            case 'iq':
                return 2;
                break;
            case 'creative':
                return 3;
                break;
            case 'difference':
                return 4;
                break;
            case 'common':
                return 5;
                break;
            case 'memory':
                return 6;
                break;
            case 'language':
                return 7;
                break;
            case 'position':
                return 8;
                break;
            default:
                return 0;
                break;
        }


    }
}
