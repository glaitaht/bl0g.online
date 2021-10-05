@extends('layouts.app')
@section('content')
<div class="card-deck">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title" >
                <i class="fas fa-envelope-open"></i>
                Adminle yapılan mesajlaşmalar      
            </h5>
            <?php
                    foreach ($contact as $conv) {
                        $class ='';
                        if($conv->user_id == Auth::user()->id and $conv->messageFor != -1) continue;
                        if($conv->user_id != Auth::user()->id) $class = 'alert alert-dark';
                        else $class = 'alert alert-success';
                        echo '
                            <div class="card-footer" style="padding-top: 25px;">
                                <div class="'.$class.'">
                                <i class="fas fa-envelope-open"></i>&nbsp;&nbsp;&nbsp;~&nbsp;
                                ';
                                if($conv->user_id == Auth::user()->id) echo Auth::user()->name.'&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                else echo 'Admin &nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                echo $conv->message.'&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;';
                                echo '<div style="float:right">'.$conv->created_at.'</div>';
                        echo '
                            </div>  
                            </div>
                        ';
                    }
            ?>
        </div>
    </div>
</div>
@endsection