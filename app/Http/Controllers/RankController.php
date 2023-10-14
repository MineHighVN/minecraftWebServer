<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Rank;
use App\Models\RankPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankController extends Controller {
    private $permRequired = 2;

    public function index (Request $request) {
        if (!$request->user()?->checkPerm($this->permRequired)) return back();

        $permissions = Permission::all();
        $ranks = Rank::all();

        if (!$request->user()?->checkPerm($this->permRequired)) {
            // $redirect->to('/')->send();
            return 'test';
        }

        return view ('admin.rank.rank', [ 'permissions' => $permissions, 'ranks' => $ranks ]);
    }

    public function create (Request $request) {
        if (!$request->user()?->checkPerm($this->permRequired)) return back();

        $rankName = $request->input('rankname');

        $request->validate([
            'rankname'=> 'required'
        ]);

        $rank = new Rank;
        $rank->displayRank = $rankName;
        $rank->save();

        return back();
    }

    public function rankEdit (Request $request, $rankId) {
        if (!$request->user()?->checkPerm($this->permRequired)) return back();

        $permissions = Permission::all();
        $rank = Rank::find($rankId);
        $currentPermissions = $rank->permissions;

        $permissionIds = $permissions->pluck('permId')->toArray();

        $currentPermissionIds = $currentPermissions->pluck('id')->toArray();

        $unusedPermissionIds = array_diff($permissionIds, $currentPermissionIds);

        return view ('admin.rank.rankEdit', [ 'permissions' => $permissions, 'rank' => $rank, 'unusedPermissionIds' => $unusedPermissionIds ]);
    }

    public function togglePermission (Request $request, $rankId, $permissionId) {
        if (!$request->user()?->checkPerm($this->permRequired)) return back();

        $rankPermission = RankPermission::where('rankId', $rankId)->where('permissionId', $permissionId);

        if ($rankPermission->count()) {
            $rankPermission->delete();
        } else {
            $rankPermission = new RankPermission();
            $rankPermission->rankId = $rankId;
            $rankPermission->permissionId = $permissionId;
            $rankPermission->save();
        }

        return back();
    }

    public function deleteRank ($rankId) {
        Rank::where('id', $rankId)->delete();

        return redirect('/admin/rank');
    }
}