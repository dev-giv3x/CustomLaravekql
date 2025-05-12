<?php
use Src\Route;

Route::add('go', [Controller\Site::class, 'index']);
Route::add('hello', [Controller\Site::class, 'hello']);