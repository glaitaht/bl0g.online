@extends('layouts.app')
@section('content')
<?php 
    use Carbon\Carbon;
    $id = Auth::user()->id;
    $now = Carbon::now()->toDateTimeString();
    $values = array('message' => $messageToSend["mesaj"],'user_id' => $id, 'created_at' => $now);
    DB::table('contacts')->insert($values);
    

?>
@endsection