<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index() {
        return view('frontend.index');
    }

    public function UserProfile() {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('frontend.dashboard.edit_profile', compact('profileData'));
    }

    public function UserStore(Request $request) {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')) {
            $file = $request->file('photo'); //get the uploaded file
            @unlink(public_path('upload/user_images/'.$data->photo));//To remove existing image
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }  
    
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }
    
    public function UserChangePassword() {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('frontend.dashboard.user_profile_change_password', compact('profileData'));
    } 
    
    public function ChangePasswordStore(Request $request) {
        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if(!Hash::check($request->old_password, auth::user()->password)) {
            $notification = array(
                'message' => 'Old Password does not match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        //Update the password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }     
}
