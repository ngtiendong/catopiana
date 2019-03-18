<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\MenuType;

class MenuTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $menuTypes = MenuType::paginate(15);

        return view('core::menu_type.index', compact('menuTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::menu_type.create');
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
            'code'   => 'required',
            'name'   => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();

            return Redirect::route('core.menu_type.create')->withErrors([$message->first()]);
        }

        $result = MenuType::create([
            "code"   => $params["code"],
            "name"   => isset($params["name"]) ? $params["name"] : null,
            "status" => $params["status"]
        ]);

        return Redirect::route('core.menu_type.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $menuType = MenuType::find($id);

        return view('core::menu_type.edit', compact('menuType'));
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
            'code'   => 'required',
            'name'   => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.menu_type.edit', $id)->withErrors([$message->first()]);
        }

        $obj = MenuType::where("id", $id)->first();

        if ($obj) {
            $obj->code   = $params["code"];
            $obj->name   = isset($params["name"]) ? $params["name"] : null;
            $obj->status = $params["status"];
            $obj->save();

            return Redirect::route('core.menu_type.index');
        } else {
            return Redirect::route('core.menu_type.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = MenuType::where("id", $id)->first();
        if ($obj) {
            $obj->status = MenuType::STATUS_DELETED;
            $obj->save();

            return Redirect::route('core.menu_type.index');
        } else {
            return Redirect::route('core.menu_type.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }
}
