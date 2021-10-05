<!-- Navbar-->
<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color:#5CB85C;">
    <a class="navbar-brand text-dark" href="{{url('/')}}">bl0g.online</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link text-dark" href="{{url('/')}}">Anasayfa <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kategoriler</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <?php $categories = DB::table('categories')->get();
              foreach ($categories as $category) {
                $postsAboutCategory = DB::table('posts')->where('category_id', $category->id)->count();
                echo '<a class="dropdown-item text-dark" href="/bl0g.online/bl0g/public/category/'.$category->id.'">'.$category->category_name.' ('.$postsAboutCategory.')</a>';
              }
            
            ?>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{url('/aboutus')}}">Hakkımda</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="{{url('/search')}}" method="POST">@csrf
        <input class="form-control mr-sm-2 " name='searched_content' type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Ara</button>
      </form>
      <ul class="navbar-nav mr-3">
          <li class="nav-item  disable">
        <a class="nav-link text-dark disable">Erzurum :
            <?php 
                include('C:\xampp\htdocs\bl0g.online\bl0g\resources\views\doers\weather.blade.php');
                echo $data->main->temp;
            ?>°
        </a>
      </li></ul>
    <div style="">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('login') }}">{{ __('Giriş yap') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('register') }}">{{ __('Kayıt ol') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-dark" href="/bl0g.online/bl0g/public/messagesForMe"> Mesajlaşma </a>
                            <a class="dropdown-item text-dark" href="/bl0g.online/bl0g/public/changePass"> Şifreni değiştir </a>
                            <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Çıkış Yap') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </li>
          </ul>
    </div>
</div>
  </nav>