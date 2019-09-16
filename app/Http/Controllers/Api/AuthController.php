<?php

namespace App\Http\Controllers\Api;

use App\Data\Entities\User;
use App\Data\Transformer\UserTransformer;
use App\Http\Traits\WithResponse;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Illuminate\Http\Response;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController
{
    use WithResponse;

    protected const USERNAME_FIELD = 'email';
    protected const PASSWORLD_FIELD = 'password';

    /**
     * @param Request $request
     * @return HttpResponse
     */
    public function login(Request $request): HttpResponse
    {
        $credentials = $request->only(static::USERNAME_FIELD, static::PASSWORLD_FIELD);
        $validator = Validator::make($credentials, [
            static::USERNAME_FIELD => 'required|email',
            static::PASSWORLD_FIELD => 'required',
        ]);

        if ($validator->fails()) {
            return $this->respondWithError(401, 'Invalid Credentials', 'The user credentials were incorrect.');
        }

        if (!$token = auth()->attempt($credentials)) {
            return $this->respondWithError(401, 'Invalid Credentials', 'The user credentials were incorrect.');
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return HttpResponse
     */
    public function logout(): HttpResponse
    {
        auth()->logout();

        return new JsonResponse(['message' => 'Successfully logged out']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPasswordReset(Request $request)
    {
        $credentials = $request->only(static::USERNAME_FIELD);
        $validator = Validator::make($credentials, [
            static::USERNAME_FIELD => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->respondWithError(422, 'Validation Error', $validator->errors());
        }

        Password::broker()->sendResetLink($credentials);

        return new JsonResponse(['success' => true], 200);
    }

    /**
     * @return HttpResponse
     */
    public function refresh(): HttpResponse
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
    protected function respondWithToken($token): HttpResponse
    {
        return new JsonResponse([
            'meta' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    /**
     * @return HttpResponse
     */
    public function authenticated(): HttpResponse
    {
        return new JsonResponse([
            'status' => true,
            'timestamp' => Date::now()
        ]);
    }

    /**
     * @return HttpResponse
     */
    public function ping(): HttpResponse
    {
        return new JsonResponse('pong');
    }
}
