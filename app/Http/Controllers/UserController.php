<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Writer;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Validator;
 use JWTAuth;
 use Tymon\JWTAuth\Exceptions\JWTException;
 use Tymon\JWTAuth\Exceptions\TokenInvalidException;
 use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
        }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
            return response()->json(compact('token'));
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'editorial' => 'required|string',
        'short_bio' => 'required|string'
        ]);
        if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
        }
        $writer = Writer::create([
            'editorial' => $request->get('editorial'),
            'short_bio'=> $request->get('short_bio'),
        ]);
        $writer-> user()->create([
        'name' => $request->get('name'),
        'email' => $request->get('email'),
        'password' => Hash::make($request->get('password')),
        ]);
        $user = $writer->user;

        $token = JWTAuth::fromUser($writer->user);
        
        //$user_resource = new UserResource($user);
        //$user_resource->token($token);

       return response()->json(new UserResource($user, $token), 200); //forma 2 usando un constructor, mas directo
        //eturn response()->json($user_resource,201);
    }
    public function getAuthenticatedUser()
    {
        try {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(new UserResource($user), 200); 
        //response()->json(compact('user'));
    }

}
