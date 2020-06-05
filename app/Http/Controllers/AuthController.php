<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use DB;
class AuthController extends Controller
{
    //
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function login(Request $request)
    {
        $email = strpos($request->email, "@") ? $request->email : (User::where('username',$request->email)->exists() ? User::where('username',$request->email)->first()->email : "");

        if(Auth::attempt(['email' => $email,'password' => $request->password]))
        {
            // $info ="";

            $user = Auth::user();
            
            $info = !empty(User::where(['email'=>$user->email])->first()) ?
            User::where(['email'=>$user->email])->first() : null ;
            
            return response()->json(['info'=>$info,'status'=>'success'],200);
        }
        else
        {
            return response()->json(['status'=>'error','message'=>'Invalid login credentials! Try again later.'],200);
        }
    }
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
           $token = $request->user()->token();
           if($token->revoke()){
            return response()->json(['status'=>'success','message' => 'Successfully logged out'],200);
           }else{
            return response()->json(['status'=>'error','message' => 'Failed to logout out, try again later!']);
           }
           
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
