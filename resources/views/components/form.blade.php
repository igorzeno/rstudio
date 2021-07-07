<div class="one__mes">
    <div class="account">
        <form id="article">
            <table>
                <input id="token" name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="textarea">
                    <label for="message" class="account__label">Добавить article</label>
                    <textarea id="name" name="name"
                              class="account__input">{{ old('name') ? old('name'):(isset($article) ? $article->name:'') }}</textarea>
                </div>

                <div class="textarea">
                    <label for="tag_id" class="account__label required">Укажите тег</label>
                    <textarea id="tags" name="tags"
                              class="account__input">{{ old('tags') ? old('tags'):(isset($tags) ? $tags:'') }}</textarea>
                </div>
                <br>
                <tr>
                    <td colspan="2">File Upload</td>
                </tr>
                <tr>
                    <th>Select File </th>
                    <td><input id="file" name="file" type="file" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="submit"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script type="text/javascript" >
    //form Submit
    $("#article").submit(function(evt){
        evt.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: <?php if(!isset($article)){?>'/load-article'<?php }else{?>'/edit/{{$article->id}}'<?php }?>,
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (result) {
                $( ".show" ).hide();
                $( ".res_articles" ).html( result );
                alert( 'Данные загружены' );
                location.href="/";
            }
        });
    return false;
    });
</script>
