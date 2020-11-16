<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    
    //投稿を変数に格納
    protected $fillable = ['content'];
    
    //単数系の"user"でメソッドを定義
    //ユーザーインスタンスに対して、複数の投稿のレコードが紐づく
    //この投稿を所有するユーザ。（ Userモデルとの関係を定義）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    
    //このユーザに関係するモデルの件数をロードする。
    public function loadRelationshipCounts()
    {
        $this->loadCount('microposts');
    }
    
    
    // 1.モデルのクラス 2.中間テーブル名 3.自分のidとつながってる中間id  4.相手先のidとつながってる中間id
    //この投稿をお気に入りしてるユーザー。（ Micropostモデルとの関係を定義）
    public function favoritesUser(){
    return $this->belongsToMany(Micropost::class, 'favorites','micropost_id','user_id')->withTimestamps();
    }
    
    
    
}
