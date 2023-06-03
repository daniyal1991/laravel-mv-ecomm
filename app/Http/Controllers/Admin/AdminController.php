<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                if ($data['new_password'] == $data['confirm_password']) {
                    $adminId = Auth::guard('admin')->user()->id;
                    Admin::where('id', $adminId)->update(['password'=>bcrypt($data['new_password'])]);

                    return redirect()->back()->with('success_msg','Password updated successfully!');
                } else {
                    return redirect()->back()->with('error_msg','Confrim password should match with New Password');
                }
                
            } else {
                return redirect()->back()->with('error_msg','Current password is incorrect!');
            }
        } 

        $adminData = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        
        return view('admin.settings.update_password')->with('adminData', $adminData);
    }

    public function updateAdminDetails(Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_phone' => 'required|numeric',
            ];
            
            $this->validate($request, $rules);

            //Upload Admin photo
            $imageName = '';
            
            if ($request->hasFile('admin_photo')) {
                $imageTemp = $request->file('admin_photo');
                
                $imageFilename = pathinfo($imageTemp->getClientOriginalName(), PATHINFO_FILENAME);
                $imageFileExt = pathinfo($imageTemp->getClientOriginalName(), PATHINFO_EXTENSION);

                if ($imageTemp->isValid()) {
                    //Generate new image name
                    $imageName = $imageFilename.'_'.rand(111, 99999).'.'.$imageFileExt;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    //Upload the image
                    Image::make($imageTemp)->save($imagePath);
                }
            } else {
                $imageName = $data['current_photo'];
            }
            
            $adminId = Auth::guard('admin')->user()->id;

            Admin::where('id', $adminId)->update(['name'=>$data['admin_name'], 'phone'=>$data['admin_phone'], 'image'=>$imageName]);

            return redirect()->back()->with('success_msg','Details updated successfully!');
        } 

        $adminData = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        
        return view('admin.settings.update_details')->with('adminData', $adminData);
    }

    public function checkAdminPassword(Request $request) {
        $data = $request->all();

        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function login(Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            
            //With default messages
            // $validated = $request->validate([
            //     'email' => 'required|Email|max:255',
            //     'password' => 'required',
            // ]);

            //With custom messages
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
            if (Auth::guard('admin')->check()) {
                return redirect('admin/dashboard');
            }
        }

        return view('admin.login');
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
