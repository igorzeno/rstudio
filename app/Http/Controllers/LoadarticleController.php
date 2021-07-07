<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadarticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function load(Request $request)
    {
        $article_list = save_article('new', $request);

        if (isset($article_list)) {
            $result = component_article($article_list, true);
            return $result;
        }
    }

    public function edit(Request $request, Article $article)
    {
        if ($article->ownedBy(auth()->user())) {
            $article_list = save_article('edit', $request, $article);

            if (isset($article_list)) {
                $result = component_article($article_list, true);
                return $result;
            }
        }
    }



    public function editform(Article $article)
    {
        if ($article->ownedBy(auth()->user())) {
            $tags_list  = DB::table('article_tags')
                ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
                ->select('tags.tag')
                ->where('article_id', $article->id)
                ->orderBy('tags.tag', 'asc')
                ->get();
            $tags=[];
            foreach($tags_list as $tag){
                $tags[]=$tag->tag;
            }

            return view('edit.form', [
                'article' => $article,
                'tags'=>join(', ', $tags),
            ]);
        }
    }
}
