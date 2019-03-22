<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Frontend\Entities\Question;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('frontend::home');
    }

    /**
     * Display a creative page
     * @return Response
     */
    public function test($type)
    {
        return view('frontend::test', compact('type'));
    }

     /**
     * Display a music page
     * @return Response
     */
    public function music()
    {
        return view('frontend::music');
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
            $raw_data = Question::getListQuestion($params['type'], $params['level']);
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

}
