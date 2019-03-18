<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Product\Libraries\FormulaParser;
use Modules\Car\Models\CarBrand;
use Modules\Car\Models\CarVehicle;
use Modules\Car\Models\CarVehiclePriceHistory;
use Modules\Insurance\Models\InsurancePriceType;
use Modules\Product\Models\InsuranceType;
use Modules\Product\Models\Category;
use Modules\Product\Models\CategoryAttribute;
use Modules\Product\Models\CategoryClass;
use Modules\Product\Models\Product;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return redirect(route('admin_home'));
    }
}
