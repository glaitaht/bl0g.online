@extends('layouts.app')
@section('content')
<div class="card-deck">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" >
                <i class="fas fa-envelope-open"></i>
                <?php
                    $user =DB::table('users')->where('id',$contact[0]->user_id)->value("name");
                    echo $user;
                ?> kullanıcısından gelen bütün mesajlar     
            </h5>
            <?php
                    $allConv =DB::select("select * from contacts where user_id = (?) or messageFor = (?) order by created_at asc", [$contact[0]->user_id,$contact[0]->user_id]);
                    DB::table('contacts')->where('user_id',$contact[0]->user_id)->orWhere('messageFor',$contact[0]->user_id)->update(array('seen' => 0));
                    foreach ($allConv as $conv) {
                        if($conv->user_id == $contact[0]->user_id and $conv->messageFor != -1) continue;
                        $class ='';
                        if($conv->user_id != $contact[0]->user_id) $class = 'alert alert-dark';
                        else $class = 'alert alert-success';
                        echo '
                            <div class="card-footer" style="padding-top: 25px;">
                                <div class="'.$class.'">
                                <i class="fas fa-envelope-open"></i>&nbsp;&nbsp;&nbsp;~&nbsp;
                                ';
                                if($conv->user_id == $contact[0]->user_id) echo $user.'&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                else echo 'Admin &nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                echo $conv->message.'&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                echo '<div style="float:right">'.$conv->created_at.'</div>';
                        echo '
                            </div>  
                            </div>
                        ';
                    }
            ?>
            @if(Auth::check() and Auth::user()->isAdmin == 1)
            <hr><h5>Cevap yaz ~</h5><br>
            <form class="form-inline my-2 my-lg-0 " action="/bl0g.online/bl0g/public/reply/{{$contact[0]->user_id}}" method="POST">@csrf
                <div class="form-group purple-border" style="width: 100%;">
                    <input type="hidden" id="messageNo" name="messageNo" value="{{$contact[0]->id}}">
                    <textarea class="form-control md-textarea" name="mesaj" rows="4" style="width: 100%; max-width: 100%;" placeholder="Mesajınız..."></textarea>
                    <button class="btn btn-outline-dark mt-3"  type="submit">Gönder</button>
                </div>
              </form>
            @endif
        </div>
    </div>
</div>
@endsection