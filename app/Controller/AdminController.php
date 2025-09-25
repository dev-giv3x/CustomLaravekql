<?php

namespace Controller;

use Src\Validator\Validator;
use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class AdminController
{
    public function admin(Request $request): string
    {
        $user = Auth::user();
        $roleId = (int)$user->role_id;
        $users = User::where('role_id', 2)->pluck('login')->toArray();
//        print_r($users);

        if ($roleId !== 1) {
            app()->route->redirect('/hello');
        }

        return (new View())->render('site.admin_panel', ['users' => $users]);
    }
    public function addLibrarian(Request $request): string
    {
        $users = User::get(['id', 'login']);
        $roles = Role::all();
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($request->method === 'POST') {
            $userId = (int)$_POST['user_id'];
            $roleId = (int)$_POST['role_id'];

            $user = User::find($userId);
            if ($user) {
                $user->role_id = $roleId;
                $user->save();
            }
            app()->route->redirect('/hello');

        }
        if ($roleId !== 1) {
            app()->route->redirect('/hello');
        }

        return new View('site.addLibrarian', ['users' => $users, 'roles' => $roles]);

    }

}