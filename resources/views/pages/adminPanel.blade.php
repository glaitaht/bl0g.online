@extends('layouts.app')
@section('content')
<br>
    <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header">
                Son üç yazı
              </div>
              <ul class="list-group list-group-flush">
                  <?php 
                        $lastPosts = DB::select('select * from posts order by created_at desc limit 3');;;
                        foreach ($lastPosts as $post) {
                            echo '
                               <li class="list-group-item">'.\Illuminate\Support\Str::limit($post->title, $limit = 33, $end = "...").' <a href="/bl0g.online/bl0g/public/posts/'.$post->id.'">Yazıya git</li></a>
                            ';
                        }
                  ?>
              </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
                <div class="card-header">
                    Son üç yorum
                  </div>
                  <ul class="list-group list-group-flush">
                    <?php 
                        $lastComments = DB::select('select * from comments where adminApprv= 1 order by created_at desc limit 3');;;
                        foreach ($lastComments as $comment) {
                            echo '
                            <li class="list-group-item">'.\Illuminate\Support\Str::limit($comment->comment, $limit = 33, $end = "...").' <a href="/bl0g.online/bl0g/public/posts/'.$comment->post_id.'">Yazıya git</li></a>
                            ';
                        }
                    ?>
                  </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
                <div class="card-header">
                    Son üç arama
                  </div>
                  <ul class="list-group list-group-flush">
                    <?php 
                        $lastSearches = DB::select('select * from searches order by created_at desc limit 3');;;
                        foreach ($lastSearches as $search) {
                            echo '
                               <li class="list-group-item">'.\Illuminate\Support\Str::limit($search->searched, $limit = 33, $end = "...").' </li>
                            ';
                        }
                    ?>
                  </ul>
          </div>
        </div>
      </div>
@endsection