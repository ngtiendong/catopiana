<?php

namespace Modules\Core\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Session;
use Modules\Insurance\Models\Customer;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserResetPassword;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\User;
use Modules\Core\Models\Role;
use Modules\Core\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $users = User::withTrashed()->paginate();

        return view('core::user/index', [
            "params" => $params,
            "users" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('core::user/create', [
            "roles" => Role::all()->pluck("name", "id"),
            "groups" => Group::all()->pluck("name", "id")
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
        $currentUser = Auth::user();

        $validatorArray = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'fullname' => 'required',
            'phone' => 'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::back()->withInput()->withErrors([$message->first()])->with(['modal_error' => $message->first()]);
        }

        DB::beginTransaction();
        try {
            $result = User::create([
                "username" => $params["username"],
                "email" => $params["email"],
                "password" => $params["password"],
                'fullname' => $params['fullname'],
                'phone' => $params['phone']
            ]);

            $roles = isset($params["roles"]) ? $params["roles"] : [];
            $result->saveListRoles($roles);

            $groups = isset($params["groups"]) ? $params["groups"] : [];
            $result->saveListGroups($groups);

            DB::commit();
            return Redirect::route('core.user.index');
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
        $obj = User::withTrashed()->where("id", $id)->first();
        return view('core::user/edit', [
            'user' => $obj,
            'user_roles' => $obj->user_roles()->pluck("role_id")->toArray(),
            'user_groups' => $obj->user_groups()->pluck("group_id")->toArray(),
            "roles" => Role::all()->pluck("name", "id"),
            "groups" => Group::all()->pluck("name", "id")
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
        $currentUser = Auth::user();

        $validatorArray = [
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'fullname'=>'required',
            'phone'=>'required'
        ];

        $validator = Validator::make($request->all(), $validatorArray);
        if ($validator->fails()) {
            $message = $validator->errors();
            return Redirect::route('core.user.edit', $id)->withErrors([$message->first()]);
        }

        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->username = $params["username"];
            $obj->email = $params["email"];
            $obj->fullname = $params['fullname'];
            $obj->phone = $params['phone'];
            
            $obj->save();

            $roles = isset($params["roles"]) ? $params["roles"] : [];
            $obj->saveListRoles($roles);

            $groups = isset($params["groups"]) ? $params["groups"] : [];
            $obj->saveListGroups($groups);

            return Redirect::route('core.user.index');
        } else {
            return Redirect::route('core.user.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = User::where("id", $id)->first();
        if ($obj) {
            $obj->delete();

            return Redirect::route('core.user.index');
        } else {
            return Redirect::route('core.user.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @return Response
     */
    public function restore($id)
    {
        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $obj->restore();

            return Redirect::route('core.user.index');
        } else {
            return Redirect::route('core.user.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }

    /**
     * ResetPassword
     * @return Response
     */
    public function resetPassword($id)
    {
        $obj = User::withTrashed()->where("id", $id)->first();
        if ($obj) {
            $password = rand(10000, 999999);
            $obj->password = $password;
            Mail::to($obj->email)->send(new UserResetPassword($obj, $password));
            $obj->save();

            Session::flash('header_message', trans('insurance::general.reset_password_user_success'));

            return Redirect::route('core.user.index');
        } else {
            return Redirect::route('core.user.index')->withErrors(["Bản ghi không tồn tại!"]);
        }
    }
    
    /**
     * Move manager customer page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function move(Request $request){
        if(isset($_POST['new_user_id'])){
            $result = array('err'=>0, 'msg'=>'Cập nhật thành công');
            $data = $request->only(['new_user_id', 'old_user_id']);
            if(empty($data['new_user_id']) || empty($data['old_user_id'])){
                $result['err'] = 1;
                $result['msg'] = "Bạn chưa chọn người nghỉ hoặc người thay thế";
            }else if($data['new_user_id'] == $data['old_user_id']) {
                $result['err'] = 1;
                $result['msg'] = "Người nghỉ và người thay thế phải khác nhau";
            }else{
                try {
                    Customer::where('customer_manager_id', $data['old_user_id'])->update(['customer_manager_id' => $data['new_user_id']]);
                }catch (\Exception $ex){
                    $result['err'] = 1;
                    $result['msg'] = $ex->getMessage();
                }
            }
            return \Response()->json($result);
        }else{
            $users = User::whereNull('deleted_at')->get();
            return view('core::user/move')->withUsers($users)->with('user_id', $request->user_id);
        }
    }

}
