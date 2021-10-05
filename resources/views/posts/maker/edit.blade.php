@extends('layouts.app')
@section('content')
<h1>Düzenleme</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Başlık')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        {{Form::label('category', 'Kategori')}}
        <div class="form-group">
            <select name="category" id="category" class ="form-control" placeholder="Seçiniz...">
            @foreach ($categories as $category)
                <option value="{{$category->id}}" @if($category->id == $post->category_id)  selected @endif >{{$category->category_name}}</option>
            @endforeach
            </div>
            </select><br>
        <div class="form-group">
            {{Form::label('body', 'İçerik')}}
            {{Form::textarea('body', $post->postBody, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'İçerik'])}}
        </div>
        
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection