<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }
    public function updateprofile(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);



        $user = User::findOrFail(Auth::id());

        if (isset($image)) 
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $slug.'-' .$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            if (Storage::disk('public')->exists('profile/'.$user->image))
            {
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            $profile = Image::make($image)->resize(500,500)->stream();

            Storage::disk('public')->put('profile/'.$imageName,$profile);
        } else {
            $imageName = $user->image;
        }

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->images = $imageName;
        $user->about  = $request->about;

        $user->save();

        Toastr::success('User profile updated successfully :)', 'Success');
        return redirect()->back();
    }

    public function updatepassword(Request $request)
    {
       $this->validate($request, [
           'old_password' => 'required',
           'password' => 'required|confirmed'
       ]);

       $hashedpassword = Auth::user()->password;

       if (Hash::check($request->old_password,$hashedpassword))
       {
           
            if (!Hash::check($request->password,$hashedpassword))
            { 
                $user = User::find(Auth::id());

                
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password succesfully changed','Success');
                Auth::logout();
                return redirect()->back();
            } else{
                Toastr::error('New password should not be same as old password','Error');
                return redirect()->back();
            }


       } else{
           Toastr::error('Current password not matched','Error');
           return redirect()->back();
       }
    }
}
