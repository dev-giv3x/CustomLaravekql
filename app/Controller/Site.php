<?php

namespace Controller;

use Model\BorrowedBook;
use Model\Reader;
use Model\Role;
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
        return new View('site.hello', ['message' => 'Для получения доступа к функционалу - обратитесь к библиотекарю']);
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
            return '';
        }
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

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
    public function librarian(Request $request): string {

        $user = Auth::user();
        $roleId = (int)$user->role_id;
        $users = User::where('role_id', 3)->pluck('login')->toArray();

        $books = Book::pluck('title')->toArray();

        $borrowedBooks = BorrowedBook::with(['book', 'reader.user'])->get();


        if ($roleId !== 2) {
            app()->route->redirect('/hello');
        }

        return new View('site.librarian_panel', ['users' => $users, 'books' => $books, 'borrowedBooks' => $borrowedBooks] );
    }

    public function addBook(Request $request): string
    {
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($request->method === 'POST' && Book::create($request->all())) {
            app()->route->redirect('/hello');
        }

        if ($roleId !== 2) {
            app()->route->redirect('/hello');
        }

        return new View('site.addBook');
    }
    public function addReader(Request $request): string
    {
        $users = User::where('role_id', 4)->get(['id', 'login']);
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($request->method === 'POST' && Reader::create($request->all())) {
            app()->route->redirect('/hello');
        }

        if ($roleId !== 2) {
            app()->route->redirect('/hello');
        }

        return new View('site.addReader', ['users' => $users]);
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

        }
        if ($roleId !== 1) {
            app()->route->redirect('/hello');
        }

        return new View('site.addLibrarian', ['users' => $users, 'roles' => $roles]);

    }

    public function issueBook(Request $request): string{
        $books = Book::get(['title']);
        $users = User::where('role_id', 3)->get();

        if ($request->method === 'POST') {
            $bookId = (int)$_POST['book_id'];
            $userId = (int)$_POST['user_id'];

            $reader = Reader::where('user_id', $userId)->first();

            if ($reader) {
                BorrowedBook::create([
                    'book_id' => $bookId,
                    'reader_id' => $reader->id,
                    'date_issue' => date('Y-m-d'),
                    'date_return' => null
                ]);
            }
        }

        return new View('site.issueBook', ['books' => $books, 'users' => $users]);

    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}