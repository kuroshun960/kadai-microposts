@if(Auth::id() != $user->id)
    {{--フォロー中のユーザーだったら--}}
    @if (Auth::user()->is_favoriting($user->id))
        {{-- アンフォローボタンのフォーム --}}
            {!! Form::open(['route' => ['favorites.unfavorite', $user->id], 'method' => 'delete']) !!}
                {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-block"]) !!}
            {!! Form::close() !!}
    @else
        {{-- フォローボタンのフォーム --}}
            {!! Form::open(['route' => ['favorites.favorite', $user->id]]) !!}
                {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-block"]) !!}
            {!! Form::close() !!}
    @endif
@endif