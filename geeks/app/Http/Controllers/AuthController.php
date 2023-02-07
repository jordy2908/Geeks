<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'GetUsers']]);
    }

    /**
     * Create a new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function CreateUser(){
        $user = new User(request() -> all());
        $user -> password = bcrypt($user -> password);
        $user -> save();
        return response() -> json(["data" => $user], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['mobile_phone', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetUsers() {

        return User::all();
    }

    /**
     * Get a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetUser(Request $req) {
        $user = User::find($req -> id);

        return response() -> json($user);
    }

    /**
     * Update user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function UpdateUser(Request $re) {
        $user = User::find($re -> id);
        $user -> first_name = $re -> first_name;
        $user -> last_name = $re -> last_name;
        $user -> date_birth = $re -> date_birth;
        $user -> address = $re -> address;
        $user -> mobile_phone = $re -> mobile_phone;
        $user -> email = $re -> email;
        
        $result = $user -> save();

        if ($result){
            return response() -> json(['message' => 'Update Successfully']);
        }
    }

    /**
     * Delete user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function DeleteUser($id) {
        $user = User::find($id);
        $result = $user -> delete();
        if ($result) {
            return response() -> json(['message' => 'User delete']);
        } else {
        return response() -> json(['message' => 'User delete']);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}