<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
 

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $active = '1';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    // protected function hasTooManyLoginAttempts(Request $request)
    // {
    //     return $this->limiter()->tooManyAttempts(
    //         $this->throttleKey($request), 2, 1
    //     );
    // }
    // public function login(Request $request)
    // {
    //     $email = $request->get('email');
    //     $password = $request->get('password');
    //     if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
    //         return redirect($redirectTo);
    //     }else{
    //         return redirect()->back();
    //     }
    // }
    
    // public function username()
    // {
    //     return 'name';
    // }

    protected function credentials(Request $request)
    {
        $credential = $request->only($this->username(), 'password');
        // Add active whe login
        $credential['active'] = 1;
        return $credential;
    }

    // protected function attemptLogin(Request $request)
    // {
    //     return $this->guard()->attempt(
    //         $this->credentials($request), $request->has('remember')
    //     );
    // }

}
