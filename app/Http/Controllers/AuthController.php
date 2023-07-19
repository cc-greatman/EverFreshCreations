<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display registration page
     *
     * @return \Illuminate\Http\Response
     */
    public function show() {

        $pageTitle = "Sign Up || EverFresh Creations";

        return view('auth.register', compact('pageTitle'));
    }

    /**
     * Handles account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request) {

        $user = User::create($request->validated());

        $data = $request->all();

        $token = Str::random(64);

        UserVerify::create([
                    'user_id' => $user->id,
                    'token' => $token
                    ]);

        Mail::send('emails.verificationEmail', ['token' => $token], function($message) use($request){
        $message->to($request->email);
        $message->subject('Email Verification Mail');
        });

        auth()->login($user);

        $request->session()->regenerate();

        return redirect()->route('verification.notice');
    }

    /**
      * Display Page user sees while waiting for mail
      *
      * @var string
      */
      public function verifyemail() {

        $pageTitle = "Verify Email || EverFresh Creations";

        return view('user.dashboard', compact('pageTitle'));
      }

    /**
     * Handles Email Verification
     *
     * @return response()
     */
    public function verifyAccount($token) {

    $verifyUser = UserVerify::where('token', $token)->first();

    $message = 'Sorry your email cannot be identified.';

    if(!is_null($verifyUser)) {
        $user = $verifyUser->user;
        if(!$user->is_email_verified) {
            $verifyUser->user->is_email_verified = 1;
            $verifyUser->user->save();
            $message = "Your e-mail is verified. You can now login.";

            $name = UserVerify::first()->user->name;
            $mail = $verifyUser->user;

            Mail::send('emails.verifiedEmail', ['name' => $name],  function($message) use($mail) {

                $message->to($mail->email);
                $message->subject('Successful Email Verification');
                });

            return redirect()->route('dashboard')->with('message', $message);

        } else {
            $message = "Your e-mail is already verified. You can now login.";
        }
    }
        return redirect()->route('login.show')->with('message', $message);
    }

    /**
     * Display login page
     *
     * @return Renderable
     */
    public function display() {

        $pageTitle = "Log In || EverFresh Creations";

        return view('auth.login', compact('pageTitle'));
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request){

        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $request->session()->regenerate();

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) {

        return redirect()->route('dashboard');
    }

    /**
     * Logs User out of account
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform() {

        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
