<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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
    public function test()
    {
        return view('frontend::test');
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

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('frontend::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
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
