@extends('layouts.app')

@section('title', 'TODOLIST​')
@section('description', '')

@section('custom_css')
@endsection

@section('content')
    <main>
        <div class="main">
            <h1>TODOLIST​</h1>
            @auth
                @component('components.form')
                @endcomponent
            @endauth
            <script type="text/javascript" >
                function send_tags(form){
                    var myNodeList = form.querySelectorAll("input[name='tags[]']");

                    var checked=[];

                    for (i = 0; i <	myNodeList.length; i++)
                    {
                        if(myNodeList[i].checked) {
                            checked.push(myNodeList[i].value)
                        }
                    }

                    var tags = checked.join(";")

                    $.ajax({
                        url: "/search-by-tags",
                        method:'post',
                        data: {
                            tags: tags,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function( result ) {
                            $( ".show" ).hide();
                            $( ".res_articles" ).html( result );
                        }
                    });

                    return false;
                }
            </script>

            <form action="" onsubmit="return send_tags(this)">
                @if (!empty($tags) )
                    <p>Укажите теги для поиска</p>
                    @foreach($tags as $tag)
                        <p><label><input type="checkbox" name="tags[]" value="{{ $tag->id }}">&nbsp;&nbsp;{{ $tag->tag }}</label></p>
                    @endforeach
                        <p><input type="submit" value="Отправить"></p>
                @else
                @endif
            </form>

            <h3>Cообщения</h3>
            <div class="res_articles"></div>
            <div class="show">
            @if ($article_list->count())
                @foreach($article_list as $art)
                    {{ $art->name }}<br>
                        @if ($art->img_preview)
                        <div class="ico">
                        <a href="../image/{{ $art->img }}" target="_blank"><img class="" width="150" height="150" src="../image/{{ $art->img_preview }}" /></a>
                            @auth()
                                @if ( $art->ownedBy(auth()->user()))
                                <div class="ico_del">
{{--                                @can ('delete', $art)--}}
                                    <form action="{{route('delete', $art->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="but_del" type="submit"><img class="" width="20" height="20" src="../img/del_ico.png" /></button>
                                    </form>
{{--                                @endcan--}}
                                </div>

                                <div class="ico_edit">
                                    <form action="{{route('edit_form', $art)}}" method="get">
                                        <button class="but_del" type="submit"><img class="" width="20" height="20" src="../img/edit_ico.png" /></button>
                                    </form>
                                </div>
                                @endif
                            @endauth
                            {{ $art->tag }}<br>
                        </div>
                        @else
                        <img class="" width="150" height="150" src="../image/no_foto.jpg" /></a>
                        @endif
                    <br>
                    <hr>
                @endforeach
                    {!! $article_list->render() !!}
            @else
                <p>No articles</p>
            @endif
            </div>
        </div>
    </main>

@endsection

@section('custom_js')
@endsection


