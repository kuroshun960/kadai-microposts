<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //「一気に保存可能」なものをここで設定
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     //パスワードなど秘匿に表示したいものをここで設定
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    
/*////////////////////////////////////////////////

    投稿

////////////////////////////////////////////////*/

    //このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
        public function microposts(){
        return $this->hasMany(Micropost::class);
        }

        public function loadRelationshipCounts(){
            $this->loadCount('favorites_post','microposts', 'followings', 'followers');
        }
        
/*////////////////////////////////////////////////

    フォロー機能

////////////////////////////////////////////////*/
           
    // 1.モデルのクラス 2.中間テーブル名 3.自分のidとつながってる中間id  4.相手先のidとつながってる中間id
    
    //このユーザ「が」フォロー中のユーザ。（ Userモデルとの関係を定義）
        public function followings(){
            return $this->belongsToMany(User::class, 'user_follow','user_id','follow_id')->withTimestamps();
        }
    
    //このユーザ「を」フォロー中のユーザ。（ Userモデルとの関係を定義）
        public function followers(){
            return $this->belongsToMany(User::class, 'user_follow','follow_id','user_id')->withTimestamps();
        }    
        
        
    //$userIdで指定されたユーザをフォローする。
        
        public function follow($userId){
            //すでにフォローしているかの確認
            $exist = $this->is_following($userId);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $userId;
            
            //フォロー中"または"自分の投稿だったら
            if($exist||$its_me){
            
                // なにもおこらない
                return false;
                
            //フォロー中"または"自分の投稿じゃなかったら
            }else{
                
                //中間テーブル付与
                $this->followings()->attach($userId);
                return true;
            }
        }
    
    
        
    //$userIdで指定されたユーザをアンフォローする。
        
        public function unfollow($userId){
            //すでにフォローしているかの確認 してたらtrue
            $exist = $this->is_following($userId);
            
            //相手が自分自身の投稿かを確認 してたらtrue
            $its_me = $this->id == $userId;
            
            //フォロー中"かつ"自分の投稿じゃなかったら
            if($exist && !$its_me){
            
                // すでにフォローしていればフォローを外す
                // 中間テーブルからレコード削除
                $this->followings()->detach($userId);
                return true;
                
            }else{
                
                //未フォローであればなにもしない
                return false;
            }
        }
        
    
    //指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
        
        public function is_following($userId){

            // フォロー中ユーザの中に $userIdのものが存在するか
            return $this->followings()->where('follow_id',$userId)->exists();
        }
        
        
        public function feed_microposts(){
            // このユーザがフォロー中のユーザのidを取得して配列にする
            $userIds = $this->followings()->pluck('users.id')->toArray();
            // このユーザのidもその配列に追加
            $userIds[] = $this->id;
            // それらのユーザが所有する投稿に絞り込む
            return Micropost::whereIn('user_id',$userIds);
        }
    
/*////////////////////////////////////////////////

    お気に入り機能

////////////////////////////////////////////////*/
        
        
    // 1.モデルのクラス 2.中間テーブル名 3.自分のidとつながってる中間id  4.相手先のidとつながってる中間id
    //このユーザがお気に入りしてる投稿。（ Micropostモデルとの関係を定義）
        public function favorites_post(){
        return $this->belongsToMany(Micropost::class, 'favorites','user_id','micropost_id')->withTimestamps();
        }
        
        
    // 1.モデルのクラス 2.中間テーブル名 3.自分のidとつながってる中間id  4.相手先のidとつながってる中間id
    //この投稿をお気に入りしてるユーザー。（ Micropostモデルとの関係を定義）
    public function favoritesUser(){
    return $this->belongsToMany(Micropost::class, 'favorites','micropost_id','user_id')->withTimestamps();
    }
    
    

    //$micropostで指定されたユーザをお気に入りする。
        
        public function favoriting($micropost){
            //すでにお気に入りているかの確認
            $exist = $this->is_favoriting($micropost);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $micropost;
            
            if($exist||$its_me){
            
                //すでにフォローしていれば何もしない    
                return false;
                
            }else{
                
                //お気に入りしてなければお気に入りする
                $this->favorites_post()->attach($micropost);
                return true;
            }
        }
        
    //$micropostで指定されたユーザをお気に入りからはずす。
        
        public function unfavoriting($micropost){
            //すでにお気に入りしているかの確認
            $exist = $this->is_favoriting($micropost);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $micropost;
            
            
            //既にお気に入り"かつ"自分以外なら
            if($exist && !$its_me){
            
                // すでにお気に入りしてる投稿ならばフォローを外す
                $this->favorites_post()->detach($micropost);
                return true;
                
            }else{
                
                //お気に入りしてなければなにもしない
                return false;
            }
        }
    
    
    /*
    指定された $micropostのユーザをこのユーザがお気に入り中か判定する。フォロー中ならtrueを返す。
    ・すでにフォローしているか
    ・相手が自分自身かどうか
    
    フォロー／アンフォローとは、中間テーブルのレコードを保存／削除すること
    
    */
        
        public function is_favoriting($micropost){

            // お気に入りしてる投稿の中に $micropostのものが存在するか
            return $this->favorites_post()->where('micropost_id',$micropost)->exists();
        }
        
        
        public function feed_favoritesPost(){
            // このユーザがフォロー中のユーザのidを取得して配列にする
            $microposts = $this->favorites_post()->pluck('users.id')->toArray();
            // このユーザのidもその配列に追加
            $microposts[] = $this->id;
            // それらのユーザが所有する投稿に絞り込む
            return Micropost::whereIn('user_id',$microposts);
        }
    
    

        
        
        
}


