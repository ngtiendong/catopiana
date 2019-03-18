<?php

namespace Modules\Core\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Session;
use Validator;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Role;
use Modules\Core\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $roles = Role::withTrashed()->paginate();

        return view('core::role/index', [
            "params" => $params,
            "roles" => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::role/create', [
            'permissions' => Permission::getListPermissions()
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
            'name' => 'required|unique:roles',
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        DB::beginTransaction();
        try {
            $result = Role::create([
                "name" => $params["name"],
            ]);
            if(isset($params["permissions"]))
                $permissions = $params["permissions"];
            else
                $permissions = [];
            $result->saveListPermissions($permissions);

            DB::commit();
            return Redirect::route('core.role.index');
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
        $obj = Role::withTrashed()->where("id", $id)->first();
        return view('core::role/edit', [
            'role' => $obj,
            'role_permissions' => $obj->role_permissions()->pluck('permission_id')->toArray(),
            'permissions' => Permission::getListPermissions()
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
            'name' => 'required|unique:roles,name,'.$id,
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.role.edit', $id)->withErrors([$message->first()]);
        }

        $obj = Role::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->name = $params["name"];
            $obj->save();
            if(isset($params["permissions"]))
                $permissions = $params["permissions"];
            else
                $permissions = [];
            $obj->saveListPermissions($permissions);


            return Redirect::route('core.role.index');
        } else {
            return Redirect::route('core.role.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = Role::where("id", $id)->first();
        if ($obj) {
            $obj->delete();

            return Redirect::route('core.role.index');
        } else {
            return Redirect::route('core.role.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @return Response
     */
    public function restore($id)
    {
        $obj = Role::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->restore();

            return Redirect::route('core.role.index');
        } else {
            return Redirect::route('core.role.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }
}
