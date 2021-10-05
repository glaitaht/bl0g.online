@extends('layouts.app')
@section('content')
<br>
<br>
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Yorum</th>
        <th scope="col">Yorum yapanın adı</th>
        <th scope="col">Yorum</th>
        <th scope="col">Email adresi</th>
        <th scope="col">Yorum tarihi</th>
        <th scope="col">Onayla</th>
        <th scope="col">Sil</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($comments as $comment) {
            $post = DB::table('posts')->where('id',$comment->post_id)->value('title');
            $post = \Illuminate\Support\Str::limit($post, $limit = 15, $end = '...');
            $name = DB::table('users')->where('id',$comment->user_id)->value('name');
            $email = DB::table('users')->where('id',$comment->user_id)->value('email');
            echo '<tr  class="table-dark" style="color:black">
                <th scope="row"><a href="/bl0g.online/bl0g/public/posts/'.$comment->post_id.'">'.$post.'</a></th>
                <td>'.$name.'</td>
                <td>'.$comment->comment.'</td>
                <td>'.$email.'</td>
                <td>'.$comment->created_at.'</td>
                
                <td>
                    <form action="/bl0g.online/bl0g/public/comacc/'.$comment->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-primary" type="submit">
                            <i class="fas fa-check fa-lg"></i>
                        </button>
                    </form>
                </td>
                
                
                <td>
                    <form action="/bl0g.online/bl0g/public/comdel/'.$comment->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-danger"" type="submit">
                            <i class="fas fa-trash fa-lg"></i>
                        </button>
                    </form>
                </td>
            </tr>';
        }
        
    ?>
    </tbody>
  </table>
@endsection