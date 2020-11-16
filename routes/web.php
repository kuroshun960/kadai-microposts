<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//    return view('welcome');
// });


Route::get('/', 'MicropostsController@index');


// ユーザー登録機能のルート

    // ('URL','コントローラー　@（の）　アクション名')
    // RegisterController.phpに送られる
    // ->name()は、そのルーティングに名前を設定している。


        //  showRegistrationForm＝auth/register.blade.php を表示するアクション
        //  register.blade.phpは、ユーザー登録ページ
        
        Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');

        Route::post('signup','Auth\RegisterController@register')->name('signup.post');




// 認証機能のルート

        //  ログインフォームを表示するアクション
        // showRegistrationForm＝auth/login.blade.phpを表示する
        
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        
        Route::post('login', 'Auth\LoginController@login')->name('login.post');
        
        Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
        
        
        
        
        
// ユーザー一覧のルート

    //  ミドルウェア（前処理）でAuth(認証)を行う。認証を通過した者だけがこのルートにアクセスできる。
    //  onryは、作成されるルートをindexとshowのみに絞り込んでいる。
    //  prefixは、URLに特定の階層を付与する。
    
    
    Route::group( ['middleware',['auth']],function(){
        Route::group( ['prefix'=>'users/{id}'],function(){
            
            //フォローする
            Route::post('follow', 'UserFollowController@store')->name('user.follow');
            //フォローをはずす
            Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
            //フォロー一覧
            Route::get('followings', 'UsersController@followings')->name('users.followings');
            //フォロワー一覧
            Route::get('followers', 'UsersController@followers')->name('users.followers');
            
            
            //お気に入りする
            Route::post('favoriting', 'FavoritesController@store')->name('post.favoriting');
            //お気に入りはずす
            Route::delete('unfavoriting', 'FavoritesFollowController@destroy')->name('post.unfavoriting');
            //お気に入り一覧
            Route::get('favoritesPost', 'FavoritesController@followings')->name('post.favoritesPost');
            //お気に入りられ一覧
            Route::get('favoritesPost', 'FavoritesController@followers')->name('post.favoritesPost');
            
            
        });
        
        //indexとshowはmicropostsControllerではなく"userController"
        Route::resource('users','UsersController',['only'=>['index','show']]);
        
        Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
        
            
        
    });