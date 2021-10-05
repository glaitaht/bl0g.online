<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* The sidebar menu */
        .sidebar {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0;
        left: 0;
        background-color: #5CB85C; /* Black*/
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 60px; /* Place content 60px from the top */
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
        }

        /* The sidebar links */
        .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #343a40 ;
        display: block;
        transition: 0.3s;
        }

        /* When you mouse over the navigation links, change their color */
        .sidebar a:hover {
        color: black;
        }

        /* Position and style the close button (top right corner) */
        .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
        }

        /* The button used to open the sidebar */
        .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #5CB85C;
        color: #343a40 ;
        padding: 10px 15px;
        border: none;
        }

        .openbtn:hover {
        background-color: #444;
        }

        /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
        #main {
        transition: margin-left .5s; /* If you want a transition effect */
        padding: 20px;
        }

        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
        .sidebar {padding-top: 15px;}
        .sidebar a {font-size: 18px;}
        }
    </style>
    <?php
        if(Auth::check() and Auth::user()->isAdmin == 1){
        echo '
        <style>
            .sidebar2 {
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            left: 0;
            background-color: #5CB85C; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
            }

            /* The sidebar links */
            .sidebar2 a {
            padding: 10px;
            text-decoration: none;
            font-size: 25px;
            color: #343a40 ;
            display: block;
            transition: 0.3s;
            }

            /* When you mouse over the navigation links, change their color */
            .sidebar2 a:hover {
            color: black;
            }

            /* Position and style the close button (top right corner) */
            .sidebar2 .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            }

            /* The button used to open the sidebar */
            .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #5CB85C;
            color: #343a40 ;
            padding: 10px 15px;
            border: none;
            }

            .openbtn:hover {
            background-color: #444;
            }

            /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
            #main3 {
            transition: margin-right .5s; /* If you want a transition effect */
            padding: 20px;
            }

            /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
            @media screen and (max-height: 450px) {
            .sidebar2 {padding-top: 15px;}
            .sidebar2 a {font-size: 18px;}
            }
        </style>
        ';
    }
    ?>
</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <main class="container pt-5" style="margin-top: 15px;">
            @include('doers.message')
            @yield('content')
        </main>
    </div>
    <div id="mySidebar" class="sidebar"> <!-- Sidebar başlangıç -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <br><br><br><br><p style="font-size:1.5em;text-align:center;color:white">En popüler Kategoriler</p>
                <?php $categories = DB::table('categories')->get();
                      $cat = array(); $i=0;
                      foreach ($categories as $category) {
                        $postsAboutCategory = DB::table('posts')->where('category_id', $category->id)->count();
                        $cat[$i] = array("id" => $category->id, "count" => $postsAboutCategory, "name" => $category->category_name);$i++;
                      }
                      $x = array_column($cat, 'count');
                      array_multisort($x, SORT_DESC, $cat);
                      echo '
                      <a href="/bl0g.online/bl0g/public/category/'.$cat[0]["id"].'">'.$cat[0]["name"].' ('.$cat[0]["count"].')</a>
                      <a href="/bl0g.online/bl0g/public/category/'.$cat[1]["id"].'">'.$cat[1]["name"].' ('.$cat[1]["count"].')</a>
                      <a href="/bl0g.online/bl0g/public/category/'.$cat[2]["id"].'">'.$cat[2]["name"].' ('.$cat[2]["count"].')</a>';
                ?>
                <br><br><br><br><p style="font-size:1.5em;text-align:center;color:white">Yazılan son yorumlar</p>
                <?php $comments = DB::table('comments')->where('adminApprv', 1)->get();
                      $i=0;
                      foreach ($comments as $comment) {
                        $posts = DB::table('posts')->where('id', $comment->post_id)->get();
                        echo '<a href="/bl0g.online/bl0g/public/posts/'.$comment->post_id.'" style="font-size:1em;">'. \Illuminate\Support\Str::limit($posts[0]->title, 25, $end='...') .' > '.$comment->comment.'</a>';
                        $i++; if($i>4) break;
                      }
                      
                ?>
      </div><!-- Sidebar bitiş -->
      <div id="main">
        <button  id="main2" class="openbtn" onclick="openNav()" style="position:fixed;top:25%;left:0px;">&#9776; Popüler</button>
      </div>
      <?php 
        if(Auth::check() and Auth::user()->isAdmin == 1){
            echo '
            <div id="mySidebar2" class="sidebar"> <!-- Sidebar başlangıç --><br><br><br>
                <a href="/bl0g.online/bl0g/public/adminPanel" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Admin Paneli</button></a>
                <a href="/bl0g.online/bl0g/public/postDetails" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Yazılar</button></a>
                <a href="/bl0g.online/bl0g/public/categories" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Kategoriler</button></a>
                <a href="/bl0g.online/bl0g/public/comments" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Yorumlar</button></a>
                <a href="/bl0g.online/bl0g/public/searched" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Aramalar</button></a>
                <a href="/bl0g.online/bl0g/public/users" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Yeni Kullanıcılar</button></a>
                <a href="/bl0g.online/bl0g/public/aboutMe" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Hakkımda</button></a>
                <a href="/bl0g.online/bl0g/public/contacts" style="padding: 10px;"><button type="button" class="btn btn-lg btn-block btn-outline-dark">Mesajlar</button></a>
                </div><!-- Sidebar bitiş -->
            <div id="main3">
                <button  id="main4" class="openbtn" onclick="openAdmin()" style="position:fixed;top:55%;left:0px;">&#9776; Admin</button>
            </div>
            ';
        }
      ?>
    <script>
        function openNav() {
            if(document.getElementById("mySidebar").style.width != "250px"){
                document.getElementById("mySidebar").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
                document.getElementById("main2").style.marginLeft = "250px";
            }
            else{
                document.getElementById("mySidebar").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.getElementById("main2").style.marginLeft = "0px";
            }
        }
    </script>
    <?php 
        if(Auth::check() and Auth::user()->isAdmin == 1){
            echo '<script>
                function openAdmin() {
                    if(document.getElementById("mySidebar2").style.width != "250px"){
                        document.getElementById("mySidebar2").style.width = "250px";
                        document.getElementById("main3").style.marginLeft = "250px";
                        document.getElementById("main4").style.marginLeft = "250px";
                    }
                    else{
                        document.getElementById("mySidebar2").style.width = "0";
                        document.getElementById("main3").style.marginLeft = "0";
                        document.getElementById("main4").style.marginLeft = "0px";
                    }
                }
            </script>';
        }
    ?>
    <script>
        function printData()
        {
            var divToPrint=document.getElementById("myTable");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
    </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
</body>
</html>
