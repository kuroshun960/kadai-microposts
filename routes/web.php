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



// ユーザー登録のルート

    // ('URL','コントローラー　@（の）　アクション名')
    // RegisterController.phpに送られる
    // ->name()は、そのルーティングに名前を設定している。


        //  showRegistrationForm＝auth/register.blade.php を表示するアクション
        //  register.blade.phpは、ユーザー登録ページ
        Route::get('signup','Auth/RegisterController@showRegistrationForm')->name('signup.get');

        Route::post('signup','Auth/RegisterController@register')->name('signup.post');
