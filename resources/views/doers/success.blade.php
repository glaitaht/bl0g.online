@extends('layouts.app')
@section('content')
<?php
    use Carbon\Carbon;
    $rules = [ 'comment' => 'required|string|min:3|max:255' ];
    $validator = Validator::make($comment->all(),$rules);
    if ($validator->fails()) {
        return redirect('posts.index')
        ->withInput()
        ->withErrors($validator);
    }
    else{
        $data = $comment->input();
        try{
            if(!Auth::check()) return; 
            $id=Auth::user()->id;
            $now = Carbon::now()->toDateTimeString();
            $values = array('comment' => $comment["comment"],'user_id' => $id,'adminApprv' => '0', 'created_at' => $now, 'post_id' => $comment["post_id"]);
            DB::table('comments')->insert($values);
            session()->put('success', 'Yorum yapıldı.');
            //redirect()->url('/bl0g.online/bl0g/public/posts/'.$comment["post_id"].'');
            //return redirect()->action('App\Http\Controllers\PostsController@show',['id'=>$comment["post_id"]]);
            //return redirect()->route('posts/{id}', ['id' => $comment["post_id"]]);
            //return redirect("/bl0g.online/bl0g/public/posts/".$comment["post_id"]."");
            //$url = "/bl0g.online/bl0g/public/posts/".$comment["post_id"];
            //header('Location: '.$url);
            echo "<script>function sleep (time) {
                return new Promise((resolve) => setTimeout(resolve, time));
                }
                // Usage!
                sleep(2000)
                window.location = 'https://bl0g.online/bl0g.online/bl0g/public/posts/".$comment["post_id"]."';</script>";
        }
        catch(Exception $e){
            print_r($e->getMessage());
        }
    }
?>
@endsection