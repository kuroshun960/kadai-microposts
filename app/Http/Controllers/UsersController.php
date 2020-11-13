<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    //
    
    public function index(){
        
        //ユーザー一覧をidの降順で取得
        $users = User::orderBy('id','desc')->paginate(10);
        
        //変数userの中に↑を格納し、users/indexで表示
        return view('users.index',[
           'users' => $users, 
            
        ]);
    }
    
      
    public function show($id){
        
        //idの値でユーザを検索して取得
        $users = User::findOrFail($id);
        
        //ユーザ詳細ビューでそれを表示
        return view('users.show',[
           'users' => $users, 
            
        ]);
    }
    
    
    
}
