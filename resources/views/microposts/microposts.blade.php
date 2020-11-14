@if (count($microposts) > 0)

    <ul class="list-unstyled">
        @foreach ($microposts as $micropost)
        <li class="media mb-3">
            
            {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
            <img class="mr-2 rounded" src="{{ Gravatar::get($micropost->user->email, ['size' => 50]) }}" alt="">
            <div class="media-body">
                <div>
                    {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                    {!! link_to_route('users.show', $micropost->user->name, ['user' =>$micropost->user->id]) !!}
                    <span class="text-muted">posted at {{ $micropost->create_at }}</span>
                </div>
                <div>
                    {{-- 投稿内容 --}}
                    <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                </div>
                
                <div>
                    {{-- 閲覧者が投稿主なら --}}
                    @if(Auth::id() == $micropost->user_id)
                        {{-- 投稿削除ボタンのフォームを表示 --}}
                        {!! Form::open(['route'=>['microposts.destroy',$micropost->id],'method' => 'delete' ]) !!}
                            {!! Form::submit('Delete',['class'=>'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
                
            </div>
        </li>
        @endforeach
    </ul>
    
    {{-- ページネーションのリンク --}}
    {{ $microposts->links() }}

@endif