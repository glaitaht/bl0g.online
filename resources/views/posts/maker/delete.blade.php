@extends('layouts.app')
@section('content')
<br><br><br><br><div class="card"><div class="card-body"><h2> "{{$post->title}}" isimli yazı silinecektir, onaylıyor musunuz? </h2>
            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Sil', ['class' => 'btn btn-danger', 'style' => 'float:right'])}}
            {!!Form::close()!!}</div></div>
@endsection