<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function login(Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            
            // $validated = $request->validate([
            //     'email' => 'required|Email|max:255',
            //     'password' => 'required',
            // ]);

            $rules = [
                'email' => 'required|Email|max:255',
                'password' => 'required',
            ];
            $custom_msg = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request,$rules,$custom_msg);
            

            if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'], 'status'=>1])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_msg', 'Invalid Email or Password');
            }
        } else {
            //
        }

        return view('admin.login');
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
