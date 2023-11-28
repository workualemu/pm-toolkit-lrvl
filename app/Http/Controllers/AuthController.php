<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $email ='';
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if (Auth::attempt(array('email' => $validated['email'], 'password' => $validated['password']))) {
            $user =  Auth::user();
            if($user->name == 'Admin'){
                $user->assignRole('Super Admin');
            }
            
            return redirect()->route('index');
        } else {
            $validator->errors()->add(
                'password',
                'The password does not match with username'
            );
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function registerView(Request $request)
    {
        
        $invitation = Invitation::where('email', '=', $request->email)->get()->first();

        if(!isSet($invitation) || $invitation == null){
            $data_validity = "INVALID";
            return view('register', compact('data_validity'));
        }
        $carbon = $invitation->expires_at;
        $expires = true;
        if(!is_null($carbon)){
            $expires = $carbon->lt(Carbon::now()) ? true : false;
            
        }
        $data = [
            'email'  => $request->email,
            'expires'   => $expires
        ];
        return view('register', compact('data'));
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email','unique:users'],
            'password' => ['required',"confirmed", Password::min(7)],
        ]);

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"])
        ]);

        $invitation = Invitation::where('email', '=', $validated["email"])->get()->first();

        $invitation->update([
            'status' => 'Registered',
        ]);
        $role = 'Project Officer';

        if(isSet($invitation->role) && $invitation->role != null){
            $role =  $invitation->role;
        }
        $user->assignRole($role);
        auth()->login($user);

        return redirect()->route('index');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
