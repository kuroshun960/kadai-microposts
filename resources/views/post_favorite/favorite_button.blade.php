{{--閲覧者のidじゃなかったら--}}
@if(Auth::id() != $user->id)
    
    {{--閲覧者のがお気に入りしてる投稿じゃなかったら--}}
    @if (Auth::user()->is_favoriting($user->id))
        
        {{-- アンフォローボタンのフォーム --}}
            {{-- 中間テーブルから削除 --}}
            {!! Form::open(['route' => ['favorites.unfavorite', $user->id], 'method' => 'delete']) !!}
                {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-block"]) !!}
            {!! Form::close() !!}
    @else
        
        {{-- フォローボタンのフォーム --}}
            {{-- 中間テーブルに付与 --}}
            {!! Form::open(['route' => ['favorites.favorite', $user->id]]) !!}
                {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-block"]) !!}
            {!! Form::close() !!}
    @endif
@endif