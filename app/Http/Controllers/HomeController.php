<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Сообщения авторизованного пользователя
        if(Auth::user()) {
            $id = Auth::user()->id;
            $user_id = User::find($id)->id;

//            $article_list  = DB::table('articles')
//                ->join('article_tags', 'articles.id', '=', 'article_tags.article_id')
//                ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
//                ->select('articles.name', 'articles.img', 'articles.img_preview', DB::raw("(GROUP_CONCAT(tags.tag SEPARATOR ', ')) as `tag`"))
//                ->where('user_id', $user_id )
//                ->groupBy( 'articles.name','articles.img', 'articles.img_preview')
//                ->orderBy('articles.id', 'desc')
//                ->paginate(3);

            $article_list = Article::where('user_id', $user_id )
                ->orderBy('id', 'desc')
                ->paginate(5);

            return view('index', [
                'article_list' => $article_list
            ]);
        }

        else {
            $article_list  = DB::table('articles')
                ->join('article_tags', 'articles.id', '=', 'article_tags.article_id')
                ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
                ->select('articles.name', 'articles.img', 'articles.img_preview', DB::raw("(GROUP_CONCAT(tags.tag SEPARATOR ', ')) as `tag`"))
                ->groupBy( 'articles.id', 'articles.name','articles.img', 'articles.img_preview')
                ->orderBy('articles.id', 'desc')
                ->paginate(5);

            $tags = Tag::all();
            return view('index', [
                'article_list' => $article_list,
                'tags' => $tags
            ]);
        }


    }
}
