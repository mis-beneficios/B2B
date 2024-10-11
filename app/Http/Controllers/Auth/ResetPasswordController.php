<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\PassPacific;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use PassPacific;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token = null, $username = null)
    {

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'username' => $username]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $user = User::where([
            'username'  => $request->username,
            'user_hash' => $request->token,
        ])->first();

        if ($user) {
            // $pass            = $this->get_password($request->password);
            $user->password  = bcrypt($request->password);
            $user->clave     = base64_encode($request->password);
            $user->pass_hash = bcrypt($request->password);
            $user->save();

            if (Auth::attempt(['username' => $user->username, 'password' => $user->pass_hash])) {
                return redirect()->url('/');
            } else {
                return redirect()->route('login');
            }
        } else {
            return back()->with('status', 'Usuario no existente!');
        }
    }
}
