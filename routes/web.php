<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebinarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//--------------------------------------------------СТРАНИЦЫ--------------------------------------------------
//---Общие страницы
Route::get('/', [PageController::class, 'MainPage'])->name('MainPage');
Route::get('/webinars/common', [PageController::class, 'WebinarsPageCommon'])->name('WebinarsPageCommon');
Route::get('/courses/common', [PageController::class, 'CoursesPageCommon'])->name('CoursesPageCommon');



//---Страницы гостя
Route::get('/registration', [PageController::class, 'RegistrationPage'])->name('RegistrationPage');
Route::get('/authorization', [PageController::class, 'AuthorizationPage'])->name('login');


//---Страницы пользователя
Route::get('/personal_account', [PageController::class, 'PersonalAccountPage'])->name('PersonalAccountPage');
Route::get('/orders/user', [PageController::class, 'MyOrderPage'])->name('MyOrderPage');




//--------------------------------------------------ФУНКЦИИ--------------------------------------------------
//---Аутентификация
Route::post('/registration/save', [UserController::class, 'Registration'])->name('Registration');
Route::post('/authorization/entry', [UserController::class, 'Authorization'])->name('Authorization');
Route::get('/exit', [UserController::class, 'Exit'])->name('Exit');


//---Личный кабинет
Route::post('/card/add', [CardController::class, 'create'])->name('CardAdd');
Route::post('/card/delete', [CardController::class, 'destroy'])->name('CardDelete');

Route::post('/img/edit', [UserController::class, 'ImgAdd'])->name('ImgAdd');
Route::post('/img/delete', [UserController::class, 'ImgDelete'])->name('ImgDelete');


//---Получение данных
Route::get('/category/get', [CategoryController::class, 'index'])->name('CategoryGet');
Route::get('/themes/get', [ThemeController::class, 'index'])->name('ThemeGet');
Route::get('/speaker/get', [SpeakerController::class, 'index'])->name('SpeakerGet');
Route::get('/course/get', [CourseController::class, 'index'])->name('CourseGet');
Route::get('/webinar/get', [WebinarController::class, 'index'])->name('WebinarGet');
Route::get('/orders/get', [OrderController::class, 'index'])->name('OrderGet');


//---Оформление заказа
Route::post('/buy', [OrderController::class, 'create'])->name('Buy');




//--------------------------------------------------АДМИНКА--------------------------------------------------
Route::group(['middleware'=>['auth', 'admin'], 'prifix'=>'xxxxxx/admin'], function () {
    //---Категории
    Route::get('/catedory', [PageController::class, 'CategoryPage'])->name('CategoryPage');
    Route::post('/category/add', [CategoryController::class, 'create'])->name('CategoryAdd');
    Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('CategoryDelete');
    Route::post('/category/edit', [CategoryController::class, 'edit'])->name('CategoryEdit');
    //---Темы
    Route::get('/theme', [PageController::class, 'ThemePage'])->name('ThemePage');
    Route::post('/theme/add', [ThemeController::class, 'create'])->name('ThemeAdd');
    Route::post('/theme/delete', [ThemeController::class, 'destroy'])->name('ThemeDelete');
    Route::post('/theme/edit', [ThemeController::class, 'edit'])->name('ThemeEdit');
    //---Спикеры
    Route::get('/speaker', [PageController::class, 'SpeakerPage'])->name('SpeakerPage');
    Route::post('/speaker/add', [SpeakerController::class, 'create'])->name('SpeakerAdd');
    Route::post('/speaker/delete', [SpeakerController::class, 'destroy'])->name('SpeakerDelete');
    Route::post('/speaker/edit', [SpeakerController::class, 'edit'])->name('SpeakerEdit');
    //---Курсы
    Route::get('/course', [PageController::class, 'CoursePage'])->name('CoursePage');
    Route::post('/course/add', [CourseController::class, 'create'])->name('CourseAdd');
    Route::post('/course/delete', [CourseController::class, 'destroy'])->name('CourseDelete');
    Route::post('/course/edit', [CourseController::class, 'edit'])->name('CourseEdit');
    //---Файлы
    Route::get('/file/get', [FileController::class, 'index'])->name('FilesGet');
    Route::post('/file/add', [FileController::class, 'create'])->name('FileAdd');
    Route::post('/file/delete', [FileController::class, 'destroy'])->name('FileDelete');
    //---Вебинары
    Route::get('/webinars', [PageController::class, 'WebinarsPage'])->name('WebinarsPage');
    Route::post('/webinars/add', [WebinarController::class, 'create'])->name('WebinarAdd');
    Route::post('/webinars/delete', [WebinarController::class, 'destroy'])->name('WebinarDelete');
    Route::post('/webinars/edit', [WebinarController::class, 'edit'])->name('WebinarEdit');
    //---Заказы
    Route::get('/orders', [PageController::class, 'OrdersPage'])->name('OrdersPage');
});
