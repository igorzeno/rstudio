@extends('layouts.app')

@section('title', 'Регистрация на сайте')

@section('custom_js')
@endsection

@section('custom_css')
    <link rel="stylesheet" href="/css/account.css" />
@endsection

@section('content')

    <main>
        <div><h1 class="profile__h1">Регистрация</h1></div>
        <div class="one__mes">
            <div class="account register">

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="account__point">
                        <label for="email" class="account__label required">E-mail</label>
                        <input value="{{ old('email') }}" name="email" id="email" class="account__input @error('email') border-red @enderror">
                        @error('email')
                        <div class="text-red">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="account__point">
                        <label for="passwd" class="account__label required">Пароль</label>
                        <input value="{{ old('password') }}" type="password" name="password" id="password" class="account__input @error('password') border-red @enderror">
                        @error('password')
                        <div class="text-red">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="account__point">
                        <label for="passwd" class="account__label required">Повторите пароль</label>
                        <input value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" id="password_confirmation" class="account__input @error('password_confirmation') border-red @enderror">
                        @error('password_confirmation')
                        <div class="text-red">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="account__submit submit_register">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
            <br><br><br><br>
        </div>
        </div>

    </main>

    </div>

    </body>
    </html>
@endsection
