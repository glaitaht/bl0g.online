@extends('layouts.app')
@section('content')
<br>
<br>
<a href="/bl0g.online/bl0g/public/newCategory"><button>Yeni kategori oluştur</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Kategori ID</th>
        <th scope="col">Kategori Adı</th>
        <th scope="col">Kategori İçeriği</th>
        <th scope="col">Düzenle</th>
        <th scope="col">Sil</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($categories as $category) {
            echo '<tr  class="table-dark" style="color:black">
                <th scope="row">'.$category->id.'</th>
                <td><a href="/bl0g.online/bl0g/public/category/'.$category->id.'">'.$category->category_name.'</a></td>
                <td>'.$category->category_info.'</td>
                <td><a href="/bl0g.online/bl0g/public/editCategory/'.$category->id.'"><i class="fas fa-edit fa-lg"></i></a></td>
                <td><a href="/bl0g.online/bl0g/public/deleteCategory/'.$category->id.'"><i class="fas fa-trash fa-lg"></i></a></td>
            </tr>';
        }
        
    ?>
    </tbody>
  </table>
@endsection