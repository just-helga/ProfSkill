<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //---Регистрация
    public function Registration(Request $request) {
        $validate = Validator::make($request->all(),[
            'name' => ['required', 'regex:/[А-Яа-яЁё-]/u'],
            'surname' => ['required', 'regex:/[А-Яа-яЁё-]/u'],
            'patronymic' => ['nullable', 'regex:/[А-Яа-яЁё-]/u'],
            'email' => ['required', 'email:frs', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'rules'=> ['required']
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Может содержать только кириллицу, пробел и тире',
            'surname.required' => 'Обязательное поле',
            'surname.regex' => 'Может содержать только кириллицу, пробел и тире',
            'patronymic.regex' => 'Может содержать только кириллицу, пробел и тире',
            'email.required'=>'Обязательное поле',
            'email.email'=>'Поле должно содержать адрес электронной почты',
            'email.unique'=>'Пользователь с указанным адресом электронной почты уже зарегистрирован',
            'password.required'=>'Обязательное поле',
            'password.min'=>'Минимальная длина пароля 6 симоволов',
            'password.confirmed'=>'Пароли не совпадают',
            'rules.required'=>'Поставьте галочку для согласие обработки персональных данных',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = new User();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->patronymic = $request->patronymic;
        $user->email = $request->email;
        $user->password = md5($request->password);

        $user->save();
        return redirect()->route('login');
    }
    //---Вход
    public function Authorization(Request $request) {
        $validate = Validator::make($request->all(),[
            'email' => ['required'],
            'password' => ['required'],
        ],[
            'email.required'=>'Обязательное поле',
            'password.required'=>'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::query()
            ->where('email', $request->email)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('PersonalAccountPage');
        } else {
            return response()->json('Неверный логин или пароль', 403);
        }
    }
    //---Выход
    public function Exit() {
        Auth::logout();
        return redirect()->route('login');
    }
    //---Изменение фото профиля
    public function ImgAdd(Request $request) {
        $validate = Validator::make($request->all(), [
            'img'=>['required']
        ],[
            'img.required'=>'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::query()
            ->where('id', Auth::id())
            ->first();

        $path_img = '';
        if ($request->file()) {
            $path_img = $request->file('img')->store('/public/img/users');
            $user->img = '/public/storage/' . $path_img;
        }

        $user->update();
        return redirect()->route('PersonalAccountPage');
    }
    //---Удаление  фото профиля
    public function ImgDelete() {
        $user = User::query()
            ->where('id', Auth::id())
            ->first();

        $user->img = null;
        $user->update();
        return redirect()->route('PersonalAccountPage');
    }
}
