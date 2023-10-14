<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index (Request $user) {
        $permsCount = $user->user()?->getRank->permissions->count() ? true : false;

        return view('home', [ 'select' => 'home', 'permsCount' => $permsCount ]);
    }
}