@extends('layouts.app')

@section('custom_js')
@endsection

@section('custom_css')

@endsection

@section('content')
    <main>
        <div class="main">
            <h1>Редактирование Article</h1>
                @component('components.form', ['article' => $article, 'tags'=>$tags])
                @endcomponent
        </div>
    </main>
@endsection
