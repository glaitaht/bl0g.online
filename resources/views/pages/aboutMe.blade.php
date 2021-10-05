@extends('layouts.app')
@section('content')
<h1>Bilgileriniz ~ </h1>
<div class="card-deck">
    @foreach ($adminInfos as $admin)
        <div class="card" style="margin-left:25%;margin-right:25%">
            <img src="storage/cover_images/{{$admin->imageToShow}}" class="img-responsive img-thumbnail" alt="...">
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
<h1>Düzenleme</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PagesController@abMeEd', $adminInfos[0]->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('phone', 'Telefon')}}
            {{Form::text('phone', $adminInfos[0]->phone_number, ['class' => 'form-control', 'placeholder' => 'Telefon'])}}
        </div>
        <div class="form-group">
            {{Form::label('about_admin', 'Admin hakkında kısmı')}}
            {{Form::textarea('about_admin', $adminInfos[0]->about_admin, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Admin hakkında kısmı'])}}
        </div>
        <div class="form-group">
            {{Form::label('address', 'Adres')}}
            {{Form::textarea('address', $adminInfos[0]->address, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Adres'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        <div class="form-group">
            {{Form::label('lnkd', 'Linkedin Linki')}}
            {{Form::text('lnkd', $adminInfos[0]->linkedin_link, ['class' => 'form-control', 'placeholder' => 'Linkedin'])}}
        </div>
        <div class="form-group">
            {{Form::label('ins', 'İnstagram Linki')}}
            {{Form::text('ins', $adminInfos[0]->instagram_link, ['class' => 'form-control', 'placeholder' => 'İnstagram'])}}
        </div>
        <div class="form-group">
            {{Form::label('fb', 'Facebook Linki')}}
            {{Form::text('fb', $adminInfos[0]->facebook_link, ['class' => 'form-control', 'placeholder' => 'Facebook'])}}
        </div>
        {{Form::hidden('_method','POST')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}


@endsection