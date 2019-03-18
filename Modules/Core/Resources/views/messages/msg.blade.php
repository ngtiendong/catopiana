@if(Session::has('msg_error'))
    <?php $messages = Session::get('msg_error'); ?>
    @if (is_array($messages))
        @foreach($messages as $msg)
            <p class="alert alert-danger">{{ $msg }}</p>
        @endforeach
    @else
        <p class="alert alert-danger">{{ $messages }}</p>
    @endif
@endif

@if(Session::has('msg_success'))
    <?php $messages = Session::get('msg_success'); ?>
    @if (is_array($messages))
        @foreach($messages as $msg)
            <p class="alert alert-success">{{ $msg }}</p>
        @endforeach
    @else
        <p class="alert alert-success">{{ $messages }}</p>
    @endif
@endif

@if(Session::has('error_contract'))
    @foreach(Session::has('error_contract') as $val)
        <div class="alert alert-danger">{{$val}}</div>
    @endforeach
@endif