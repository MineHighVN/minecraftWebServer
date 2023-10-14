<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;

class RulesController extends Controller
{
    private $permRequired = 5;

    public function index (Request $request) {
        $rules = Rule::all();

        $user = $request->user();

        $admin = $user->checkPerm($this->permRequired);

        return view('admin.rules.rules', [ 'rules' => $rules, 'admin' => $admin ])->with('select', 'rules');
    }

    public function addRule (Request $request) {
        $user = $request->user();

        if (!$user->checkPerm($this->permRequired)) return back()->withErrors([ 'notEnoughPermissions' => "Bạn không đủ quyển để thực hiện hành động này" ]);

        $request->validate([
            'content' => 'required'
        ], [
            'content.required' => "Nội dung không được để trống"
        ]);

        $rule = new Rule;

        $rule->content = $request->input('content');

        $rule->save();

        return back()->with('success', 'Thêm luật mới thành công');;
    }

    public function deleteRule (Request $request, $id) {
        $user = $request->user();

        if (!$user->checkPerm($this->permRequired)) return back()->withErrors([ 'notEnoughPermissions' => "Bạn không đủ quyển để thực hiện hành động này" ]);

        Rule::where('id', $id)->delete();

        return back()->with('success', 'Xóa luật thành công');
    }
}
