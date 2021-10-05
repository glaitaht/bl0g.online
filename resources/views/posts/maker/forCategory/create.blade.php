@extends('layouts.app')
@section('content')
<h1>Yeni kategori :</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\PagesController@catadd', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Kategori Adı')}}
        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Kategori Adı'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'İçerik')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Yazı içeriği'])}}
    </div>
    {{Form::submit('Gönder', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection