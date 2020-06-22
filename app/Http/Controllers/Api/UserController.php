<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use \Illuminate\Support\Facades\Hash;


/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     *
     */
    public function auth(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);


        if (User::where('email', $request->get('email'))->exists()) {
            $user = User::where('email', $request->get('email'))->first();
            $auth = Hash::check($request->get('password'), $user->password);
            if ($user && $auth) {
                $user->rollApiKey();

                return new UserResource($user);
            }
        }

        return response(array(
            'errors'  => ['email' => ['Wrong data!']],
            'message' => 'Unauthorized, check your credentials.',
        ), 401);
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function register(Request $request): UserResource
    {
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->rollApiKey();

        return new UserResource($user);
    }

    /**
     *
     */
    public function checkAuth()
    {
        return response(['message' => 'success']);
    }
}
