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
            $this->loadCount('microposts');
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
            
            if($exist||$its_me){
            
                //すでにフォローしていれば何もしない    
                return false;
                
            }else{
                
                //未フォローであればフォローする
                $this->followings()->attach($userId);
                return true;
            }
        }
    
    
        
    //$userIdで指定されたユーザをアンフォローする。
        
        public function unfollow($userId){
            //すでにフォローしているかの確認
            $exist = $this->is_following($userId);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $userId;
            
            if($exist && !$its_me){
            
                // すでにフォローしていればフォローを外す
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
        public function favoritesPost(){
        return $this->belongsToMany(User::class, 'favorites','user_id','micropost_id')->withTimestamps();
        }

    //このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
    //このユーザに関係するモデルの件数をロードする。
        public function favoritesNowCounts(){
            $this->loadCount('favoritesPost');
        }


    //$userIdで指定されたユーザをお気に入りする。
        
        public function favoriting($userId){
            //すでにお気に入りているかの確認
            $exist = $this->is_favoriting($userId);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $userId;
            
            if($exist||$its_me){
            
                //すでにフォローしていれば何もしない    
                return false;
                
            }else{
                
                //お気に入りしてなければお気に入りする
                $this->favoritesPost()->attach($userId);
                return true;
            }
        }
        
    //$userIdで指定されたユーザをお気に入りからはずす。
        
        public function unfavoriting($userId){
            //すでにお気に入りしているかの確認
            $exist = $this->is_favoriting($userId);
            
            //相手が自分自身かの確認
            $its_me = $this->id == $userId;
            
            
            //既にお気に入り"かつ"自分以外なら
            if($exist && !$its_me){
            
                // すでにお気に入りしてる投稿ならばフォローを外す
                $this->favoritesPost()->detach($userId);
                return true;
                
            }else{
                
                //お気に入りしてなければなにもしない
                return false;
            }
        }
    
    
    /*
    指定された $userIdのユーザをこのユーザがお気に入り中か判定する。フォロー中ならtrueを返す。
    ・すでにフォローしているか
    ・相手が自分自身かどうか
    
    フォロー／アンフォローとは、中間テーブルのレコードを保存／削除すること
    
    */
        
        public function is_favoriting($userId){

            // お気に入りしてる投稿の中に $userIdのものが存在するか
            return $this->favoritesPost()->where('micropost_id',$userId)->exists();
        }
        
        
        public function feed_favoritesPost(){
            // このユーザがフォロー中のユーザのidを取得して配列にする
            $userIds = $this->favoritesPost()->pluck('users.id')->toArray();
            // このユーザのidもその配列に追加
            $userIds[] = $this->id;
            // それらのユーザが所有する投稿に絞り込む
            return Micropost::whereIn('user_id',$userIds);
        }
    
    

        
        
        
}


