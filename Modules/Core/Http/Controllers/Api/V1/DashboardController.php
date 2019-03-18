<?php

namespace Modules\Core\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Lib\NewsService;
use Modules\Insurance\Models\Customer;
use Modules\Insurance\Models\InsuranceAgency;
use Modules\Insurance\Models\InsuranceContract;
use Carbon\Carbon;
use Modules\Insurance\Models\InsuranceQuotation;
use Modules\Insurance\Models\InsuranceType;

class DashboardController extends Controller
{
    /**
     * Check agency is company
     * If agency is company, get all data from this company's staff
     */
    public function checkAgencyIsCompany($agencyId)
    {
        $agencyInfo = InsuranceAgency::find($agencyId);
        if (!empty($agencyInfo)) {
            if ($agencyInfo->agency_company_is_manager == 1) {
                $arrayAgencyIdStaff = InsuranceAgency::select('id')
                    ->where('agency_company_id', $agencyInfo->agency_company_id)
                    ->get()
                    ->toArray();
                $arrayAgencyIdStaffConvert = [];
                if (!empty($arrayAgencyIdStaff)) {
                    foreach ($arrayAgencyIdStaff as $row) {
                        $arrayAgencyIdStaffConvert[] = $row['id'];
                    }
                }
                $arrayEmployee = $arrayAgencyIdStaffConvert;
                array_push($arrayAgencyIdStaffConvert, (int) $agencyId);
                $rs = [
                    'all' => $arrayAgencyIdStaffConvert,
                    'agency' => [(int) $agencyId],//agency
                    'agency_employee' => $arrayEmployee//employee of agency
                ];
                return $rs;
            } else {
                $arrayAgencyIdStaffConvert = [(int) $agencyId];
                $rs = [
                    'all' => $arrayAgencyIdStaffConvert,
                    'agency' => [(int) $agencyId],
                    'agency_employee' => []
                ];
                return $rs;
            }
        } else {
            return [];
        }
    }

    /**
     * Get data for agency dashboard
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $agencyId = $params['agency_id'];
        $agencyEmployee = $this->checkAgencyIsCompany($agencyId);
        $agencyIdArray = $agencyEmployee['all'];

        if (empty($agencyIdArray)) {
            return response()->json([]);
        }
        if ($request->has('start')) {
            $start = Carbon::parse($request->get('start'))->toDateString();
        } else {
            $start = Carbon::now()->startOfMonth();
        }
        if ($request->has('end')) {
            $end = Carbon::parse($request->get('end'))->addDay(1)->toDateString();
        } else {
            $end = Carbon::now()->endOfMonth();
        }
        $insuranceContractQuery = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->whereIn('sale_type_id', $agencyIdArray);
        // Block Khách hàng
        $customerQuery = Customer::whereBetween('created_at', [$start, $end])
            ->whereIn('agency_id', $agencyIdArray);
        $total_customer = $customerQuery->count();
        $kh_tiem_nang = $customerQuery->where('classify', 1)->count();
        $kh_co_hoi = $customerQuery->where('classify', 2)->count();
        $kh_mua_hang = $insuranceContractQuery->distinct('customer_id')->count();
        $kh_tai_tuc = $customerQuery->where('classify', 3)->count();
        
        // Block tuong tac
        $total_quotations = InsuranceQuotation::whereBetween('created_at', [$start, $end])
            ->whereIn('agency_id', $agencyIdArray)->count();

        // Block Doanh thu
        $contract_sale = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->whereIn('sale_type_id', $agencyIdArray)
            ->sum('require_pay_amount');
        //$contract_agence = $insuranceContractQuery->where('sale_type_id', '>', 0)->sum('require_pay_amount');
        $contract_agence = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->whereIn('sale_type_id', $agencyIdArray)
            ->sum('require_pay_amount');
        $tong_doanh_thu_hieuluc = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->where('certificate_active', 1)
            ->whereIn('sale_type_id', $agencyIdArray)
            ->sum('require_pay_amount');
        $tong_doanh_thu_khonghieuluc = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->where('certificate_active', '!=', 1)
            ->whereIn('sale_type_id', $agencyIdArray)
            ->sum('require_pay_amount');

        // Block cong no
        $congno_nhanvien = 0;
        if (!empty($agencyEmployee['agency_employee'])) {
            $paidEmployee = InsuranceContract::whereBetween('created_at', [$start, $end])
                    ->whereIn('sale_type_id', $agencyEmployee['agency_employee'])
                    ->sum('paid_amount');
            $requiredAmountEmployee = InsuranceContract::whereBetween('created_at', [$start, $end])
                ->whereIn('sale_type_id', $agencyEmployee['agency_employee'])
                ->sum('require_pay_amount');
            $congno_nhanvien = $requiredAmountEmployee - $paidEmployee;
        }

        $paidAmountAgency = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->whereIn('sale_type_id', $agencyEmployee['agency'])
            ->sum('paid_amount');
        $requiredAmountAgency = InsuranceContract::whereBetween('created_at', [$start, $end])
            ->whereIn('sale_type_id', $agencyEmployee['agency'])
            ->sum('require_pay_amount');
        $congno_daily = $requiredAmountAgency - $paidAmountAgency;

        $congno_baohiem = $congno_nhanvien + $congno_daily;
        
        // Block bieu do
        $reportInsuranceType = InsuranceType::report($start, $end, $agencyIdArray);
        $reportSource = InsuranceContract::reportBySource($start, $end, $agencyIdArray);
        
        // Block news
        $newsService = new NewsService();
        $bantins = $newsService->getList(env('NEWS-DOI-TAC-DAI-LY', 10));//for agency
        $daotaos = $newsService->getList(env('NEWS-DAO-TAO', 8));
        $huongdans = $newsService->getList(env('NEWS-HUONG-DAN-SU-DUNG', 9));
    
        // Block bieu do doanh thu
        $insuranceContract = new InsuranceContract();
        $report = $insuranceContract->reportMonth($agencyIdArray);
        $report = $this->convertReportMonth($report);

        //add report type and source
        $typeLabel = [];
        $typeData = [];
        foreach ($reportInsuranceType as $row) {
            $typeLabel[] = $row['label'];
            $typeData[] = $row['data'];
        }
        $typeColor = $this->generateRandomColor(count($typeData));
        $sourceLabel = [];
        $sourceData = [];
        foreach ($reportSource as $row) {
            $sourceLabel[] = $row['label'];
            $sourceData[] = $row['data'];
        }
        $sourceColor = $this->generateRandomColor(count($sourceData));
        //end report type and source
        
        return response()->json(compact(
            'manager',
            'agencies',
            'start',
            'end',
            'total_customer',
            'kh_tiem_nang',
            'kh_co_hoi',
            'kh_mua_hang',
            'kh_tai_tuc',
            'total_quotations',
            'contract_sale',
            'contract_agence',
            'tong_doanh_thu_hieuluc',
            'tong_doanh_thu_khonghieuluc',
            'congno_nhanvien',
            'congno_daily',
            'congno_baohiem',
            'reportInsuranceType',
            'reportSource',
            'report',
            'bantins',
            'daotaos',
            'huongdans',
            'sourceColor',
            'sourceLabel',
            'sourceData',
            'typeColor',
            'typeLabel',
            'typeData'
        ));
    }

    /**
     * Get article detail
     */
    public function getArticleDetail(Request $request)
    {
        $data = $request->all();
        $newsService = new NewsService();
        $rs = $newsService->getDetail($data['id']);
        $rsArray = json_decode($rs, true);
        return response()->json($rsArray);
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

    /**
     * Get list articles
     */
    public function getListArticle(Request $request)
    {
        $id = $request->id;
        $newsService = new NewsService();
        $listArticles = $newsService->getList($id);//for agency
        return response()->json($listArticles);
    }

    /**
     * Get number customer, agency, quotation
     */
    public function getCustomerAgencyQuotation(Request $request)
    {
        $numCustomer = Customer::where('status', Customer::STATUS_ACTIVE)->count();
        $numAgency = InsuranceAgency::where('status', Customer::STATUS_ACTIVE)->count();
        $numQuotation = InsuranceQuotation::sum('main_fee');
        $rs = [
            'num_customer' => $numCustomer,
            'num_agency' => $numAgency,
            'num_quotation' => $numQuotation
        ];
        return response()->json($rs);
    }

    /**
     * Get list article pagination
     */
    public function getListArticlePag(Request $request)
    {
        $id = $request->id;
        $params = $request->all();
        $newsService = new NewsService();
        isset($params['page']) ? $page = $params['page'] : $page = 1;
        isset($params['page_size']) ? $pageSize = $params['page_size'] : $pageSize = 10;
        isset($params['key']) ? $keySearch = $params['key'] : $keySearch = '';
        $listArticles = $newsService->getList($id, $page, $pageSize, $keySearch, 1);//for agency
        return response()->json($listArticles);
    }

}
