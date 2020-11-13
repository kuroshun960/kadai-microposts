@extends('layouts.app')
@section('content')

    {{--ユーザー一覧--}}
    {{--この部分は他のページにも利用したいので、個別にしてまとめておく--}}
    
   @include('users.users')
   
   
@endsection