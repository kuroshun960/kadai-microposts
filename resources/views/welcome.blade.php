@extends('layouts.app')

@section('content')

    @if(Auth::check())
        {{ Auth::user()->name }}
    @else


    <div class="center jumbotron">
        <div class="text-center">
            
            <h1>Welcom to the Microposts</h1>
            {{-- ユーザー登録ページへのリンク --}}
            {{-- 第一引数のsignup.getは、web.phpでname->()で命名した名前でルートを指定している。 --}}
            {!! link_to_route('signup.get','Sign up now!',[],['class'=>'btn btn-lg btn-primary']) !!}
            
        </div>
    </div>
    
    @endif
    



@endsection