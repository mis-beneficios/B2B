<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Log;
use App\Traits\BeneficiosTrait;

class AuthController extends Controller
{

    use BeneficiosTrait;

    /**
     * Login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login_customer(Request $request)
    {
        $data['success'] = false;
        $data['user']    = false;
        $data['error']   = __('messages.login.error');

        $username  = $request->username;
        $pass_hash = $request->pass_hash;
        $user      = User::where('username', $username)->where('clave', base64_encode($pass_hash))->first();

        if ($user) {
            if ($user->pass_hash == null) {
                $user->pass_hash = bcrypt(base64_decode($user->clave));
                $user->save();
            }
            $data['user'] = true;
        }

        if (Auth::attempt(['username' => $username, 'password' => $pass_hash])) {
            $data['success']  = true;
            $data['redirect'] = __('messages.login.redirecionar');

            if (Auth::user()->role != 'client') {
                $data['url'] = 'https://admin.beneficiosvacacionales.mx/';
                Auth::logout();
            } else {
                // Log::info('Usuario logueado: ' . Auth::user()->username . ' ' . Auth::user()->fullName);
                $data['url'] = route('inicio');
            }
        }

        return response()->json($data);
    }

    /**
     * Login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {
        dd($request->all());
        $data['success'] = false;
        $data['user']    = false;
        $data['error']   = __('messages.login.error');

        $username  = $request->username;
        $pass_hash = $request->pass_hash;

        if (Auth::attempt(['username' => $username, 'password' => $pass_hash])) {
            Log::info('Usuario logueado: ' . Auth::user()->username . ' ' . Auth::user()->fullName);
            $this->store_incidencia();
            $data['success']  = true;
            $data['redirect'] = __('messages.login.redirecionar');   
        } else {

            $user = User::where('username', $username)->where('clave', base64_encode($pass_hash))->first();

            if ($user) {
                if ($user->pass_hash == null) {
                    $user->pass_hash = bcrypt(base64_decode($user->clave));
                    $user->save();
                }

                if (Auth::attempt(['username' => $username, 'password' => $user->pass_hash])) {
                    // $request->session()->regenerate();
                    // Log::info('Usuario logueado: ' . Auth::user()->username . ' ' . Auth::user()->fullName);
                    $this->store_incidencia();
                    
                    $data['success']  = true;
                    $data['redirect'] = __('messages.login.redirecionar');
                }
            }
        }

        if (Auth::check()) {
            if (Auth::user()->role != 'client') {
                // $request->session()->regenerate();
                // $data['url'] = route('dashboard');
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->route('inicio');
            }
        } else {
            return redirect()->back()->withInput()->with('info', '¡Usuario y/o contraseña incorrectos!');
        }

        // return redirect($data['url'])->with($data);

        // return response()->json($data);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function verify_usa($token)
    {
        $user = User::where('user_hash', $token)->first();
        if ($user) {
            if ($user->confirmado != 1 && $user->permitir_login != 1) {
                $user->confirmado     = 1;
                $user->permitir_login = 1;
                $user->save();
                return redirect()->route('dashboard');
            } else {
                return back();
            }
        }
        abort(404);
    }

    public function reset_password()
    {

    }

    /**
     * Login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login_mb(Request $request)
    {
        return view('auth.login');
    }
}
