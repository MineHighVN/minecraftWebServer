<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller {
    private function hashPassword ($password) {
        return hash('SHA256', $password);
    }

    public function registerPage () {
        if (Auth::check()) return redirect('/');

        return view('auth.register', [ 'title' => 'Register', 'type' => 'register' ]);
    }
    
    public function register (Request $request) {
        if (Auth::check()) return redirect('/');

        $request->validate([
            'username' => 'required|min:4|max:16|regex:/^[a-zA-Z0-9_]+$/u',
            'password' => 'min:6|max:255',
            're-password' => 'same:password'
        ], [
            'username.min' => "Tên đăng nhập cần lớn hơn :min kí tự",
            'username.max' => "Tên đăng nhập không được lớn hơn :max kí tự",
            'username.required' => "Tên đăng nhập không được bỏ trống",
            'password.min' => 'Mật khẩu cần có tối thiểu :min kí tự',
            'password.max' => 'Mật khẩu không được lớn hơn max kí tự',
            're-password.same' => "Mật khẩu và Nhập lại mật khẩu phải giống nhau",
            'username.regex' => "Tên đăng nhập không được có kí tự đặc biệt"
        ]);

        $errors = new MessageBag();

        $username = $request->input('username');
        $password = $request->input('password');
        $repassword = $request->input('re-password');

        try {
            $user = User::where('username', $username)->select('username')->first();

            if (empty($user)) {
                $user = new User;
                $user->username = $username;
                $user->password = $this->hashPassword($password);
                $user->save();
            } else {
                $errors->add('usernameAlreadyTaken', 'Tên đăng nhập đã tồn tại');
            }

        } catch (Exception $e) {
            $errors->add('otherError', 'Lỗi xảy ra ở phía máy chủ');
        }

        return view('auth.register', [ 'title' => 'Register', 'type' => 'register', 'successMsg' => "Đăng ký thành công" ])->withErrors($errors);
    }

    public function login (Request $request) {
        if (Auth::check()) return redirect('/');

        $errors = new MessageBag();

        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $user = User::where('username', $username)->where('password', $this->hashPassword($password))->first();
            if (empty($user)) {
                $errors->add('invalidUsernameOrPassword', 'Tên đăng nhập hoặc mật khẩu không chính xác');
            } else {
                Auth::loginUsingId($user->id, $remember = true);
                return redirect('/');
            }
        } catch (Exception $e) {
            $errors->add('otherError', 'Lỗi xảy ra ở phía máy chủ');
        }

        return view('auth.login', [ 'title' => 'Login', 'type' => 'login', 'successMsg' => 'Đăng nhập thành công' ])->withErrors($errors);
    }

    public function loginPage () {
        if (Auth::check()) return redirect('/');

        return view('auth.login', [ 'title' => 'Login', 'type' => 'login' ]);
    }
}