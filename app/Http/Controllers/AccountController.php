<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Rank;

include __DIR__ . '/../Utils/getTime.php';

class AccountController extends Controller {
    private $requiredPerm = 4;

    public function index (Request $request) {
        $user = $request->user();

        if (!$user) return redirect('/login');

        $admin = $user->checkPerm($this->requiredPerm);

        return view('account.profile', [ "user" => $user, 'select' => 'profile', 'edit' => true, 'other' => false, 'admin' => $admin, 'ranks' => Rank::all() ]);
    }

    public function logout (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function otherUser (Request $request, $username) {
        $user = $request->user();
        $edit = false;

        $admin = $user?->checkPerm($this->requiredPerm);

        if ($admin || ($user && $user->username == $username)) {
            $edit = true;
        }

        $profile = User::where('username', $username)->first();

        return view('account.profile', [ "user" => $profile, 'select' => 'profile', 'edit' => $edit, 'other' => true, 'admin' => $admin, 'ranks' => Rank::all() ]);
    }

    public function updateUser (Request $request, $user) {
        $email = $request->input('email');
        $description = $request->input('description');

        $updateUser = $user;
        $user = $request->user();

        $updateUserData = User::where('username', $updateUser)->first();
        
        if (!$updateUserData) return back()->withErrors([ 'cannotFindUser' => "Không tìm thấy người dùng" ]);
        if ($updateUserData->weight >= $user->weight && $user->username != $updateUser) return back()->withErrors([ 'notEnoughPermissions' => 'Không thể chỉnh sửa, Người dùng này có độ ưu tiên cao hơn hoặc bằng bạn' ]);
                
        if (!($user->username == $updateUser || $user->checkPerm($this->requiredPerm))) return back()->withErrors([ 'notEnoughPermissions' => 'Bạn không có quyền để chỉnh sửa thông tin của người dùng này' ]);

        if ($email)
            $request->validate([
                'email' => 'regex:/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/u'
            ], [
                'email.regex' => 'Email không hợp lệ'
            ]);
        
        User::where('username', $updateUser)->update([
            'email' => $email ?? "",
            'description' => $description ?? ""
        ]);

        return back()->with('success', 'Cập nhật thành công');
    }

    public function updateUserAdmin (Request $request, $user) {
        $updateUser = $user;
        $user = $request->user();
        
        if (!$user->checkPerm($this->requiredPerm)) return back()->withErrors([ 'notEnoughPermissions' => "Bạn không đủ quyền để thực hiện hành động này" ]);
        
        if ($user->username === $updateUser) return back()->withErrors([ 'cannotUpdateSelf' => "Bạn không thể tự chỉnh sửa cho chính mình" ]);

        $updateUserData = User::where('username', $updateUser)->first();

        if (!$updateUserData) return back()->withErrors([ 'cannotFindUser' => "Không tìm thấy người dùng" ]);

        if ($updateUserData->weight >= $user->weight) return back()->withErrors([ 'notEnoughPermissions' => 'Không thể chỉnh sửa, Người dùng này có độ ưu tiên cao hơn hoặc bằng bạn' ]);

        $request->validate([
            'weight' => 'min:0|max:999',
            'rank' => 'regex:/^[0-9]+$/u'
        ], [
            'weight.min' => "Độ ưu tiên không được nhỏ hơn 0",
            'weight.max' => "Dộ ưu tiên không được lớn hơn 999",
            'weight.rank' => 'Rank không hợp lệ'
        ]);

        $weight = $request->input('weight');
        $rank = $request->input('rank');

        if ((int)$weight > $user->weight) return back()->withErrors([ 'notEnoughPermissions' => "Không thể chỉnh sửa độ ưu tiên của người này cao hơn độ ưu tiên của bạn" ]);

        if(!Rank::findOrFail($rank)) back()->withErrors([ 'cannotFindRank' => "Không tìm thấy rank này" ]);

        User::where("username", $updateUser)->update([
            'rank' => $rank,
            'weight' => $weight
        ]);

        return back()->with('success', 'Cập nhật thành công');
    }
}