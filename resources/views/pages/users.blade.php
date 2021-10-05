@extends('layouts.app')
@section('content')
<br>
<br><a href="/bl0g.online/bl0g/public/allOfUsers"><button>Bütün kullanıcılar</button></a>
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Kullanıcı ID</th>
        <th scope="col">Adı</th>
        <th scope="col">Email adresi</th>
        <th scope="col">Kayıt tarihi</th>
        <th scope="col">Onayla</th>
        <th scope="col">Sil</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($users as $user) {
            echo '<tr  class="table-dark" style="color:black">
                <th scope="row">'.$user->id.'</th>
                <td>'.$user->name.'</td>
                <td>'.$user->email.'</td>
                <td>'.$user->created_at.'</td>
                <td>
                    <form action="/bl0g.online/bl0g/public/usacc/'.$user->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-primary" type="submit">
                            <i class="fas fa-check fa-lg"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <form action="/bl0g.online/bl0g/public/usdel/'.$user->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-danger"" type="submit">
                            <i class="fas fa-trash fa-lg"></i>
                        </button>
                    </form>
                </td>
            </tr>';
        }
        
    ?>
    </tbody>
  </table>
@endsection