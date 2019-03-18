<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Lib\NewsService;
use Modules\Core\Lib\PushNotification;
use Modules\Core\Lib\PushNotificationHelper;
use Modules\Core\Lib\SendSMS;
use Modules\Insurance\Models\Customer;
use Modules\Insurance\Models\CustomerType;
use Modules\Insurance\Models\InsuranceAgency;
use Modules\Insurance\Models\InsuranceContract;
use Carbon\Carbon;
use Modules\Insurance\Models\InsuranceQuotation;
use Modules\Insurance\Models\InsuranceType;
use Modules\Insurance\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        //end report type and source
        return view('core::index');
    }

    /**
     * Generate random color hex
     */
    public function generateRandomColor($num)
    {
        $colorArray = [];
        for ($i=0; $i<$num; $i++) {
            $colorArray[] = '#'.dechex(rand(0x000000, 0xFFFFFF));
        }
        return $colorArray;
    }

    /**
     * Get article detail
     */
    public function getArticleDetail(Request $request)
    {
        $data = $request->all();
        $newsService = new NewsService();
        $data = $newsService->getDetail($data['id']);
        echo $data;
    }

    /**
     * Call modal display article detail
     */
    public function modalArticleDetail(Request $request)
    {
        return view('core::modalArticleDetail');
    }

    /**
     * Convert report month
     */
    public function convertReportMonth($data)
    {
        $rs = [];
        foreach ($data as $key => $value) {
            if (!empty($key)) {
                $keyArray = explode('-', $key);
                $keyConvert = $keyArray[1].'/'.$keyArray[0];
                $rs[$keyConvert] = $value;
            }
        }
        return $rs;
    }

}
