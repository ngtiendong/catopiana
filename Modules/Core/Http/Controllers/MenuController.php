<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Models\Menu;
use Modules\Core\Models\MenuType;

class MenuController extends Controller
{
    /**
     * List menu
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $typeId = $request->get('type');

        if (!empty($typeId)) {
            $menuType = MenuType::find($typeId);

            $menus = Menu::where('type_id', $typeId)->paginate(15);
        }
        // Get list menu type
        $menuTypes = MenuType::getListActive();

        return view('core::menu.index', compact('menuType', 'menuTypes', 'menus'));
    }

    /**
     * Add new menu
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $menuTypeId = $request->get('type');

        if ($menuTypeId) {
            // Get menu type
            $menuType = MenuType::find($menuTypeId);
        } else {
            // todo: require a type
        }

        return view('core::menu.create', compact('menuType'));
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
            'title'   => 'required',
            'status'  => 'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();

            return Redirect::route('core.menu.create')->withErrors([$message->first()]);
        }

        $result = Menu::create([
            'type_id'       => $params["type"],
            'title'         => isset($params["title"]) ? $params["title"] : null,
            'external_url' => isset($params["external_url"]) ? $params["external_url"] : null,
            'status'        => $params["status"]
        ]);

        return redirect(route('core.menu.index', ['type' => $params['type']]));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);

        $menuType = MenuType::find($menu->type_id);

        return view('core::menu.edit', compact('menu', 'menuType'));
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
            'title'   => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.menu.edit', $id)->withErrors([$message->first()]);
        }

        $obj = Menu::where("id", $id)->first();

        if ($obj) {
            $obj->title        = isset($params["title"]) ? $params["title"] : null;
            $obj->external_url = isset($params["external_url"]) ? $params["external_url"] : null;
            $obj->status = $params["status"];
            $obj->save();

            return redirect(route('core.menu.index', ['type' => $obj->type_id]));
        } else {
            return Redirect::route('core.menu.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = Menu::where("id", $id)->first();
        if ($obj) {
            $obj->status = Menu::STATUS_DELETED;
            $obj->save();

            return redirect(route('core.menu.index', ['type' => $obj->type_id]));
        } else {
            return Redirect::route('core.menu.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }
}
