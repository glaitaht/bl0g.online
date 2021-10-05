@extends('layouts.app')
@section('content')
<div class="card-deck">
    <div class="card" style="margin-left:25%;margin-right:25%">
        <div class="card-body">
            {!! Form::open(['action' => ['App\Http\Controllers\PagesController@changeIt', Auth::user()->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('old', 'Eski şifre')}}
                {{Form::password('old', ['class' => 'form-control', 'placeholder' => 'Eski Şifre'])}}
            </div>
            <div class="form-group">
                {{Form::label('new', 'Yeni şifre')}}
                {{Form::password('new', ['class' => 'form-control',  'placeholder' => 'Oluşturmak istediğiniz şifreyi giriniz.'])}}
            </div>
            <div class="form-group">
                {{Form::label('new2', 'Yeni şifre tekrar')}}
                {{Form::password('new2', ['class' => 'form-control',  'placeholder' => 'Oluşturmak istediğiniz şifreyi tekrar giriniz.'])}}
            </div>
            {{Form::submit('Değiştir.', ['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection