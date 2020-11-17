@if(Auth::id() != $user->id)
    {{--フォロー中のユーザーだったら--}}
    @if (Auth::user()->is_following($user->id))
        {{-- お気に入りするボタンのフォーム --}}
            {!! Form::open(['route'=>['user.unfollow',$user->id],'method' => 'delete' ]) !!}
                {!! Form::submit('Unfollow',['class'=>'btn btn-danger btn-block']) !!}
            {!! Form::close() !!}
    @else
        {{-- お気に入りはずすボタンのフォーム --}}
            {!! Form::open(['route'=>['user.follow',$user->id],]) !!}
                {!! Form::submit('Follow',['class'=>'btn btn-danger btn-block']) !!}
            {!! Form::close() !!}
    @endif
@endif