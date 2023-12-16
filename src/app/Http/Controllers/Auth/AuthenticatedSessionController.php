<?php

namespace App\Http\Controllers\Auth;

use App\Enum\HttpStatus;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FailMessage;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class AuthenticatedSessionController extends Controller
{
    use ApiResponse;
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        if($request->wantsJson()){
           return $this->createToken($request);
        }else{
           return $this->createSession($request);
        }
    }

    /**
     * Handle an incoming authentication request and return token.
     */
    public function createToken(LoginRequest $request)
    {
            // auth guest
            $request->restApiAuthenticate();

            // If user authentication success
            if($request->user()){
                $token = $request->user()->createToken('remindme');

                $authData=['user'=>$request->user,'access_token'=>$token->plainTextToken];

                return $this->showResponseOnJSONFormat(true,$authData);
            }else{
                $authError= new FailMessage("ERR_INVALID_CREDS",trans('auth.failed'));

                return $this->showResponseOnJSONFormat(false,$authError,HttpStatus::UNAUTHORIZED);
            }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function createSession(LoginRequest $request):RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
