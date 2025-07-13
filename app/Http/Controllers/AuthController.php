<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth management
 *
 * APIs for managing authentication
 */
class AuthController extends Controller
{
    /**
     * User Login
     *
     * Authenticate user with username and password, returns access token on success.
     *
     * @bodyParam username string required The username of the user. Example: admin
     * @bodyParam password string required The password of the user (minimum 8 characters). Example: password123
     *
     * @response 200 scenario="Successful login" {
     *   "success": "success",
     *   "message": "Login successful.",
     *   "data": {
     *     "token": "1|abcdefg123456789",
     *     "admin": {
     *       "id": "uuid-here",
     *       "name": "Administrator",
     *       "username": "admin",
     *       "phone": "081234567890",
     *       "email": "admin@example.com"
     *     }
     *   }
     * }
     *
     * @response 401 scenario="Wrong credentials" {
     *   "success": "error",
     *   "message": "Credidentals are wrong."
     * }
     *
     * @response 409 scenario="Already authenticated" {
     *   "success": "error",
     *   "message": "Already authenticated."
     * }
     */
    public function login(LoginRequest $request)
    {
        if (Auth::guard('sanctum')->check()) {
            return response(
                new ErrorResource('Already authenticated.'), 409);
        }
        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(new ErrorResource('Credidentals are wrong.'), 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $authData = [
            'token' => $token,
            'admin' => [
                'id'       => $user->id,
                'name'     => $user->name,
                'username' => $user->username,
                'phone'    => $user->phone,
                'email'    => $user->email,
            ],
        ];

        return new SuccessResource('Login successful.', new AuthResource($authData));
    }

    /**
     * User Logout
     *
     * Logout the authenticated user by revoking all tokens.
     *
     * @authenticated
     *
     * @response 200 scenario="Successful logout" {
     *   "success": "success",
     *   "message": "Logout successful."
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return new SuccessResource('Logout successful.');
    }
}
