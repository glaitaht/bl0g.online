@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Giriş başarılı.') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Başarıyla giriş yaptınız.') }}
                    <?php 
                        if(Auth::check() and Auth::user()->isAdmin == 1){
                            echo "<script>
                            window.location = 'https://bl0g.online/bl0g.online/bl0g/public/adminPanel/';</script>";
                        }
                        else{
                            echo "<script>
                            window.location = 'https://bl0g.online/bl0g.online/bl0g/public/posts/';</script>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
