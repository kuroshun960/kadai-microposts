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
    
    
    
    
    //投稿一覧は、MicropostsControllerではなく"UserControllre"
      
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザの投稿一覧を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
}
