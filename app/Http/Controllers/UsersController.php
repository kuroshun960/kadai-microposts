<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    //
    
    public function index(){
        
        //ユーザー一覧をidの降順で取得
        $users = User::orderBy('id','desc')->paginate(8);
        
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
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(8);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
        
        return view('microposts.microposts', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
    
    
    
    //ユーザのフォロー一覧ページを表示するアクション。
    
    public function followings($id){
        
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate(8);
        
        // フォロー一覧ビューでそれらを表示
        return view('users.followings',[
            'user' => $user,
            'users' => $followings,
            
            ]);
        
    }
    
    
    //ユーザのフォロワー一覧ページを表示するアクション。
    
    public function followers($id){
        
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        
        $followers = $user->followers()->paginate(8);
        
        return view('users.followers',[
            'user' => $user,
            'users' => $followers,
            
            ]);
        
        
    }
    
    
    
    //ユーザのお気に入り投稿一覧ページを表示するアクション。
    
    public function favoritesPost($id){
        
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        // ユーザのフォロー一覧を取得
        $favoritesPost = $user->favoritesPost()->paginate(8);
        
        // フォロー一覧ビューでそれらを表示
        return view('users.favoritesPost',[
            'user' => $user,
            'microposts' => $favoritesPost,
            
            ]);

        
    }
    
    
    
}
