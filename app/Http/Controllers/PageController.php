<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Course;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //---Общие страницы
    public function MainPage() {
        return view('welcome');
    }
    public function WebinarsPageCommon() {
        return view('webinars');
    }
    public function CoursesPageCommon() {
        return view('courses');
    }
    //---Страницы гостя
    public function RegistrationPage() {
        return view('guest.registration');
    }
    public function AuthorizationPage() {
        return view('guest.authorization');
    }
    //---Страницы пользователя
    public function PersonalAccountPage() {
        $cards = Card::query()
            ->where('user_id', Auth::id())
            ->get();
        return view('user.personal_account', ['cards'=>$cards]);
    }
    public function MyOrderPage() {
        return view('user.my_orders');
    }
    //---Страницы администратора
    public function CategoryPage() {
        return view('admin.categories');
    }
    public function ThemePage() {
        return view('admin.themes');
    }
    public function SpeakerPage() {
        return view('admin.speakers');
    }
    public function CoursePage() {
        return view('admin.courses');
    }
    public function WebinarsPage() {
        return view('admin.webinars');
    }
    public function OrdersPage() {
        return view('admin.orders');
    }
}
