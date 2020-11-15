
{{--自信のIDと、ユーザーのidが異なっていて--}}
@if(Auth::id() != $user->id)

    {{--フォロー中のユーザーだったら--}}
    @if (Auth::user()->is_following($user->id))
        {{-- アンフォローボタンのフォーム --}}
            {!! Form::open(['route'=>['user.unfollow',$user->id],'method' => 'delete' ]) !!}
                {!! Form::submit('Unfollow',['class'=>'btn btn-danger btn-block']) !!}
            {!! Form::close() !!}
    @else
        {{-- フォローボタンのフォーム --}}
            {!! Form::open(['route'=>['user.follow',$user->id],]) !!}
                {!! Form::submit('Follow',['class'=>'btn btn-danger btn-block']) !!}
            {!! Form::close() !!}
    @endif


@endif