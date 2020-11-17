<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    //フォローするアクション
    public function store($id){
        
        //認証済ユーザがフォローする
        \Auth::user()->follow($id);
        //前のURLへリダイレクトさせる
        return back();
    }
    
    
    //フォローはずすアクション
    public function destroy($id){
        //認証済ユーザがフォローをはずす
        \Auth::user()->unfollow($id);
        
        return back();
    }
    

    
}
