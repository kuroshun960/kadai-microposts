<ul class="nav nav-tabs nav-justified mb-3">

                
    {{-- タイムラインタブ --}}
    <li class="nav-item">
                    
    {{-- routeIs　リクエスト元のルートがusers.showの場合、タブの文字がactiveになる。参考演算子。 --}}
    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
        TimeLine
    <span class="bagde bagde-secondary">{{ $user->microposts_count }}</span>    
    </a>
    </li>
    
    {{-- フォロー一覧タブ --}}                    
    <li class="nav-item">
        <a href="{{ route('users.followings',['id'=> $user->id ])  }}" class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}">
        Follow
    <span class="bagde bagde-secondary">{{ $user->followings_count }}</span>        
        </a>
        </li>
    
    
    {{-- フォロワー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.followers',['id'=> $user->id ])  }}" class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}">
        Followers
    <span class="bagde bagde-secondary">{{ $user->followers_count }}</span>        
        </a>
        </li>
        
    {{-- お気に入り一覧タブ --}}                    
    <li class="nav-item">
        <a href="{{ route('users.favoritesPost',['id'=> $user->id ])  }}" class="nav-link {{ Request::routeIs('users.favoritesPost') ? 'active' : '' }}">
        Favorites
    <span class="bagde bagde-secondary">{{ $user->favoritesPost_count }}</span>        
        </a>
        </li>    
    
        
</ul>