<?php

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

if (! function_exists('generate')) {
    function generate($length=50, $strong=false){
        $password='';
        if($strong){
            $alphabet='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        }else{
            $alphabet='23456789abcdefghijkmnpqrstuvwxyz';
        }
        $alphabet_length=mb_strlen($alphabet)-1;
        for($i=0;$i<$length;$i++){
            $rand=mt_rand(0, $alphabet_length);
            $password.=mb_substr($alphabet, $rand, 1);
        }
        return $password;
    }
}

if (! function_exists('generate_name_img')) {
    function generate_name_img($length=50, $strong=false){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
        . mt_rand(1000000, 9999999)
        . $characters[rand(0, strlen($characters) - 1)];

        $string = str_shuffle($pin);
        return $string;
    }
}

if (! function_exists('component_article')) {
    function component_article($article_list, $show_button){
        ob_start();
        foreach ( $article_list as $art) { ?>
            <?=$art->name?><br>
            <?php if($art->img_preview) { ?>
                <div class="ico">
                    <a href="../image/<?=$art->img?>" target="_blank"><img class="" width="150" height="150" src="../image/<?=$art->img_preview?>" /></a>
                    <?php if($show_button){ ?>
                    <div class="ico_del">
                        <a href="/delete">
                            <img class="" width="20" height="20" src="/img/del_ico.png" /></a>
                    </div>
                    <div class="ico_edit">
                        <a href="/edit">
                            <img class="" width="20" height="20" src="/img/edit_ico.png" /></a>
                    </div>
                    <?php } ?>
                    <?=$art->tag?><br>
                </div>
            <?php } else { ?>
                <img class="" width="150" height="150" src="../image/no_foto.jpg" /></a>
            <?php } ?>
            <br>
            <hr>
        <?php }
        $result = ob_get_clean();
        echo $result;
    }


    if (! function_exists('save_article')) {
        function save_article($mode, $request, $article=null){
           // dd($request->article_id);

            $user_id = auth()->user()->id;
            if($mode == 'new') {
                // Проверим на уникальность название
                do {
                    $img = generate_name_img();
                    $img_name = Article::where('img', $img)->first();
                } while (isset($img_name['img']));


                $article = Article::create([
                    'name' => $request->name,
                    'img' => $img . ".jpg",
                    'img_preview' => $img . "_preview.jpg",
                    'user_id' => $user_id,
                ]);

                $last_id = DB::getPdo()->lastInsertId();

            } else {
                // Обновление article
                 Article::updateOrCreate(
                    [
                        'id' => $article->id,
                    ],
                    [
                        'id' => $article->id,
                        'name' => $request->name,
                        //'img' => $img . ".jpg",
                        //'img_preview' => $img . "_preview.jpg",
                        //'user_id' => $user_id,
                    ]
                );

                $last_id = $article->id;

                $img = preg_replace('~\.[a-z]+$~siu','',$article->img);
            }

            $filename = $_SERVER['DOCUMENT_ROOT'] . '/public/image/' . $img . ".jpg";
            $filename_preview = $_SERVER['DOCUMENT_ROOT'] . '/public/image/' . $img . "_preview.jpg";


            if ($_FILES['file']['error'] == 0 && is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $size = getimagesize($_FILES["file"]["tmp_name"]);
                if ($size) {

                    $file_dir = $filename;
                    $im = imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"]));
                    if($im) {

                        if (file_exists($filename)) {
                            array_map('unlink', glob($filename));
                            array_map('unlink', glob($filename_preview));
                        }

                        if (!imagejpeg($im, $file_dir, 80)) {
                            //echo "Ошибка при загрузке";
                        }
                        $x = 150;
                        $y = 150;
                        $ratio_thumb = $x / $y;

                        list($xx, $yy) = $size;
                        $ratio_original = $xx / $yy;

                        if ($ratio_original >= $ratio_thumb) {
                            $yo = $yy;
                            $xo = ceil(($yo * $x) / $y);
                            $xo_ini = ceil(($xx - $xo) / 2);
                            $xy_ini = 0;
                        } else {
                            $xo = $xx;
                            $yo = ceil(($xo * $y) / $x);
                            $xy_ini = ceil(($yy - $yo) / 2);
                            $xo_ini = 0;
                        }


                        $thumb = imagecreatetruecolor($x, $y);
                        imagecopyresampled($thumb, $im, 0, 0, $xo_ini, $xy_ini, $x, $y, $xo, $yo);

                        if (!imagejpeg($thumb, $filename_preview, 80)) {
                        }
                    }
                }
            }


            // Для тегов общая логика
            $tags = explode(',', $request->tags);
            foreach ($tags as $k => $tag) {
                $tag = trim($tag);

                if($tag=='')continue;
                DB::table('tags')->insertOrIgnore([
                    'tag' => $tag,
                ]);

                $tag_list[] = Tag::select('id')
                    ->where('tag', 'LIKE', trim($tag))
                    ->get()
                    ->toArray();
            }

            for ($i = 0; $i < count($tag_list); $i++) {
                for ($q = 0; $q < count($tag_list[$i]); $q++) {
                    $tag_id = $tag_list[$i][$q]['id'];
                    DB::table('article_tags')->insertOrIgnore([
                        'article_id' => $last_id,
                        'tag_id' => $tag_id,
                    ]);
                }
            }


            $article_list = Article::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            return $article_list;
        }
    }
}
