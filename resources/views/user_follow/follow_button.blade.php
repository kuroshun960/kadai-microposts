@if(Auth::id() != $user->id)
    {{--フォロー中のユーザーだったら--}}
    @if (Auth::user()->is_following($user->id))
        {{-- お気に入りするボタンのフォーム --}}
            {!! Form::open(['route'=>['user.unfollow',$user->id],'method' => 'delete' ]) !!}
                {!! Form::submit('Unfollow',['class'=>'btn btn-block mt-2' ,'style' => "border: solid 2px #44afec; color: #44afec;"]) !!}
            {!! Form::close() !!}
    @else
        {{-- お気に入りはずすボタンのフォーム --}}
            {!! Form::open(['route'=>['user.follow',$user->id],]) !!}
                {!! Form::submit('Follow',['class'=>'btn btn-primary btn-block mt-2' ]) !!}
            {!! Form::close() !!}
    @endif
@endif