<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#6a8fb3 ;">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">Microposts</a>
        
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                
                
                
                {{-- ログイン中だったら --}}
                
                    {{-- Authには、認証にまつわる一連のメソッドがある --}}
                    {{-- ログイン済みのユーザーかどうかチェック --}}
                     @if (Auth::check())
                    
                        {{-- ユーザー一覧ページへのリンク --}}
                        <li class="nav-item">{!! link_to_route('users.index', 'Users', [], ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                            
                                {{-- ドロップダウンメニュー --}}    
                            <ul class="dropdown-menu dropdown-menu-right">
                                {{-- ユーザ詳細ページへのリンク --}}
                                <li class="dropdown-item">{!! link_to_route('users.show', 'My profile', ['user' => Auth::id()]) !!}</li>
                                
                                
                                <li class="dropdown-item">
                                <a href="{{ route('users.favoritesPost',['id'=> Auth::user()->id ])  }}">Favorites
                                </a></li>
                                
                                
                                <li class="dropdown-divider"></li>
                                {{-- ログアウトへのリンク --}}
                                <li class="dropdown-item">{!! link_to_route('logout.get', 'Logout') !!}</li>
                            </ul>
                        </li>
                        
                        
                {{-- ログインしていなかったら --}}    
                
                    @else
                    
                        {{-- ユーザー登録ページへのリンク --}}
                        <li class="nav-item">{!! link_to_route('signup.get','Signup',[],['class'=>'nav-link']) !!}</li>
                        {{-- ログインページへのリンク --}}
                        <li class="nav-item">{!! link_to_route('login','Login',[],['class'=>'nav-link']) !!}</li>
                    
                    @endif
                
            </ul>
        </div>
        
        
    </nav>
</header>