<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\PrivateUserResource;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['guest']);
    // }

    // public function index()
    // {
        
    //     return view('auth.login');
    // }

    public function store(Request $request)
    {   
       
        $this->validate($request,[
            'username' => 'required|max:255',
            'password' => 'required',
        ]);

         //sign the user in
         if (!Auth::attempt($request->only('username', 'password'), $request->remember))
         {
            return back()->with('status', ' Invalid login details');
        }
        return redirect()->route('dashboard');
    
    }

    public function action(Request $request)
    {
        //validation

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$token = Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'errors' => [
                    'message' => ['Could not sign you in with those details.']
                ]
            ], 401);
        } 

        return (new PrivateUserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
        ]);
        
    }
}
