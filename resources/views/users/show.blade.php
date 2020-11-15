@extends('layouts.app')
@section('content')
    <div class="row">
        
        <aside class="col-sm-4">
            @include('users.card')
            
            {{-- フォロー／アンフォローボタン --}}
            @include('user_follow.follow_button')
        </aside>
        

        <div class="col-sm-8">
            @include('users.navtabs')
                @if (Auth::id() == $user->id)
                    {{-- 投稿フォーム --}}
                    @include('microposts.form')
                @endif
                    {{-- 投稿一覧 --}}
                    @include('microposts.microposts')    
        </div>
    </div>
@endsection