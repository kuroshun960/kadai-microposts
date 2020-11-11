@extends('layouts.app')
@section('content')

    {{--サインアップ--}}
    <div class="text-center">
        <h1>Log in</h1>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::open(['route' => 'login.post']) !!}
                {{--Eメールフォーム--}}
                <div class="form-group">
                    {!! Form::label('email','Email') !!}
                    {!! Form::email('email',old('email'),['class'=>'form-control']) !!}
                </div>
                
                {{--パスワードフォーム--}}
                <div class="form-group">
                    {!! Form::label('password','Password') !!}
                    {!! Form::password('password',['class'=>'form-control']) !!}
                </div>
                
                {{-- ログインボタン --}}
                {!! Form::submit('Log up',['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
            {{-- ユーザー登録はまだ？ボタン --}}
            <p class="mt-2">New user? {!! link_to_route('signup.get','Sign up now!')!!}</p>
        </div>
    </div>
@endsection