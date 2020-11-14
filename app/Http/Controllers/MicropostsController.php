<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    
    public function index(){
     
     // 変数を初期化
     $data = [];
     
     // 認証済の場合は
     if (\Auth::check()){
     
        // 認証済ユーザーを取得    
         $user = \Auth::user();
        
        // 投稿内容を作成日時が新しい順で取得
         $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
         
         $data = [
             'user' => $user,
             'microposts' => $microposts,
             
             ];
         
     }
    
    // Welcomビューでそれらを表示
        
    return view('welcome', $data);    
    
        
    }
    
    
    public function store(Request $request){
        
        //バリデーション
        $request->validate([
            
            'content' => 'required|max:255', 
            
            ]);
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->microposts()->create([
            'content' => $request->content,
            ]);
        
        
        // 前のURLへリダイレクトさせる
        return back();
        
    }
    
    
    public function destroy($id){
    
    // idの値で投稿を検索して取得
    $micropost = \App\Micropost::findOrFail($id);
    
    
    // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
    if (\Auth::id() === $micropost->user_id){
        $micropost->delete();
    }
    
    // 前のURLへリダイレクトさせる
        return back();
    
    }






}
