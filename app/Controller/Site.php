<?php

namespace Controller;

use Src\Validator\Validator;
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
        return new View('site.hello', ['message' => 'Добро пожаловать в библиотечную систему.']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'unique:users,login', 'regex:/^[a-zA-Z0-9_-]+$/'],
                'email' => ['required'],
                'password' => ['required', 'regex:/^.{6,}$/'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Поле :field должно быть уникально',
                'password.regex' => 'Пароль должен быть минимум 6 символов'
            ]);

            if ($validator->fails()) {
                return new View('site.signup', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }

        return new View('site.signup');
    }


    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'regex:/^[a-zA-Z0-9_-]+$/'],
                'password' => ['required', 'regex:/^.{6,}$/'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
            ]);

            if ($validator->fails()) {
                return new View('site.login', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
            return '';
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}