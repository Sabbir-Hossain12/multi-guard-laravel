<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    
   public function create()
    {
        return view('admin_auth.login');
    }
    
    
    
    public function store(Request $request)
    {
//        dd($request->all());
//        $request->validate(
//            [
//                'email' => ['required', 'string', 'lowercase', 'email'],
//                'password' => ['required'],
//
//            ]
//        );


        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();


            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->route('login');
    }


    public function createRegister()
    {

        return view('admin_auth.register');
    }

    public function storeRegister(Request $request)
    {
        
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'password' => ['required', 'confirmed'],
                
            ]
        );


        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

//        event(new Registered($user));

        Auth::guard('admin')->login($admin);

        return redirect()->intended(route('admin.dashboard'));
        

        
    }
    
    
    
    
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }    
    
    
    

}

