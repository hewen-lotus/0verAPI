<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Validator;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'username';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = NULL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'UserLogout']]);
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Login
    |--------------------------------------------------------------------------
    */
    public function UserLogin(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('username', 'password');

        $validator = Validator::make($credentials, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['messages' => ['invalid credentials']], 401);
        }

        // attempt to verify the credentials and create a token for the user
        if (!Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'deleted_at' => NULL])) {
            return response()->json(['messages' => ['invalid credentials']], 401);
        }

        return $this->UserLoginStatus();
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Logout
    |--------------------------------------------------------------------------
    */
    public function UserLogout()
    {
        Auth::logout();

        return response()->json(['messages' => ['Logged Out!']]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get User Login Status
    |--------------------------------------------------------------------------
    */
    public function UserLoginStatus()
    {
        if (Auth::check()) {
            return User::where('username', '=', Auth::id())
                ->with('admin', 'school_editor.school', 'school_reviewer.school')->first();
        }

        return response()->json(['messages' => ['Not Logged in!']], 401);
    }
}
