<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Book;
use Src\Auth\Auth;

class Site
{
    public function index(Request $request): string
    {
        $books = Book::where('id', $request->id)->get();
        return (new View())->render('site.post', ['books' => $books]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => '100% главная страница']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function admin(Request $request): string
    {
        $user = Auth::user();
        $roleId = (int)$user->role_id;
        $users = User::where('role_id', 2)->pluck('login')->toArray();
        print_r($users);

        if ($roleId !== 1) {
            app()->route->redirect('/hello');
        }

        if ($roleId === 1) {
            return new View('site.admin_panel');
        }
        return (new View())->render('site.admin_panel', ['users' => $users]);
    }
    public function librarian(): string {

        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($roleId !== 2) {
            app()->route->redirect('/hello');
        }

        if ($roleId === 2) {
            return new View('site.librarian_panel');
        }

        $users = User::where('role_id', 3)->pluck('login')->toArray();

        return new View('librarian_panel', [
            'users' => $users,
            'role_title' => 'библиотекари'
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}