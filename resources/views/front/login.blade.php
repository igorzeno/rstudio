@extends('layouts.app')

@section('title', 'Войти на сайт')

@section('custom_js')
@endsection

@section('custom_css')
    <link rel="stylesheet" href="/css/account.css?<?=mt_rand()?>" />
@endsection

@section('content')
    <main>
        <div><h1 class="">Войти</h1></div>
        <div class="one__mes">
            <div class="account">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    @if (session('status'))
                        <div class="login__text-red">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="">
                        <label for="email" class="account__label required">E-mail</label>
                        <input type="text" value="" name="email" id="email" class="account__input @error('email') border-red @enderror">
                        @error('email')
                        <div class="text-red">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="">
                        <label for="passwd" class="account__label required">Пароль</label>
                        <input value="" type="password" name="password" id="password" class="account__input @error('password') border-red @enderror">
                        @error('password')
                        <div class="text-red">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="account__submit submit_register">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

