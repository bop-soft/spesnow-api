<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\v1\BaseController;
use App\Http\Requests\v1\UserLoginRequest;
use App\Models\User;
use App\Http\Requests\v1\UserRegisterRequest;
use App\Http\Resources\v1\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    
    public function index() {
        $admin = auth()->user()->tokenCan('admin');

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = UserResource::collection(User::all());

        return $this->sendResponse($resource, 'All users have been fetched');
    }

    public function authCheck() {
        if (auth()->check()) {
            $resource = true;

        return $this->sendResponse($resource, 'User is logged in');
        }

        return $this->sendError('User is not logged in', 401);

    }

    public function show(User $user) {
        $admin = auth()->user()->tokenCan('admin');

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $resource = new UserResource($user);

        return $this->sendResponse($resource, 'User has been fetched');
    }

    public function destroy(User $user) {
        $admin = auth()->user()->tokenCan('admin');

        $resource = null;

        if (!$admin) {
            return $this->sendError('Unauthorized user', 401);
        }

        $user->delete();
        
        return $this->sendResponse($resource, 'User has been deleted');
    }
    
    public function register(UserRegisterRequest $request) {
        $fields = $request->validated();
        
        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken('tenant-token',['tenant'])->plainTextToken;

        $resource = [
            'name' => $user->name,
            'email' => $user->email,
            'tel' => $user->telephone,
            'token' => $token
        ];

        return $this->sendResponse($resource, 'User has been registered');
    }

    public function login(UserLoginRequest $request) {
        
        $fields = $request->validated();

        if(Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']])){ 

            $user = Auth::user(); 

            $role = $user->role_id;

            switch($role) {
                case 1:
                    $token = $user->createToken('admin-token',['admin','landlord','tenant'])->plainTextToken;
                    break;
                case 2:
                    $token = $user->createToken('landlord-token',['landlord','tenant'])->plainTextToken;
                    break;
                default:
                    $token = $user->createToken('tenant-token',['tenant'])->plainTextToken;
            }

            $resource = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tel' => $user->telephone,
                'token' => $token
            ];
    
            return $this->sendResponse($resource, 'Logged in');
        } 
      
            return $this->sendError('Wrong credentials', 401);
    }

    public function logout() {

        auth()->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();

        $resource = null;

        return $this->sendResponse($resource, 'Logged out');
    }
}
