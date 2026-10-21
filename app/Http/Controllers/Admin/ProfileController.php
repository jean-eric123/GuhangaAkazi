<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {
    public function index() { $admin = Auth::guard("admin")->user(); return view("admin.profile.index", compact("admin")); }
    public function update(Request $request) {
        $admin = Auth::guard("admin")->user();
        $request->validate(["name" => "required", "email" => "required|email|unique:admins,email,".$admin->id]);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->filled("password")) { $admin->password = Hash::make($request->password); }
        $admin->save();
        return back()->with("success", "Profile updated successfully.");
    }
}