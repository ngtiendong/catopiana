<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Frontend\Entities\Question;
use Modules\Frontend\Services\PackageService;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    protected $packageService;
    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // $freePackage = null;
        // $paidPackage = null;
        // if(auth()->guard('customers')->user()){
        //     $freePackage = $this->packageService->getFreePackage() != null ? $this->packageService->getFreePackage()->take(4) : null;
        //     $paidPackage = $this->packageService->getPaidPackage() != null ? $this->packageService->getPaidPackage()->take(4) : null;
        // }
        // return view('frontend::home',compact('freePackage','paidPackage'));
        $paidPackage = null;
        $freePackage = $this->packageService->getFreePackageWithoutLogin() != null ? $this->packageService->getFreePackageWithoutLogin()->take(4) : null;
        if(auth()->guard('customers')->user()){
            $paidPackage = $this->packageService->getPaidPackage() != null ? $this->packageService->getPaidPackage()->take(4) : null;
        }
        return view('frontend::home',compact('freePackage','paidPackage'));
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

            // fix level vì chưa có các level < 3 trong db:
            if($params['level'] < 4) {
                $params['level'] = 4;
            }

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
            return [
                'status' => 1,
                'question_data' => $raw_data['raw_data'],
                'type' => $raw_data['type'],
                'curriculum_id' => $raw_data['curriculum_id']
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
                    'type' => $raw_data['type'],
                    'curriculum_id' => $raw_data['curriculum_id']
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
                    'type' => "3"
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
            case 'physics':
                return [
                    'topic' => "9",
                    'type' => "0"
                ];
                break;
            case 'chemistry':
                return [
                    'topic' => "10",
                    'type' => "0"
                ];
                break;

            case 'math':
                return [
                    'topic' => "11",
                    'type' => "0"
                ];
                break;

            case 'animal':
                return [
                    'topic' => "12",
                    'type' => "0"
                ];
                break;

            case 'weather':
                return [
                    'topic' => "13",
                    'type' => "0"
                ];
                break;

            case 'plant':
                return [
                    'topic' => "14",
                    'type' => "0"
                ];
                break;

            case 'fruit':
                return [
                    'topic' => "15",
                    'type' => "0"
                ];
                break;

            case 'sport':
                return [
                    'topic' => "16",
                    'type' => "0"
                ];
                break;

            default:
                return 0;
                break;
        }


    }

    public function resultFreeTest()
    {
        return view('frontend::free_test_result');
    }

    public function updateTestStatus()
    {
        $customer = auth()->guard('customers')->user();
        $customer->update(['test_status' => 2]); // bằng 2 là đã nhận thông báo ở home
        return response()->json(['status' => 200]);
    }

    public function getPackages()
    {
        // pass packages to view
        $customer = auth()->guard('customers')->user();
        $package_paid = $customer->packages()->where('type',1)->first();
        $can_receive_free_package = $customer->test_status;
        return view('frontend::packages',compact('package_paid','can_receive_free_package'));
    }

    public function getCurriculumsFreePackage()
    {
        // $package = null;
        // if(auth()->guard('customers')->user()){
        //     $package = $this->packageService->getFreePackage();
        // }
        // $free = true;
        // return view('frontend::test_package',compact('package','free'));
        $free = true;
        $package = $this->packageService->getFreePackageWithoutLogin();
        return view('frontend::test_package', compact('package','free'));
    }

    public function getCurriculumsPaidPackage()
    {
        $package = null;
        if(auth()->guard('customers')->user()){
            $package = $this->packageService->getPaidPackage();
        }
        $free = false;
        return view('frontend::test_package', compact('package','free'));
    }

    public function continueTest($topic)
    {
        $prev_topic = $topic;
        return view('frontend::continue_test',compact('prev_topic'));
    }

    public function congratulation()
    {
        return view('frontend::congratulation');
    }

    public function generate(){
//        $all = ["a", "b", "c", "d", "e", "f", "g", "h"];
//        $correct = ["c", "e", "a", "b", "c", "e", "f", "d", "a", "c", "c", "d", "b", "d", "a", "e", "d", "b"
//        , "f", "e", "c", "b", "a", "d", "a", "g", "b", "c", "f", "g"];
//        for ($j = 1; $j < 25; $j++) {
//            $temp = [];
//            foreach ($all as $value ) {
//                if ($value !== $correct[$j-1]) {
//                    $temp[] = "/data/iq/1/" . (string)$j.$value.".jpg";
//                }
//            }
//            Question::create([
//                "curriculum_id" => 2,
//                "index" => $j,
//                "question" => "/data/iq/1/" . (string)$j . ".jpg",
//                "correct_answer" => "/data/iq/1/" . (string)$j.$correct[$j-1] . ".jpg",
//                "wrong_answer" => \GuzzleHttp\json_encode($temp)
//            ]);
//        }

        #difference
//        $all = ["A", "B", "C", "D"];
//        $correct = ["A", "B", "D", "C", "A", "D", "B", "B", "D", "D", "B", "C", "A", "D", "C", "C",
//            "C", "B", "A", "C", "C", "B", "A", "B", "A", "B", "A"];
//        $curriculum = [
//            "id" => 4,
//            "level" => "1",
//            "count" => 27
//        ];
//        for ($j = 1; $j < $curriculum["count"]+1; $j++) {
//            $temp = "/data/difference/".$curriculum["level"]."/" . (string)$j;
//            foreach ($all as $value ) {
//                if ($value !== $correct[$j-1]) {
//                    $temp .= $value;
//                }
//
//            }
//            $temp .= ".jpg";
//            DB::beginTransaction();
//            try {
//                Question::create([
//                    "curriculum_id" => $curriculum["id"], #level3
//                    "index" => $j,
//                    "correct_answer" => "/data/difference/" . $curriculum["level"] . "/" . (string)$j . $correct[$j - 1] . ".jpg",
//                    "wrong_answer" => \GuzzleHttp\json_encode([$temp, $temp, $temp])
//                ]);
//                DB::commit();
//            } catch(Exception $e) {
//                DB::rollback();
//            }
//
//        }

        #normal
//        $all = ["a", "b", "c"];
//        $correct = ["a", "c", "b", "c", "b", "a", "b", "a", "c", "a", "a", "b", "c", "c", "b", "a", "b", "b", "c", "a"];
//        for ($j = 1; $j < 21; $j++) {
//            $temp = [];
//            foreach ($all as $value ) {
//                if ($value !== $correct[$j-1]) {
//                    $temp[] = "/data/common/2/" . (string)$j.$value.".jpg";
//                }
//            }
//            Question::create([
//                "curriculum_id" => 23,
//                "index" => $j,
//                "question" => "/data/common/2/" . (string)$j . ".jpg",
//                "correct_answer" => "/data/common/2/" . (string)$j.$correct[$j-1] . ".jpg",
//                "wrong_answer" => \GuzzleHttp\json_encode($temp)
//            ]);
//        }

//        /**
//         * Memory
//         */
//        $all = ["a", "b", "c"];
////        $correct = ["c", "c", "a", "c", "b", "a", "b", "c", "b", "a", "b", "a", "b", "b", "b", "c", "a", "a", "c", "b", "c", "a", "c", "c", "b", "a", "a", "b", "b", "c", "c", "a", "b", "b", "a", "a", "b", "b", "a", "c", "c", "c", "a", "c", "b", "a", "b", "c", "b", "a", "b", "a", "b", "b", "b", "c", "a", "a", "c", "b", "c", "a", "c", "c", "b", "a", "a", "b", "b", "c", "c", "a", "b", "b", "a", "a", "b", "b", "a", "c"];
////        $correct = ["b", "c", "c", "c", "a", "a", "a", "b", "b", "c", "c", "b", "b", "c", "b"];
//        $correct = ["a", "b", "c", "a", "c", "c", "a", "b", "c", "b", "a", "b", "c", "a", "c"];
//        $curriculum = [
//            "id" => 26,
//            "level" => "3",
//            "count" => 15
//        ];
//        for ($j = 56; $j < $curriculum["count"]+56; $j++) {
//            $temp = [];
//            foreach ($all as $value ) {
//                if ($value !== $correct[$j-56]) {
//                    $temp[] = "/data/memory/" . $curriculum["level"] . "/" . (string)$j.$value.".jpg";
//                }
//            }
//            DB::beginTransaction();
//            try {
//                Question::create([
//                    "curriculum_id" => $curriculum["id"], #level3
//                    "index" => $j,
//                    "question" => "/data/memory/" . $curriculum["level"] . "/" . (string)$j . ".jpg",
//                    "correct_answer" => "/data/memory/" . $curriculum["level"] . "/" . (string)$j . $correct[$j - 56] . ".jpg",
//                    "wrong_answer" => \GuzzleHttp\json_encode($temp)
//                ]);
//                DB::commit();
//            } catch(Exception $e) {
//                DB::rollback();
//            }
//
//        }
        /**
         * Language
         */
//        $all = ["a", "b", "c"];
//        $correct = ["a", "c", "b", "a", "b", "b", "a", "c", "b", "a"];
//        $curriculum = [
//            "id" => 7,
//            "level" => "1",
//            "count" => 10
//        ];
//        for ($j = 1; $j < $curriculum["count"]+10; $j+=2) {
//            $temp = [];
//            foreach ($all as $value ) {
//                if ($value !== $correct[ceil(($j-1)/2)]) {
//                    $temp[] = "/data/language/" . $curriculum["level"] . "/" . (string)$j.$value.".mp3";
//                }
//            }
//            DB::beginTransaction();
//            try {
//                Question::create([
//                    "curriculum_id" => $curriculum["id"], #level3
//                    "index" => ceil(($j-1)/2) + 1,
//                    "question" => "/data/language/" . $curriculum["level"] . "/" . (string)$j.",". (string)$j.$correct[ceil(($j-1)/2)] . ".mp3",
//                    "question_image" => "/data/language/" . $curriculum["level"] . "/" . (string)$j.".jpg",
//                    "correct_answer" => "/data/language/" . $curriculum["level"] . "/" . (string)$j .",". (string)$j.$correct[ceil(($j-1)/2)] . ".mp3",
//                    "wrong_answer" => \GuzzleHttp\json_encode($temp)
//                ]);
//                DB::commit();
//            } catch(Exception $e) {
//                DB::rollback();
//            }
//
//        }

        /**
         * Position
         */

        $type = [6,4,4,4,4,4,4,4,6,4,4,4];
        $name = [1,2,3,4,7,8,9,11,12,13,14,15];

        $curriculum = [
            "id" => 8,
            "level" => "1",
            "count" => 12
        ];
        for ($j = 1; $j < $curriculum["count"]+1; $j++) {
            $str = "/data/position/1/".(string)$name[$j-1];
            if ($type[$j-1] == 4) {
                $left = [$str.".1.jpg", $str.".2.jpg"];
                $right = [$str."a.jpg", $str."b.jpg"];
                $question = [
                    "left" => $left,
                    "right" => $right
                ];

                $answer = [
                    [$str.".1.jpg", $str."a.jpg"],
                    [$str.".2.jpg", $str."b.jpg"],
                ];

            } else {
                $left = [$str.".1.jpg", $str.".2.jpg", $str.".3.jpg"];
                $right = [$str."a.jpg", $str."b.jpg", $str."c.jpg"];
                $question = [
                    "left" => $left,
                    "right" => $right
                ];

                $answer = [
                    [$str.".1.jpg", $str."a.jpg"],
                    [$str.".2.jpg", $str."b.jpg"],
                    [$str.".3.jpg", $str."c.jpg"]
                ];
            }

            DB::beginTransaction();
            try {
                Question::create([
                    "curriculum_id" => $curriculum["id"], #level3
                    "index" => $j,
                    "question" => \GuzzleHttp\json_encode($question),
                    "correct_answer" => \GuzzleHttp\json_encode($answer),
                ]);
                DB::commit();
            } catch(Exception $e) {
                DB::rollback();
            }
        }

    }
}
