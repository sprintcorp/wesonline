<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResources;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','passwordReset','resetToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Invalid login credentials'], 401);
        }

        return $this->createNewToken($token);
    }

    // /**
    //  * Register a User.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function register(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email|max:100|unique:users',
    //         'password' => 'required|string|confirmed|min:6',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     $user = User::create(array_merge(
    //                 $validator->validated(),
    //                 ['password' => bcrypt($request->password)]
    //             ));

    //     return response()->json([
    //         'message' => 'User successfully registered',
    //         'user' => $user
    //     ], 201);
    // }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $user = auth()->user();
        dd($user->roles);
//        return new UserResources($user);
    }

    public function passwordReset(Request $request){
        $user = User::where('email',$request->email)->first();
        // return $user;
        if($user){
            $user->password_token = Hash::make($request->email.now());
            $user->save();
            Mail::to($user->email)->send(new PasswordResetMail($user));
            return response()->json(['message' => 'Password reset link sent','data'=>$user]);
        }
    }

    public function resetToken(Request $request,$token){
        $user = User::where('password_token',$token)->first();
        if($user){
            $time = Carbon::parse($user->updated_at);
            $now = Carbon::parse(now());
            $totalDuration = $now->diffInMinutes($time);
            if($totalDuration < 60){
                $user->password = Hash::make($request->password);
                $user->password_token = '';
                $user->save();
                return response()->json(['message' => 'Password reset successfully','status'=>200]);
            }else{
                return response()->json(['message' => 'Password token expired','status'=>401]);
            }
        }else{
            return response()->json(['message' => 'Invalid token','status'=>404]);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
            'role' => auth()->user()->role->name,
        ]);
    }

}
