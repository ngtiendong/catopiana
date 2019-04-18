<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\Entities\Question;
use Modules\Frontend\Services\PackageService;

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
        $freePackage = null;
        $paidPackage = null;
        if(auth()->guard('customers')->user()){
            $freePackage = $this->packageService->getFreePackage() != null ? $this->packageService->getFreePackage()->take(4) : null;
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
        $package = null;
        if(auth()->guard('customers')->user()){
            $package = $this->packageService->getFreePackage();
        }
        $free = true;
        return view('frontend::test_package',compact('package','free'));
    }

    public function getCurriculumsPaidPackage()
    {
        $package = null;
        if(auth()->guard('customers')->user()){
            $package = $this->packageService->getPaidPackage();
        }
        $free = false;
        return view('frontend::test_package',compact('package','free'));
    }

    // public function getTopicOfPackage(Request $request)
    // {
    //     $customer = auth()->guard('customers')->user();
    //     $topic_array = $this->packageService->getTopicOfPackage($customer, $request->input('curriculum_id'));
    //     return response()->json([
    //         'status' => 200,
    //         'topic_array' => $topic_array
    //     ]);
    // }
}
