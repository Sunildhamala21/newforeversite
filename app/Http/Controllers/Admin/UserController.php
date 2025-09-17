<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function setting()
    {
        $user = auth()->user()->toArray();

        return view('admin.users.setting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'nullable|min:6',
            'confirm_password' => 'required_with:password|same:password',
        ]);

        $user = auth()->user();

        $user->username = $request->username;

        $password_changed = false;
        if (isset($request->password) && ! empty($request->password)) {
            $user->password = Hash::make($request->password);
            $password_changed = true;
        }

        if ($user->save()) {
            if ($password_changed) {
                auth()->logout();

                return redirect()->route('admin.login')->with('success_message', 'Updated successfully. Please login with new password.');
            }

            session()->flash('success_message', 'Updated successfully.');

        } else {
            session()->flash('error_message', __('alerts.save_error'));
        }

        return redirect()->back();
    }
}
