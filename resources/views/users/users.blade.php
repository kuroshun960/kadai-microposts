@if(count($users) > 0)
    
    <ul class="list-unstyled">
        
        @foreach ($users as $user)
        
            <li class="media">
                {{-- ユーザーのメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($user->email, ['size' => 50]) }}" alt="">
                <div>
                    {{ user->name }}
                </div>
                <div>
                    {{-- ユーザー詳細ページへのリンク --}}
                    <p>{!! link_to_route('user.show', 'View profile', ['user' => $user->id]) !!}</p>
                </div>
                
            </li>
        @endforeach
        
    </ul>
    
    {{---ページネーションへのリンク--}}
    {{ $user->link() }}
    



@endif