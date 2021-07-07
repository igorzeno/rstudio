<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Если авторизован, то форму не показываем
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('front.login');
    }

    // Валидация email и пароль обязательны, email согласно шаблону email
    public function store(Request $request)
    {
//        print_r($request->only('email', 'password'));
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
//echo "888"; exit();
        if (!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('status', 'Введен неверный пароль');
        }

        return redirect()->route('/');
    }
}
