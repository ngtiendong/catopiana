<?php

namespace Modules\Core\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Session;
use Validator;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Group;
use Modules\Insurance\Models\Company;
use Modules\Insurance\Models\InsuranceAgency;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $groups = Group::withTrashed()->paginate();

        return view('core::group/index', [
            "params" => $params,
            "groups" => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::group/create', [
            'agencies' => InsuranceAgency::pluck("name", "id"),
            'companies' => Company::pluck("name", "id")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $validatorArray = [
            'type' => 'required',
            'name' => 'required|unique:groups',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        DB::beginTransaction();
        try {
            if ($params["type"] == Group::TYPE_COMPAPNY)
                $objectIds = isset($params["companies"]) ?$params["companies"] : [];
            else
                $objectIds = isset($params["agencies"]) ?$params["agencies"] : [];
            $result = Group::create([
                "type" => $params["type"],
                "name" => $params["name"],
                "object_ids" => implode(",", $objectIds),
            ]);

            DB::commit();
            return Redirect::route('core.group.index');
        } catch (\Exception $e) {
            DB::rollback();
            Log::alert($e);
            return Redirect::back()->withInput()->withErrors(["Lỗi không lưu được bản ghi!"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $obj = Group::withTrashed()->where("id", $id)->first();
        return view('core::group/edit', [
            'group' => $obj,
            'objectIds' => array_map('intval', explode(",", $obj->object_ids)),
            'agencies' => InsuranceAgency::pluck("name", "id"),
            'companies' => Company::pluck("name", "id")
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();

        $validatorArray = [
            'type' => 'required',
            'name' => 'required|unique:groups,name,'.$id,
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.group.edit', $id)->withErrors([$message->first()]);
        }

        $obj = Group::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->name = $params["name"];
            $obj->type = $params["type"];
            if ($params["type"] == Group::TYPE_COMPAPNY)
                $objectIds = isset($params["companies"]) ?$params["companies"] : [];
            else
                $objectIds = isset($params["agencies"]) ?$params["agencies"] : [];
            $obj->object_ids = implode(",", $objectIds);
            $obj->save();

            return Redirect::route('core.group.index');
        } else {
            return Redirect::route('core.group.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = Group::where("id", $id)->first();
        if ($obj) {
            $obj->delete();

            return Redirect::route('core.group.index');
        } else {
            return Redirect::route('core.group.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @return Response
     */
    public function restore($id)
    {
        $obj = Group::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->restore();

            return Redirect::route('core.group.index');
        } else {
            return Redirect::route('core.group.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }
}
