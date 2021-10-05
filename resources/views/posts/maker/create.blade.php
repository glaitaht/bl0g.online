@extends('layouts.app')
@section('content')
<h1>Yeni yazı :</h1>
    {!! Form::open(['action' => 'App\Http\Controllers\PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Başlık')}}
        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Başlık'])}}
    </div>
    {{Form::label('category', 'Kategori')}}
    <div class="form-group">
        <select name="category" id="category" class ="form-control" placeholder="Seçiniz...">
        @foreach ($categories as $category)
            <option value="{{$category->id}}" >{{$category->category_name}}</option>
        @endforeach
        </div>
        </select><br>
    <div class="form-group">
        {{Form::label('body', 'İçerik')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Yazı içeriği'])}}
    </div>
    <div class="form-group">
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection