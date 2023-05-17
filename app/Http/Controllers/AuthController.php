<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Psy\Util\Json;

class AuthController extends Controller
{
    protected User $user;
    public function __construct(User $user){
        $this->user = $user;
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ]);

        $data = $request->except('password_confirmation');

        $data['password'] = Hash::make($data['password']);

        $userId = $this->user->create($data)->id;

        $user = $this->user->where('id', $userId)->first();

        return $this->createdResponse('User account successfully Created', new UserResource($user));
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $data = $request->only(['email', 'password']);

        if(!$token = Auth::attempt($data)){
            return $this->forbiddenResponse("Email & Password does not match with our record.");
        }

        $user = $this->user->where(['email' => $data['email']])->first();

        return $this->okResponse('User Logged In Successfully', ["token" => $token, "user" => new UserResource($user)]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        return $this->okResponse('User Successfully Logged out', []);
    }

    public function getLoggedInUser(Request $request): JsonResponse
    {
        $user = Auth::getUser();

        return $this->okResponse('User Retrieved Successfully', ["user" => new UserResource($user)]);
    }
}
