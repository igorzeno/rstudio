<?php

namespace App\Http\Controllers;

use App\Models\Article;

class DelarticleController extends Controller
{
    public function destroy(Article $article){
//        $this->authorize('delete',$article);

        if($article->ownedBy(auth()->user())){
            $article->delete();
            return back();
        }
    }
}
