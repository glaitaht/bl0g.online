@extends('layouts.app')
@section('content')
<?php 
use Carbon\Carbon;
$rules = [ 'searched_content' => 'required|string|min:3|max:255' ];
$validator = Validator::make($searched_content->all(),$rules);
if ($validator->fails()) {
    redirect('/')->with('error', 'Arama en az 3 harften oluşmalı.');
}
else{
    $data = $searched_content->input();
    try{
        $id=-1;
        $ip=-1;
        if(!Auth::check()){
            $ip = Request::ip();
        }
        else{
            $ip = Request::ip();
            $id = Auth::user()->id;
        }
        $now = Carbon::now()->toDateTimeString();
        $values = array('searched' => $searched_content["searched_content"],'user_id' => $id,'ip' =>$ip, 'created_at' => $now);
        DB::table('searches')->insert($values);
        $lower = Illuminate\Support\Str::lower($searched_content["searched_content"]);
            $posts = DB::select("SELECT * FROM `posts` WHERE title like '%".$lower."%' or postBody like '%".$lower."%'");
            if(sizeof($posts) == 0){ 
            session()->put('error', 'Sonuç bulunamadı.');
            echo "<script>function sleep (time) {
                return new Promise((resolve) => setTimeout(resolve, time));
                }
                // Usage!
                sleep(2000)
                window.location = 'https://bl0g.online/bl0g.online/bl0g/public/posts/';</script>";
            } 
            $counter = -1;
            foreach ($posts as $post){
                $counter++; if($counter % 3 == 0) echo '<div class="card-group">';
                $categoryName = DB::table('categories')->where('id',$post->category_id)->value('category_name');
                echo '
                <div class="card m-1">
                    <a href="/bl0g.online/bl0g/public/posts/'.$post->id.'"><img class="card-img-top" src="/bl0g.online/bl0g/public/storage/cover_images/'.$post->imageToShow.'" alt="No-Image"></a>
                    <div class="card-body">
                    <a href="/bl0g.online/bl0g/public/posts/'.$post->id.'"><h5 class="card-title"><strong>'.$post->title.'</strong></h5></a>
                    <p class="card-text">';
                        $text = \Illuminate\Support\Str::limit($post->postBody, $limit = 210, $end = '...');
                        $arr = array('<p>','<s>','<em>');
                        $res = str_replace($arr, '', $text);
                        echo $res;
                        echo '<a href="/bl0g.online/bl0g/public/posts/'.$post->id.'">Devamını oku</a></p>
                    <p class="card-text"><small class="text-muted"><a href =>  '.$categoryName.' Kategorisi </a></small></p>
                    </div>
                    </div>
                    ';
                if($counter % 3 == 2) {echo '</div>'; $counter=-1; }
            }
            if($counter != -1 ) echo '</div>'; 
    }
    catch(Exception $e){
        print_r($e->getMessage());
    }
}
?>
@endsection