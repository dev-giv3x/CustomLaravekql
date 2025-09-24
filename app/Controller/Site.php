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
        return new View('site.hello', ['message' => 'Добро пожаловать в библиотечную систему.']);
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

        $borrowedBooks = BorrowedBook::with(['book', 'reader.user'])->whereNull('date_return')->get();


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
        $books = Book::get(['id','title']);
        $users = User::where('role_id', 3)->get();
//        var_dump($request->all());

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

    public function returnBook(Request $request): string
    {
        $users = User::where('role_id', 3)->get();

        $activeUsers = [];

        foreach ($users as $user) {
            $reader = Reader::where('user_id', $user->id)->first();
            if (!$reader) continue;

            $borrowed = BorrowedBook::where('book_id', $reader->id)->whereNull('date_return')->get();

            if(count ($borrowed) > 0) {
                    $activeUsers[] = $user;
                }

        }

        return new View('site.returnBook', ['users'=>$users]);
    }

    public function checkBorrowedBooks(): string
    {

        $uri = $_SERVER['REQUEST_URI'];
        $parts = explode('/', trim($uri, '/'));
        $userId = isset($parts[3]) ? (int)$parts[3] : null;

        $reader = Reader::where('user_id', $userId)->first();
        $books = [];

        if ($reader) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
                $bookId = (int)$_POST['book_id'];

                $borrow = BorrowedBook::where('reader_id', $reader->id)->where('book_id', $bookId)->whereNull('date_return')->first();

                if ($borrow) {
                    $borrow->date_return = date('Y-m-d');
                    $borrow->save();
                }
            }

            $books = BorrowedBook::where('reader_id', $reader->id)->whereNull('date_return')->get();
        }

        return new View('site.checkBorrowedBooks', ['books'=>$books,'userId'=>$userId]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}