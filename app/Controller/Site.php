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
        $books = Book::get(['id','title','image_path']);
        return new View('site.book', ['books' => $books]);
    }

    public function show(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($uri, '/'));
        $bookId = isset($parts[1]) ? (int)$parts[1] : null;

//        var_dump($bookId);

        $book = Book::find($bookId);

        return new View('site.books', ['book' => $book]);
    }


    public function signup(Request $request): string
    {

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'unique:users,login', 'regex:/^[a-zA-Z0-9_-]+$/'],
                'email' => ['required', 'regex:/^[^@\s]+@[^@\s]+\.[a-zA-Z]{2,}$/'],
                'password' => ['required', 'regex:/^.{6,}$/'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Поле :field должно быть уникально',
                'password.regex' => 'Пароль должен быть минимум 6 символов',
                'email.regex' => 'Почта должна быть формата xxxx@xxxx.xxx',
                'login.regex' => 'Логин может содержать только латинницу'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $firstMessage = '';

                foreach ($errors as $fieldErrors) {
                    if (!empty($fieldErrors)) {
                        $firstMessage = $fieldErrors[0];
                        break;
                    }
                }

                return new View('site.signup', [
                    'message' => $firstMessage
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
                $errors = $validator->errors();
                $firstMessage = '';

                foreach ($errors as $fieldErrors) {
                    if (!empty($fieldErrors)) {
                        $firstMessage = $fieldErrors[0];
                        break;
                    }
                }

                return new View('site.login', [
                    'message' => $firstMessage
                ]);
            }
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
            return '';
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }
}