@extends('layouts.app')
@section('content')
<br><br><br><br><div class="card"><div class="card-body"><h2> "{{$categories[0]->category_name}}" isimli kategori silinecektir, onaylıyor musunuz? </h2>
            {!!Form::open(['action' => ['App\Http\Controllers\PagesController@catdel', $categories[0]->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::submit('Sil', ['class' => 'btn btn-danger', 'style' => 'float:right'])}}
            {!!Form::close()!!}</div></div>
@endsection