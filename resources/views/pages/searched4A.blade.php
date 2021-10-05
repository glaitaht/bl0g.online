@extends('layouts.app')
@section('content')
<br>
<br>
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Arama yapanın adı</th>
        <th scope="col">IP'si</th>
        <th scope="col">Arama</th>
        <th scope="col">Arama Tarihi</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($searches as $search) {
            $name = DB::table('users')->where('id',$search->user_id)->value('name');
            if(!isset($name)) $name = "Misafir";
            echo '<tr  class="table-dark" style="color:black">
                <th scope="row">'.$name.'</th>
                <td>'.$search->ip.'</td>
                <td>'.$search->searched.'</td>
                <td>'.$search->created_at.'</td>
            </tr>';
        }
    ?>
    </tbody>
  </table>
@endsection