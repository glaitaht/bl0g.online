@extends('layouts.app')
@section('content')
  <div>
    @if(count($posts) > 0)
        <?php $counter = -1; ?>
        @foreach ($posts as $post)
        <?php $counter++; if($counter % 3 == 0) echo '<div class="card-group">'; ?>
            <div class="card m-1">
                <a href="/bl0g.online/bl0g/public/posts/{{$post->id}}"><img class="card-img-top" src="/bl0g.online/bl0g/public/storage/cover_images/{{$post->imageToShow}}" alt="No-Image"></a>
              <div class="card-body">
                <a href="/bl0g.online/bl0g/public/posts/{{$post->id}}"><h5 class="card-title"><strong>{{$post->title}}</strong></h5></a>
                <p class="card-text">
                  <?php 
                $text = \Illuminate\Support\Str::limit($post->postBody, $limit = 210, $end = '...');
                $arr = array('<p>','<s>','<em>','<h3>','<strong>');
                $res = str_replace($arr, '', $text);
                echo $res;
                ?>
                <a href="/bl0g.online/bl0g/public/posts/{{$post->id}}">Devamını oku</a></p>
                <p class="card-text"><small class="text-muted"><a href ="/bl0g.online/bl0g/public/category/{{$post->category_id}}"> <?php $categoryName = DB::table('categories')->where('id',$post->category_id)->value('category_name'); echo $categoryName; ?> Kategorisi </a></small></p>
                
              </div>
            </div>
            <?php if($counter % 3 == 2) {echo '</div>'; $counter=-1; }?>
        @endforeach
            <?php if($counter != -1 ) echo '</div>'; ?>
          <div class="pagination no-margin pull-right">{{$posts->links()}}</div>
    @else
            <p>No post founded.</p>
    @endif
  </div>
@endsection
