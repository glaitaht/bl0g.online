@extends('layouts.app')
@section('content')
<h1>{{$category[0]->category_name}} kategorisini düzenliyorsunuz</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PagesController@catedt', $category[0]->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title', 'Kategori Adı')}}
        {{Form::text('title', $category[0]->category_name, ['class' => 'form-control', 'placeholder' => 'Kategori Adı'])}}
    </div>
    <div class="form-group">
        {{Form::label('body', 'İçerik')}}
        {{Form::textarea('body', $category[0]->category_info, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Yazı içeriği'])}}
    </div>
    {{Form::submit('Gönder', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection