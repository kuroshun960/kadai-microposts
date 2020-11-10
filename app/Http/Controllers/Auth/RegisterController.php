<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //  RegistersUsersに定義されたメソッドをトレイトしている　
    //  web.phpに記述したコントローラーは既に定義されている。
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
     
    // ユーザ登録が完了すると、ログイン状態になった上で、指定のリダイレクト先へ飛ぶ処理を変数に定義
    // RouteServiceProvider.phpの定数 HOME に実際の処理内容が書いてある
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        //  コントローラのアクションが実行される前（後）に実行される前処理（後処理）
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    // ユーザー登録フォームデータのバリデーション
     
    protected function validator(array $data)
    {
        return Validator::make($data, [
            
            // 空欄不可 文字列で、最低八文字以上
            
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    // RESTfulルートのcreateとは別物。
    // Userを新規作成する。
 
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
