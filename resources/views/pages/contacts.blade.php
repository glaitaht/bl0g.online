@extends('layouts.app')
@section('content')
<div class="card-deck">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-envelope"></i> Okunmamış Mesajlar
            </h5>
            @foreach ($contacts as $contact)
                @if ($contact->seen == 1)
                    <div class="card-footer">
                        <i class="fas fa-envelope"></i>&nbsp;~&nbsp;
                        <?php
                            $user =DB::table('users')->where('id',$contact->user_id)->value("name");
                            echo $user;
                        ?> &nbsp;~&nbsp;
                        <?php
                            $message = \Illuminate\Support\Str::limit($contact->message, $limit = 15, $end = '..');
                            echo $message;
                        ?>
                        <a href="/bl0g.online/bl0g/public/contact/{{$contact->id}}">Devamını oku.
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-envelope-open"></i> Okunmuş Mesajlar
            </h5>
            @foreach ($contacts as $contact)
                @if ($contact->seen == 0)
                    <div class="card-footer">
                        <i class="fas fa-envelope-open"></i>&nbsp;~&nbsp;
                        <?php
                            $user =DB::table('users')->where('id',$contact->user_id)->value("name");
                            echo $user;
                        ?> &nbsp;~&nbsp;
                        <?php
                            $message = \Illuminate\Support\Str::limit($contact->message, $limit = 15, $end = '..');
                            echo $message;
                        ?>
                        <a href="/bl0g.online/bl0g/public/contact/{{$contact->id}}">Devamını oku.
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection