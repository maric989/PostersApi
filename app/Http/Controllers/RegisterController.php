<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\User;
use App\Transformers\UserTransformer;

class RegisterController extends Controller
{

    /**
     * Class RegisterController
     * @package App\Http\Controllers
     *
     *  @SWG\Definition(
     *     definition="RegisterUser",
     *     required={"username","password","email"},
     *     @SWG\Property(property="username", type="string"),
     *     @SWG\Property(property="email", type="email"),
     *     @SWG\Property(property="password", type="password")
     * )
     *
     */


    /**
     * @SWG\Post(
     *   path="/api/register",
     *   summary="RegisterUser",
     *   @SWG\Parameter(
     *     name="content-type",
     *     in="header",
     *     description="application/x-www-form-urlencoded",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="Accept",
     *     in="header",
     *     description="application/json",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     description="Username of user",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(type="string")
     *   ),
     *  @SWG\Parameter(
     *     name="email",
     *     in="body",
     *     description="Email of user ",
     *     required=true,
     *     @SWG\Schema(type="email")
     *   ),
     *  @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     description="Password",
     *     required=true,
     *     @SWG\Schema(type="password")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     *
     */
    public function register(StoreUserRequest $request)

    {
        $user = new User;

        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email    = $request->email;

        $user->save();

        return fractal()
              ->item($user)
              ->transformWith(new UserTransformer)
              ->toArray();
    }


    /**
     * @SWG\Post(
     *   path="/oauth/token",
     *   summary="GetToken",
     *   @SWG\Parameter(
     *     name="content-type",
     *     in="header",
     *     description="application/x-www-form-urlencoded",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="Accept",
     *     in="header",
     *     description="application/json",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="username",
     *     in="body",
     *     description="Email of user",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(type="email")
     *   ),
     *  @SWG\Parameter(
     *     name="password",
     *     in="body",
     *     description="Password",
     *     required=true,
     *     @SWG\Schema(type="password")
     *   ),
     *  @SWG\Parameter(
     *     name="client_id",
     *     in="body",
     *     description="client_id from OAuth Clients",
     *     required=true,
     *     @SWG\Schema(type="integer")
     *   ),
     *  @SWG\Parameter(
     *     name="client_secret",
     *     in="body",
     *     description="client_secret from OAuth Clients",
     *     required=true,
     *     @SWG\Schema(type="integer")
     *   ),
     *  @SWG\Parameter(
     *     name="grant_type",
     *     in="body",
     *     description="grant_type == password",
     *     required=true,
     *     @SWG\Schema(type="password")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     * )
     *
     */
}
