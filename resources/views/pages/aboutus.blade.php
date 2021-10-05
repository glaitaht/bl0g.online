@extends('layouts.app')
@section('content')
<h1>Adminlerimiz ~ </h1>
<div class="card-deck">
    @foreach ($adminInfos as $admin)
        <div class="card">
            <img src="storage/cover_images/{{$admin->imageToShow}}" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title">
                <?php
                $adminsName = DB::table('users')->where('id', $admin->user_id)->get();
                echo $adminsName[0]->name;
                ?></h5>
            <p class="card-text">{!!$admin->about_admin!!}</p>
            </div>
            <div class="card-footer">
            <small class="text-muted">Telefon Numarası : {{$admin->phone_number}} ~ 
                <a href="{{$admin->facebook_link}}"><i class="fab fa-facebook"></i></a>
                <a href="{{$admin->instagram_link}}"><i class="fab fa-instagram"></i></a>
                <a href="{{$admin->linkedin_link}}"><i class="fab fa-linkedin"></i></a>&nbsp;&nbsp;&nbsp;
                <i class="fas fa-at"></i> : 
                <?php
                $adminsName = DB::table('users')->where('id', $admin->user_id)->get();
                echo $adminsName[0]->email;
                ?>
                <br>
                <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;&nbsp;{{$admin->address}}
            </small>
            </div>
        </div>
    @endforeach
</div><br><br><br>
@if(Auth::check())
    <h1>Bize ulaşın ~</h1><br>
    <form class="form-inline my-2 my-lg-0 " action="/bl0g.online/bl0g/public/sended" method="POST">@csrf
        <div class="form-group purple-border" style="width: 100%;">
            <textarea class="form-control md-textarea" name="mesaj" rows="4" style="width: 100%; max-width: 100%;" placeholder="Mesajınız..."></textarea>
            <button class="btn btn-outline-dark mt-3"  type="submit">Gönder</button>
        </div>
      </form>
@endif
@endsection