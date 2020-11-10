@extends('layouts.app')

@section('content')


    {{--サインアップ--}}
    <div class="text-center">
        <h1>Sign up</h1>
    </div>
    
    
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            
            {!! Form::open(['route' => 'signup.post']) !!}
            
            
            
                {{--名前フォーム--}}
                
                {{--old関数は、直前で入力していた値を再度代入できる関数 --}}
                {{--入力ミスで、エラーになりページが再読み込みされた時、自動で再入力できるようにする --}}
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',old('name'),['class'=>'form-control']) !!}
                </div>
                
                
                {{--Eメールフォーム--}}
                <div class="form-group">
                    {!! Form::label('email','Email') !!}
                    {!! Form::email('email',old('email'),['class'=>'form-control']) !!}
                </div>
                
                
                {{--パスワードフォーム--}}
                {{--パスワードではold関数は使わないほうがよい --}}
                <div class="form-group">
                    {!! Form::label('password','Password') !!}
                    {!! Form::password('password',['class'=>'form-control']) !!}
                </div>
                
                
                {{--パスワード繰り返しフォーム--}}
                <div class="form-group">
                    {!! Form::label('password_confirmation','Confirmation') !!}
                    {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                </div>
                
                
                {{-- ユーザー登録ボタン --}}
                {!! Form::submit('Sign up',['class' => 'btn btn-primary btn-block']) !!}
            
            
            {!! Form::close() !!}
            
        </div>
    </div>



@endsection