<?php

namespace Controller;

use Model\Book;
use Model\BorrowedBook;
use Model\Reader;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class LibrarianController
{
    public function librarian(Request $request): string {

        $user = Auth::user();
        $roleId = (int)$user->role_id;
        $users = User::where('role_id', 3)->pluck('login')->toArray();

        $books = Book::pluck('title')->toArray();

        $borrowedBooks = BorrowedBook::with(['book', 'reader.user'])->whereNull('date_return')->get();


        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        return new View('site.librarian_panel', ['users' => $users, 'books' => $books, 'borrowedBooks' => $borrowedBooks] );
    }

    public function addBook(Request $request): string
    {
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($roleId !== 2) {
            return new View('site.addBook', [
                'message' => 'У вас нет прав для добавления книги'
            ]);
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'title' => ['required'],
                'author' => ['required'],
                'year_public' => ['required', 'regex:/^\d{4}$/'],
                'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Поле :field должно быть уникально',
                'year_public.regex' => 'Год должен состоять только из цифр',
                'price.regex' => 'Цена должна состоять только из цифр'
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

                return new View('site.addBook', [
                    'message' => $firstMessage
                ]);
            }

            $data = $request->all();

            if (!empty($data['image']['tmp_name'])) {
                $file = $data['image'];
                $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

                if (in_array($file['type'], $allowed)) {
                    $uploadDir = __DIR__ . '/../../public/images/';
                    $filename = uniqid() . '_' . basename($file['name']);
                    move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
                    $data['image_path'] = '/images/' . $filename;
                }
            }

            $message = Book::create($data) ? 'Книга успешно создана!' : 'Ошибка при создании книги';

            return new View('site.addBook', ['message' => $message]);
        }

        return new View('site.addBook');
    }


    public function addReader(Request $request): string
    {
        $users = User::where('role_id', 4)->get(['id', 'login']);
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'ticket_number' => ['required', 'regex:/^\d{6}$/'],
                'firstname' => ['required'],
                'lastname' => ['required'],
                'patronomic' => ['required'],
                'phone_number' => ['required', 'regex:/^7\d{10}$/'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Поле :field должно быть уникально',
                'ticket_number.regex' => 'Номер билета должен иметь 6 цифр',
                'phone_number.regex' => 'Номер телефона должен иметь 11 цифр и начинаться на 7'
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

                return new View('site.addReader', [
                    'users' => $users,
                    'message' => $firstMessage
                ]);
            }
            $data = $request->all();

            $reader = Reader::create($data);

            if ($reader) {
                $userToUpdate = User::find((int)$data['user_id']);
                if ($userToUpdate) {
                    $userToUpdate->role_id = 3;
                    $userToUpdate->save();
                }
            }
        }

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        return new View('site.addReader', ['users' => $users]);
    }

    public function issueBook(Request $request): string{
        $books = Book::get(['id','title']);
        $users = User::where('role_id', 3)->get();
        $user = Auth::user();
        $roleId = (int)$user->role_id;
//        var_dump($request->all());

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        if ($request->method === 'POST') {
            $bookId = (int)$_POST['book_id'];
            $userId = (int)$_POST['user_id'];

            $reader = Reader::where('user_id', $userId)->first();

            if ($reader) {
                $alreadyIssued = BorrowedBook::where('book_id', $bookId)
                    ->where('reader_id', $reader->id)
                    ->whereNull('date_return')
                    ->exists();

                if (!$alreadyIssued) {
                    BorrowedBook::create([
                        'book_id' => $bookId,
                        'reader_id' => $reader->id,
                        'date_issue' => date('Y-m-d H:i:s'),
                        'date_return' => null
                    ]);
                }
            }
        }

        return new View('site.issueBook', ['books' => $books, 'users' => $users]);
    }

    public function returnBook(Request $request): string
    {
        $users = User::where('role_id', 3)->get();
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

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
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        $books = [];

        if ($reader) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
                $bookId = (int)$_POST['book_id'];

                $borrow = BorrowedBook::where('reader_id', $reader->id)->where('book_id', $bookId)->whereNull('date_return')->first();

                if ($borrow) {
                    $borrow->date_return = date('Y-m-d H:i:s');
                    $borrow->save();
                }
            }

            $books = BorrowedBook::where('reader_id', $reader->id)->whereNull('date_return')->get();
        }

        return new View('site.checkBorrowedBooks', ['books'=>$books,'userId'=>$userId]);
    }

    public function listBorrowedBooks(Request $request): string
    {
        $users = User::where('role_id', 3)->get();
        $userId = null;
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        $query = BorrowedBook::with(['book', 'reader.user'])->whereNull('date_return');

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        if ($request->method === 'POST') {
            $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;

            if ($userId) {
                $query->whereHas('reader.user', function ($q) use ($userId) {
                    $q->where('id', $userId);
                });
            }
        }

        $borrowedBooks = $query->get();

        return new View('site.listBorrowedBook', ['borrowedBooks' => $borrowedBooks, 'userId' => $userId, 'users' => $users]);
    }

    public function readersWithBorrowedBooks(Request $request): string
    {
        $books = Book::all();
        $bookId = null;
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        $query = BorrowedBook::with(['reader.user'])->whereNotNull('date_return');

        if ($request->method === 'POST' && !empty($_POST['book_id'])) {
            $bookId = (int)$_POST['book_id'];
            $borrowedBooks = (clone $query)->where('book_id', $bookId)->get();
        } else {
            $borrowedBooks = $query->get();
        }

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }
        return new View('site.readerWithBorrowedBook', ['borrowedBooks' => $borrowedBooks, 'bookId' => $bookId, 'books' => $books]);
    }

    public function popularBooks(Request $request): string
    {
        $user = Auth::user();
        $roleId = (int)$user->role_id;

        $popularBooks = Book::withCount('borrowedBooks')->orderBydesc('borrowed_books_count')->take(10)->get();

        if ($roleId !== 2) {
            app()->route->redirect('/');
        }

        return new View('site.popularBooks', ['popularBooks' => $popularBooks]);
    }

}