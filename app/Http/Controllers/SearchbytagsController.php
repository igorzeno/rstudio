<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleTag;
use Illuminate\Support\Facades\DB;

class SearchbytagsController extends Controller
{
    public function search(Request $request)
    {
        $ids = explode(';', $request->tags);

//        $article_list  = ArticleTag::with('articles')
//            ->join('articles', 'articles.id', '=', 'article_tags.article_id')
//            ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
//            ->whereIn('tag_id', $ids)
//            ->distinct()
//            ->get()
//            ->toArray();

        $article_list  = DB::table('articles')
            ->join('article_tags', 'articles.id', '=', 'article_tags.article_id')
            ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
            ->select('articles.name', 'articles.img', 'articles.img_preview', DB::raw("(GROUP_CONCAT(tags.tag SEPARATOR ', ')) as `tag`"))
            ->whereIn('tag_id', $ids)
            ->groupBy( 'articles.id', 'articles.name','articles.img', 'articles.img_preview')
            ->orderBy('articles.id', 'desc')
            ->get();


        if (isset($article_list)) {
            $result = component_article($article_list, false);
            return $result;
        }
    }
}
