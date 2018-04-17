<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function view()
    {
        $users = User::all();

        return view('user.view', compact('users'));
    }

    public function getCreate()
    {
        $roles = Role::all();

        return view('user.create', compact('roles'));
    }

    public function postCreate(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            User::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'User']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.create_success', ['name' => 'User']));

        return redirect('/backend/user');
    }

    public function getUpdate($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Exception $e) {
            flash()->error(trans('crud.not_found', ['name' => 'User']));

            return redirect()->back();
        }
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    public function postUpdate(UserRequest $request)
    {

        $input = $request->all();
        DB::beginTransaction();
        try {
            $user = User::findOrFail($input['id']);
            if ($input['password']) {
                $user->update($request->all());
            }
            $user->updateBasic($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'User']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.update_success', ['name' => 'User']));

        return redirect('/backend/user');
    }

    public function postDelete(UserRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($input['id']);
            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error(trans('crud.other', ['name' => 'User']));

            return redirect()->back()->withInput();
        }

        flash()->success(trans('crud.delete_success', ['name' => 'User']));

        return redirect('/backend/user');
    }
}