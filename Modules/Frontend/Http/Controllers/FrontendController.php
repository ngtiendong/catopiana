<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Frontend\Entities\Question;
use Modules\Frontend\Entities\Report;
use Modules\Frontend\Entities\Topic;
use Modules\Frontend\Services\PackageService;
use Modules\Frontend\Services\LocalStorageService;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    protected $packageService;
    protected $localStorageService;

    public function __construct(LocalStorageService $localStorageService, PackageService $packageService)
    {
        $this->localStorageService = $localStorageService;
        $this->packageService = $packageService;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
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
     * Display a music page
     * @return Response
     */
    public function free()
    {
        $type_and_topic = $this->getTopicAndTypeId(\Illuminate\Support\Facades\Route::currentRouteName());
        return view('frontend::test_free', compact('type_and_topic'));
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

            if ($params['type'] == "1"){
                //Audio
                $raw_data = Question::getListQuestionAudio($params['topic'], $params['level']);
            }elseif ($params['type'] == "2") {
                //Position
                $raw_data = Question::getListQuestionPosition($params['topic'], $params['level']);
            }elseif ($params['type'] == "4") {
                //iq
                $raw_data = Question::getListQuestionIq($params['topic'], $params['level']);
            }elseif ($params['type'] == "-1") {
                //free
                $raw_data = Question::getListQuestionFree($params['topic']);
            }
            else {
                $raw_data = Question::getListQuestion($params['topic'], $params['level']);
            }

            return [
                'status' => 1,
                'question_data' => $raw_data['raw_data'],
                'type' => $raw_data['type'],
                'result' => $raw_data['result'],
                'curriculum_id' => $raw_data['curriculum_id'],
                'video' => $raw_data['video']
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
            if ($params['type'] == "1"){
                //Audio
                $raw_data = Question::getLessLevelQuestionAudio($params['topic'], $params['level'], $params['index']);

            } elseif($params['type'] == "2") {
                //Position
                $raw_data = Question::getLessLevelQuestionPosition($params['topic'], $params['level'], $params['index']);
            } elseif($params['type'] == "4") {
                //Iq
                $raw_data = Question::getLessLevelQuestionIq($params['topic'], $params['level'], $params['index']);
            }
            else {
                $raw_data = Question::getLessLevelQuestion($params['topic'], $params['level'], $params['index']);
            }
            if (!empty($raw_data['raw_data'])) {
                return [
                    'status' => 1,
                    'question_data' => $raw_data['raw_data'],
                    'type' => $raw_data['type'],
                    'result' => $raw_data['result'],
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
        // sửa lại position <-> common 
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
                    'type' => "4"
                ];
                break;
            case 'creative':
                return [
                    'topic' => "3",
                    'type' => "5"
                ];
                break;
            case 'difference':
                return [
                    'topic' => "4",
                    'type' => "5"
                ];
                break;
            case 'common':
                return [
                    'topic' => "8",
                    'type' => "2"
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
                    'type' => "1"
                ];
                break;
            case 'position':
                return [
                    'topic' => "5",
                    'type' => "0"
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

            case 'free-test':
                return [
                    'topic' => "15",
                    'type' => "-1"
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
        /**
         * IQ
         */
        $all = ["a", "b", "c", "d", "e", "f", "g", "h"];
        $correct = ["c", "e", "a", "b", "c", "e", "f", "d", "a", "c", "c", "d", "b", "d", "a", "e", "d", "b"
        , "f", "e", "c", "b", "a", "d", "a", "g", "b", "c", "f", "g"];
        $curriculum = [
            "id" => 2,
            "level" => "1",
            "count" => 30
        ];
        for ($j = 24; $j < $curriculum["count"] + 1; $j++) {
            $temp = [];
            foreach ($all as $value ) {
                if ($value !== $correct[$j-1]) {
                    $temp[] = "/data/iq/1/" . (string)$j.$value.".jpg";
                }
            }
            Question::create([
                "curriculum_id" => 2,
                "index" => $j,
                "question" => "/data/iq/". $curriculum["level"] . "/" . (string)$j . ".jpg",
                "correct_answer" => "/data/iq/1". $curriculum["level"] . "/" . (string)$j.$correct[$j-1] . ".jpg",
                "wrong_answer" => \GuzzleHttp\json_encode($temp)
            ]);
        }

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
//                $questions = Question::whereIn('curriculum_id', [4,21,22])->get();
//                for ($t=0; $t < count($questions); $t++) {
//                    $questions[$t]->question = $questions[$t]->correct_answer;
//                    $questions[$t]->save();
//                }
////                dd($questions);
////                Question::create([
////                    "curriculum_id" => $curriculum["id"], #level3
////                    "index" => $j,
////                    "correct_answer" => "/data/difference/" . $curriculum["level"] . "/" . (string)$j . $correct[$j - 1] . ".jpg",
////                    "wrong_answer" => \GuzzleHttp\json_encode([$temp, $temp, $temp])
////                ]);
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

//        $type = [6,4,4,4,4,4,4,4,6,4,4,4];
//        $name = [1,2,3,4,7,8,9,11,12,13,14,15];
//
//        $curriculum = [
//            "id" => 8,
//            "level" => "1",
//            "count" => 12
//        ];
//        for ($j = 1; $j < $curriculum["count"]+1; $j++) {
//            $str = "/data/position/1/".(string)$name[$j-1];
//            if ($type[$j-1] == 4) {
//                $left = [$str.".1.jpg", $str.".2.jpg"];
//                $right = [$str."a.jpg", $str."b.jpg"];
//                $question = [
//                    "left" => $left,
//                    "right" => $right
//                ];
//
//                $answer = [
//                    [$str.".1.jpg", $str."a.jpg"],
//                    [$str.".2.jpg", $str."b.jpg"],
//                ];
//
//            } else {
//                $left = [$str.".1.jpg", $str.".2.jpg", $str.".3.jpg"];
//                $right = [$str."a.jpg", $str."b.jpg", $str."c.jpg"];
//                $question = [
//                    "left" => $left,
//                    "right" => $right
//                ];
//
//                $answer = [
//                    [$str.".1.jpg", $str."a.jpg"],
//                    [$str.".2.jpg", $str."b.jpg"],
//                    [$str.".3.jpg", $str."c.jpg"]
//                ];
//            }
//
//            DB::beginTransaction();
//            try {
//                Question::create([
//                    "curriculum_id" => $curriculum["id"], #level3
//                    "index" => $j,
//                    "question" => \GuzzleHttp\json_encode($question),
//                    "correct_answer" => \GuzzleHttp\json_encode($answer),
//                ]);
//                DB::commit();
//            } catch(Exception $e) {
//                DB::rollback();
//            }
//        }

        /**
         * Creative
         */

//         $curriculum = [
//             "id" => 3,
//             "level" => "1",
//             "count" => 10
//         ];
//         for ($j = 1; $j < $curriculum["count"]+1; $j++) {

//             DB::beginTransaction();
//             try {
// //                $questions = Question::whereIn('curriculum_id', [4,21,22])->get();
// //                for ($t=0; $t < count($questions); $t++) {
// //                    $questions[$t]->question = $questions[$t]->correct_answer;
// //                    $questions[$t]->save();
// //                }
// //                dd($questions);
//                 $temp = [];
//                 for ($k=1; $k<7; $k++) {
//                     $temp[] = "/data/creative/1/".$j."/".$k.".jpg";
//                 }
//                 Question::create([
//                     "curriculum_id" => $curriculum["id"], #level3
//                     "index" => $j,
//                     "correct_answer" => \GuzzleHttp\json_encode([]),
//                     "wrong_answer" => \GuzzleHttp\json_encode($temp)
//                 ]);
//                 DB::commit();
//             } catch(Exception $e) {
//                 DB::rollback();
//             }

//         }
     #normal
    // $all = ["A", "B", "C"];
    // $correct1 = ["B", "A", "C", "C", "A", "B", "C", "A", "C", "B"];
    //    for ($j = 1; $j < 11; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct1[$j-1]) {
    //                $temp[] = "/data/test_free/common/easy/" . (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 0,
    //            "index" => $j,
    //            "question" => "/data/test_free/common/easy/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/common/easy/" . (string)$j.$correct1[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
    // $correct2 = ["A", "B", "A", "B", "C", "B"];
    // for ($j = 1; $j < 7; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct2[$j-1]) {
    //                $temp[] = "/data/test_free/common/medium/" . (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //             "question_type" => 0,
    //            "index" => 10 + $j,
    //            "question" => "/data/test_free/common/medium/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/common/medium/" . (string)$j.$correct2[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }

    // $correct3 = ["B", "A", "C", "A", "B", "A", "B", "A", "C", "B"];
    //    for ($j = 1; $j < 11; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct3[$j-1]) {
    //                $temp[] = "/data/test_free/common/hard/" . (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //                           "question_type" => 0,
    //            "index" => 16 + $j,
    //            "question" => "/data/test_free/common/hard/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/common/hard/" . (string)$j.$correct3[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
    // $correct4 = ["B", "B", "A", "C", "B", "A", "A", "C", "A", "B"];
    //    for ($j = 1; $j < 11; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct4[$j-1]) {
    //                $temp[] = "/data/test_free/common/mix/" . (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //                           "question_type" => 0,
    //            "index" => 26 + $j,
    //            "question" => "/data/test_free/common/mix/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/common/mix/" . (string)$j.$correct4[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //     }
          #difference
      //  for ($j = 1; $j < 6; $j++) {
      //      $false = "/data/test_free/difference/easy1/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/easy1/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 36 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }

      // for ($j = 1; $j < 6; $j++) {
      //      $false = "/data/test_free/difference/easy2/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/easy2/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //          "question_type" => 5,
      //          "index" => 41 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }

      // for ($j = 1; $j < 11; $j++) {
      //      $false = "/data/test_free/difference/easy3/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/easy3/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 46 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }

      //   for ($j = 1; $j < 11; $j++) {
      //      $false = "/data/test_free/difference/easy4/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/easy4/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 56 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }
      //   for ($j = 1; $j < 5; $j++) {
      //      $false = "/data/test_free/difference/medium1/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/medium1/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 66 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }
      //   for ($j = 1; $j < 11; $j++) {
      //      $false = "/data/test_free/difference/medium2/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/medium2/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 71 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }
      //   for ($j = 1; $j < 11; $j++) {
      //      $false = "/data/test_free/difference/medium3/medium+/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/medium3/medium+/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 81 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }
      //   for ($j = 1; $j < 11; $j++) {
      //      $false = "/data/test_free/difference/medium3/medium++/" . (string)$j.'F.png';
      //      $true = "/data/test_free/difference/medium3/medium++/" . (string)$j.'T.png';
      //      Question::create([
      //          "curriculum_id" => 15,
      //           "question_type" => 5,
      //          "index" => 91 + $j,
      //          "correct_answer" => $true,
      //          "wrong_answer" => \GuzzleHttp\json_encode([$false, $false, $false])
      //      ]);
      //  }
      // #memory
    //   $all = ["A", "B", "C"];
    //    $correct = ["B", "A", "A", "B", "C"];
    //    for ($j = 1; $j < 6; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct[$j-1]) {
    //                $temp[] = "/data/test_free/memory/easy/". (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 101+ $j,
    //            "question" => "/data/test_free/memory/easy/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/memory/easy/". (string)$j . $correct[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }

    // $correct = ["A", "B", "B", "A", "C"];
    //    for ($j = 1; $j < 6; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct[$j-1]) {
    //                $temp[] = "/data/test_free/memory/medium1/". (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 106+ $j,
    //            "question" => "/data/test_free/memory/medium1/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/memory/medium1/". (string)$j . $correct[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
    // $correct = ["B", "C", "A"];
    //    for ($j = 1; $j < 4; $j++) {
    //        $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct[$j-1]) {
    //                $temp[] = "/data/test_free/memory/medium2/". (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 111 + $j,
    //            "question" => "/data/test_free/memory/medium2/" . (string)$j . ".png",
    //            "correct_answer" => "/data/test_free/memory/medium2/". (string)$j . $correct[$j-1] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }

    //    for ($j = 1; $j < 13; $j++) {
    //        $temp = [];
    //        $temp = ["/data/test_free/memory/mix/Easy/". (string)$j."c.png", "/data/test_free/memory/mix/Easy/". (string)$j."d.png"];
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 114 + $j,
    //            "question" => "/data/test_free/memory/mix/Easy/" . (string)$j . "a,b.png",
    //            "correct_answer" => "/data/test_free/memory/mix/Easy/". (string)$j . "a,b.png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
    //     for ($j = 1; $j < 16; $j++) {
    //        $temp = [];
    //        $temp = ["/data/test_free/memory/mix/Master/". (string)$j."c.png", "/data/test_free/memory/mix/Master/". (string)$j."d.png"];
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 126 + $j,
    //            "question" => "/data/test_free/memory/mix/Master/" . (string)$j . "a,b.png",
    //            "correct_answer" => "/data/test_free/memory/mix/Master/". (string)$j . "a,b.png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }

    //    for ($j = 1; $j < 16; $j++) {
    //        $temp = [];
    //        $temp = ["/data/test_free/memory/mix/Medium2/". (string)$j."c.png", "/data/test_free/memory/mix/Medium2/". (string)$j."d.png"];
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 141 + $j,
    //            "question" => "/data/test_free/memory/mix/Medium2/" . (string)$j . "a,b.png",
    //            "correct_answer" => "/data/test_free/memory/mix/Medium2/". (string)$j . "a,b.png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
    //    // 
    //     $all = ['a','b','c'];
    //     $correct = ['c','a','a','b','a','a','a','a','a','a','a','a'];
    //   for ($j = 4; $j < 16; $j++) {
    //         $temp = [];
    //        foreach ($all as $value ) {
    //            if ($value !== $correct[$j-4]){ 
    //                $temp[] = "/data/test_free/memory/mix/Medium1/" . (string)$j.$value.".png";
    //            }
    //        }
    //        Question::create([
    //            "curriculum_id" => 15,
    //            "question_type" => 3,
    //            "index" => 156 + $j - 3,
    //            "question" => "/data/test_free/memory/mix/Medium1/" . (string)$j.  ".png",
    //            "correct_answer" => "/data/test_free/memory/mix/Medium1/". (string)$j .$correct[$j-4] . ".png",
    //            "wrong_answer" => \GuzzleHttp\json_encode($temp)
    //        ]);
    //    }
           #position
       // $type = [6,4,4,4,4];
       // $name = [1,2,3,4,5];

       // for ($j = 1; $j < 6; $j++) {
       //     $str = "/data/test_free/position/1/".(string)$name[$j-1];
       //     if ($type[$j-1] == 4) {
       //         $left = [$str.".1.jpg", $str.".2.jpg"];
       //         $right = [$str."a.jpg", $str."b.jpg"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.jpg", $str."a.jpg"],
       //             [$str.".2.jpg", $str."b.jpg"],
       //         ];

       //     } else {
       //         $left = [$str.".1.jpg", $str.".2.jpg", $str.".3.jpg"];
       //         $right = [$str."a.jpg", $str."b.jpg", $str."c.jpg"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.jpg", $str."a.jpg"],
       //             [$str.".2.jpg", $str."b.jpg"],
       //             [$str.".3.jpg", $str."c.jpg"]
       //         ];
       //     }

       //     DB::beginTransaction();
       //     try {
       //         Question::create([
       //             "curriculum_id" => 15,
       //             "question_type" => 2,
       //             "index" => 168 + $j,
       //             "question" => \GuzzleHttp\json_encode($question),
       //             "correct_answer" => \GuzzleHttp\json_encode($answer),
       //         ]);
       //         DB::commit();
       //     } catch(Exception $e) {
       //         DB::rollback();
       //     }
       // }

       

       // $type = [4,4,4,4,4,4,4,4,4,4,4];
       // $name = [1,2,3,4,5,6,7,8,9,10,11];

       // for ($j = 1; $j < 6; $j++) {
       //     $str = "/data/test_free/position/2/".(string)$name[$j-1];
       //     if ($type[$j-1] == 4) {
       //         $left = [$str.".1.png", $str.".2.png"];
       //         $right = [$str."a.png", $str."b.png"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.png", $str."a.png"],
       //             [$str.".2.png", $str."b.png"],
       //         ];

       //     } else {
       //         $left = [$str.".1.png", $str.".2.png", $str.".3.png"];
       //         $right = [$str."a.png", $str."b.png", $str."c.png"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.png", $str."a.png"],
       //             [$str.".2.png", $str."b.png"],
       //             [$str.".3.png", $str."c.png"]
       //         ];
       //     }

       //     DB::beginTransaction();
       //     try {
       //         Question::create([
       //             "curriculum_id" => 15, 
       //             "question_type" => 2,
       //             "index" => 173 + $j,
       //             "question" => \GuzzleHttp\json_encode($question),
       //             "correct_answer" => \GuzzleHttp\json_encode($answer),
       //         ]);
       //         DB::commit();
       //     } catch(Exception $e) {
       //         DB::rollback();
       //     }
       // }

       //  $type = [4,4,4,4,4,4];
       // $name = [1,2,3,4,5,6];

       // for ($j = 1; $j < 7; $j++) {
       //     $str = "/data/test_free/position/3/".(string)$name[$j-1];
       //     if ($type[$j-1] == 4) {
       //         $left = [$str.".1.jpg", $str.".2.jpg"];
       //         $right = [$str."a.jpg", $str."b.jpg"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.jpg", $str."a.jpg"],
       //             [$str.".2.jpg", $str."b.jpg"],
       //         ];

       //     } else {
       //         $left = [$str.".1.jpg", $str.".2.jpg", $str.".3.jpg"];
       //         $right = [$str."a.jpg", $str."b.jpg", $str."c.jpg"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.jpg", $str."a.jpg"],
       //             [$str.".2.jpg", $str."b.jpg"],
       //             [$str.".3.jpg", $str."c.jpg"]
       //         ];
       //     }

       //     DB::beginTransaction();
       //     try {
       //         Question::create([
       //             "curriculum_id" => 15,
       //             "question_type" => 2,
       //             "index" => 179 + $j,
       //             "question" => \GuzzleHttp\json_encode($question),
       //             "correct_answer" => \GuzzleHttp\json_encode($answer),
       //         ]);
       //         DB::commit();
       //     } catch(Exception $e) {
       //         DB::rollback();
       //     }
       // }

       //  $type = [6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,4,6];
       // $name = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];

       // for ($j = 1; $j < 18; $j++) {
       //     $str = "/data/test_free/position/4/".(string)$name[$j-1];
       //     if ($type[$j-1] == 4) {
       //         $left = [$str.".1.png", $str.".2.png"];
       //         $right = [$str."a.png", $str."b.png"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.png", $str."a.png"],
       //             [$str.".2.png", $str."b.png"],
       //         ];

       //     } else {
       //         $left = [$str.".1.png", $str.".2.png", $str.".3.png"];
       //         $right = [$str."a.png", $str."b.png", $str."c.png"];
       //         $question = [
       //             "left" => $left,
       //             "right" => $right
       //         ];

       //         $answer = [
       //             [$str.".1.png", $str."a.png"],
       //             [$str.".2.png", $str."b.png"],
       //             [$str.".3.png", $str."c.png"]
       //         ];
       //     }

       //     DB::beginTransaction();
       //     try {
       //         Question::create([
       //             "curriculum_id" => 15,
       //             "question_type" => 2,
       //             "index" => 185 + $j,
       //             "question" => \GuzzleHttp\json_encode($question),
       //             "correct_answer" => \GuzzleHttp\json_encode($answer),
       //         ]);
       //         DB::commit();
       //     } catch(Exception $e) {
       //         DB::rollback();
       //     }
       // }
        #report
        // $topic_arr = ['1'=> 'music', '2'=> 'iq', '3'=> 'creative', '4'=> 'difference', '5'=> 'common', '6'=> 'memory', '7'=> 'language', '8'=> 'position'];
        // $report_type = ['medium', 'great', 'excellent', 'genius'];
        // foreach($topic_arr as $topic_key => $topic) {
        //     foreach($report_type as $key => $report) {
        //         Report::create([
        //             'report_name' => $report . '_'. $topic . '_report',
        //             'topic_id' => $topic_key,
        //             'url_path' => 'reports/'.$topic.'/'.$report.'.pdf',
        //             'report_type' => $key + 1
        //         ]);
        //     }
        // }
    }

    public function menu()
    {
        $fruits = [
            'apple' => asset('/food/fruits/apple.png'),
            'banana' => asset('/food/fruits/banana.png'),
            'cherry' => asset('/food/fruits/cherry.png'),
            'dragonfruit' => asset('/food/fruits/dragonfruit.png'),
            'grape' => asset('/food/fruits/grape.png'),
            'lemon' => asset('/food/fruits/lemon.png'),
            'orange' => asset('/food/fruits/orange.png'),
            'strawberry' => asset('/food/fruits/strawberry.png'),
            'watermelon' => asset('/food/fruits/watermelon.png'),
        ];

        $vegetables = [
            'bellpepper' => asset('/food/vegetables/bellpepper.png'),
            'blackgarlic' => asset('/food/vegetables/blackgarlic.png'),
            'cabbage' => asset('/food/vegetables/cabbage.png'),
            'corn' => asset('/food/vegetables/corn.png'),
            'matsutake' => asset('/food/vegetables/matsutake.png'),
            'potato' => asset('/food/vegetables/potato.png'),
            'onion' => asset('/food/vegetables/onion.png'),
            'salad' => asset('/food/vegetables/salad.png'),
            'truffles' => asset('/food/vegetables/truffles.png'),
        ];

        $grains = [
            'bulgur' => asset('/food/grains/bulgur.png'),
            'sago' => asset('/food/grains/sago.png'),
            'guinoa' => asset('/food/grains/guinoa.png'),
            'corn' => asset('/food/grains/corn.png'),
            'ryebread' => asset('/food/grains/ryebread.png'),
            'oats' => asset('/food/grains/oats.png'),
            'teff' => asset('/food/grains/teff.png'),
            'wheat' => asset('/food/grains/wheat.png'),
            'rice' => asset('/food/grains/rice.png'),
        ];

        $dairyfood = [
            'butter' => asset('/food/dairyfood/butter.png'),
            'cheese' => asset('/food/dairyfood/cheese.png'),
            'gelato' => asset('/food/dairyfood/gelato.png'),
            'labneh' => asset('/food/dairyfood/labneh.png'),
            'milk' => asset('/food/dairyfood/milk.png'),
            'milkpowder' => asset('/food/dairyfood/milkpowder.png'),
            'milkprotein' => asset('/food/dairyfood/milkprotein.png'),
            'wheypowder' => asset('/food/dairyfood/wheypowder.png'),
            'yogurt' => asset('/food/dairyfood/yogurt.png'),
        ];

        $proteinfood = [
            'beef' => asset('/food/proteinfood/beef.png'),
            'chicken' => asset('/food/proteinfood/chicken.png'),
            'egg' => asset('/food/proteinfood/egg.png'),
            'fisheggs' => asset('/food/proteinfood/fisheggs.png'),
            'kobebeef' => asset('/food/proteinfood/kobebeef.png'),
            'pork' => asset('/food/proteinfood/pork.png'),
            'pufferfish' => asset('/food/proteinfood/pufferfish.png'),
            'salmon' => asset('/food/proteinfood/salmon.png'),
            'tilapia' => asset('/food/proteinfood/tilapia.png'),
            'tuna' => asset('/food/proteinfood/tuna.png'),
            'wagyubeef' => asset('/food/proteinfood/wagyubeef.png'),
        ];

        return view('frontend::menu', compact('fruits', 'vegetables', 'grains', 'dairyfood', 'proteinfood'));
    }

    public function saveGuestTesing(Request $request)
    {
        $local_storage = $request->input('local_storage');
        $guest_id = $local_storage['guest_id'];
        $storage_response = [];
        if($local_storage['guest_id'] == '0') {
            $guest_id = $this->localStorageService->saveNewGuestTesting($local_storage);
            $storage_response = $this->localStorageService->getTesting($guest_id);
        }

        return  response()->json([
                'status'=> '1',
                'guest_id' => $guest_id,
                'local_storage' => $storage_response
                ], 200);
    }

    public function updateGuestDataTesting(Request $request)
    {
        $testing_id = '';
        if($request->input('local_storage_this_question') != '' || $request->input('local_storage_this_question') != null)
        {
            $testing_id = $this->localStorageService->updateThisQuestion($request->input('local_storage_this_question'), $request->input('level'), $request->input('received_free_package_status'), $request->input('guest_id'));
        }

        return response()->json([
            'status' => 200,
            'customer_testing_id' => $testing_id
        ],200);
    }

    public function resetDataServer(Request $request)
    {
        if ($request->init == 1) {
            $this->localStorageService->removeLocalStorateDB($request->guest_id);
        } else {
            $this->localStorageService->removeLocalStorateFreeTest($request->guest_id);
        }

        return  response()->json([
            'status'=> '1',
            ], 200);
    }
    public function updateReceivePackageStatus(Request $request)
    {
        $this->localStorageService->updateReceivePackageStatus($request->guest_id);

        return  response()->json([
            'status'=> '1',
            ], 200);
    }

    public function report($topic)
    {
        $topic = $topic;
        return view('frontend::report', compact('topic'));
    }
    public function downloadReport(Request $request)
    {
        $report = Report::getReport($request->input('total_question'), $request->input('result'), $request->input('topic'));
        $headers = array('Content-Type: application/pdf',);
        return response()->download($report->url_path, $report->report_name.'.pdf',$headers);
    }
    public function readReport(Request $request)
    {
        $report = Report::getReport($request->input('total_question'), $request->input('result'), $request->input('topic'));
        return redirect($report->url_path);
    }
}
