@extends('layouts.app')
@section('content')
<br>
<br>
<a href="/bl0g.online/bl0g/public/newOne"><button>Yeni yazı oluştur</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Başlıklarda ara: <input type='text' id='aranacak'/> <button onclick="basliktaAra()">Ara</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Kategorileri filtrele: <input type='text' id='filtre'/> <button onclick="kategoriyiFiltrele();">Filtrele</button>
<button onclick="printData();"" style="float:right;">Yazdır</button>
<br>
<br>
<table class="table" id='myTable'>
    <thead class="thead-light">
      <tr>
        <th scope="col">Post ID</th>
        <th scope="col">Başlık</th>
        <th scope="col">İçerik</th>
        <th scope="col">Yazar</th>
        <th scope="col">Kategori</th>
        <th scope="col">Tarih</th>
        <th scope="col">Düzenle</th>
        <th scope="col">Sil</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($posts as $post){
            $categoryName = DB::table('categories')->where('id',$post->category_id)->value('category_name');
            $userName = DB::table('users')->where('id',$post->user_id)->value('name');
            $body = \Illuminate\Support\Str::limit($post->postBody, $limit = 33, $end = '...');
            $arr = array('<p>','<s>','<em>');
            $body = str_replace($arr, '', $body);
            echo '
            <tr  class="table-dark" style="color:black">
                <th scope="row">'.$post->id.'</th>
                <td><a href="/bl0g.online/bl0g/public/posts/'.$post->id.'">'.$post->title.'</a></td>
                <td>'.$body.'</td>
                <td>'.$userName.'</td>
                <td>'.$categoryName.' Kategorisi</td>
                <td>'.$post->created_at.'</td>
                <td><a href="/bl0g.online/bl0g/public/posts/'.$post->id.'/edit"><i class="fas fa-edit fa-lg"></i></a></td>
                <td><a href="/bl0g.online/bl0g/public/deleteIt/'.$post->id.'"><i class="fas fa-trash fa-lg"></i></a></td>
            </tr>
            ';
        }
    ?>
    </tbody>
  </table>
    <script>
        function basliktaAra() {
            findIt = document.getElementById("aranacak").value;
            findIt = findIt.toLowerCase();
            var table = document.getElementById('myTable');
            for (var r = 1, n = table.rows.length; r < n; r++) {
                table.rows[r].classList.add("table-dark");
                 if((table.rows[r].cells[1].innerHTML).toLowerCase().includes(findIt))
                    table.rows[r].classList.remove("table-dark");
                    table.rows[r].classList.add("table-danger");
            }
        }
        
        function kategoriyiFiltrele() {
            findIt = document.getElementById("filtre").value;
            findIt = findIt.toLowerCase();
            var table = document.getElementById('myTable');
            for (var r = table.rows.length-1, n = 0; r > n; r--) {
                if((table.rows[r].cells[4].innerHTML).toLowerCase().includes(findIt)){
                }
                else{
                    table.rows[r].remove();
                }
            }
        }
    </script>
@endsection