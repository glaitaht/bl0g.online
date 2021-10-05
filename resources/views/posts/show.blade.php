@extends('layouts.app')
@section('content')
    <div class="card m-1">
    <div class="card-body">
        <p class="card-text"><small class="text-muted"><a href ="/bl0g.online/bl0g/public/category/{{$post->category_id}}">
            <?php $categoryName = DB::table('categories')->where('id',$post->category_id)->value('category_name'); echo $categoryName; ?> Kategorisi
             </a>  ~  Created At: {{$post->created_at}} by <?php $userName = DB::table('users')->where('id',$post->user_id)->value('name'); echo $userName; ?> </small></p>
        <a href="/bl0g.online/bl0g/public/posts/{{$post->id}}"><h5 class="card-title"><strong>{{$post->title}}</strong></h5></a>
        <p class="card-text">{!!$post->postBody!!}</p>
        <a href="/bl0g.online/bl0g/public/posts/{{$post->id}}"><img class="card-img-top p-5" src="/bl0g.online/bl0g/public/storage/cover_images/{{$post->imageToShow}}" alt="No-Image"></a>
    </div>
    </div>
    <div class="card m-1">
        <div class="card-body">
            <p class="card-text"><strong class="text-muted">Yorumlar:</strong></p><hr>
            
            <?php 
                $comments = DB::select("SELECT * FROM `comments` WHERE post_id=".$post->id." and adminApprv = 1");
                foreach ($comments as $comment) {
                    $user = DB::select("SELECT * FROM `users` WHERE id=".$comment->user_id." ");
                    
                    echo '
                    <div class="card m-1">
                        <div class="card-body">
                            '.$user[0]->name;
                            if($user[0]->isAdmin == 1) echo ' ~ (Admin)';    
                    echo ' ~ Yorum Tarihi : '.$comment->created_at.'
                            <br>>&emsp;&emsp;&emsp;'.$comment->comment.'
                        </div>
                    </div>
                    ';
                }
            ?>

            <?php 
                if(Auth::check()){
                    echo '
                    <div class="card m-1">
                        <div class="card-body">
                            <p class="card-text">
                                <small class="text-muted">
                                    Yorum yaz: 
                                </small>';
                                
                    ?>
                    <form class="form-inline my-2 my-lg-0 " action="{{ url('commented/') }}" method="POST">@csrf
                        <div class="form-group purple-border" style="width: 80%;margin-left:10%;">
                            <textarea class="form-control md-textarea" name="comment" rows="4" style="width: 100%; max-width: 100%;" placeholder="Yorumunuz..."></textarea>
                            <input type="hidden" value="{{$post->id}}" name="post_id">
                            <button class="btn btn-outline-dark mt-3" style="margin-left:85%" type="submit">Gönder</button>
                        </div>
                      </form>
                    <?php
                    echo     '</p>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
    </div>
@endsection
