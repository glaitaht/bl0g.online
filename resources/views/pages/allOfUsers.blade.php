@extends('layouts.app')
@section('content')
<br>
<br>
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Kullanıcı ID</th>
        <th scope="col">Adı Soyadı</th>
        <th scope="col">Kullanıcı durumu</th>
        <th scope="col">Admin yap / Adminliği al</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($users as $user) {
            echo '<tr  class="table-dark" style="color:black">
                <th scope="row">'.$user->id.'</th>
                <td>'.$user->name.'</td>
                <td>'; 
                    if($user->isAdmin == 1) echo 'Admin';
                    else echo 'Kullanıcı';
                echo '</td>';
                if($user->isAdmin == 0) 
                echo '<td>
                    <form action="/bl0g.online/bl0g/public/admacc/'.$user->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-primary" type="submit">
                            <i class="fas fa-check fa-lg"></i> Admin yetkisi ver
                        </button>
                    </form>
                    </td>';
                else 
                echo '
                    <td>
                    <form action="/bl0g.online/bl0g/public/admdel/'.$user->id.'" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button class ="btn btn-danger"" type="submit">
                            <i class="fas fa-times-circle fa-lg"></i> Admin yetkisini geri al
                        </button>
                    </form>
                </td>
            </tr>';
        }
        
    ?>
    </tbody>
  </table>
@endsection