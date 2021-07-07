@extends('layouts.app')

@section('title', 'Регистрация на сайте')

@section('custom_js')
@endsection

@section('custom_css')
    <link rel="stylesheet" href="/css/account.css" />
    <link rel="stylesheet" href="/css/greeting.css" />
@endsection

@section('content')

    <main>

        <div><h1 class="profile__h1">Регистрация</h1></div>


            <br><br><br><br>
    </main>
    </div>

    <div id="modal_message" class="modal_message">
        <div class="message">
            <div class="message_body">
                <div class="message_title">
                    <div class="greet"><img src="/ui/img/greet.png" alt=""></div>
                </div>
                <div class="one__block_message">
                    <div class="one__message_img">Вы успешно зарегистрировались!</div>
                </div>
                <div class="one__block_message">
                    <p>&mdash; Добавьте article</p>
                </div>
                <div class="one__block_message">
                    <a href="{{route('/')}}"><button type="submit" class="button__greet">Продолжить</button></a>
                </div>

            </div>
        </div>
    </div>

    </body>
    </html>
@endsection
