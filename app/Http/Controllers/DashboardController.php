<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {

        $is_admin = Auth::user()->is_admin;

        if (Auth::user() && $is_admin == 0) {

            $user = Auth::user();

            $pageTitle = $user->name . "'s Dashboard || EverFresh Creations";

            return view('user.dashboard', compact('pageTitle'));

        } elseif (Auth::user() && $is_admin == 1) {

            $pageTitle = "Admin Dashboard || EverFresh Creations";

            return view('admin.dashboard', compact('pageTitle'));
        }
    }
}
