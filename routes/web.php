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

Route::get('/', function () {
    return view('welcome');
});



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
        