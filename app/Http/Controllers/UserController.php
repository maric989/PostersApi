<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Class UserController
     * @package App\Http\Controllers
     *
     *  @SWG\Definition(
     *     definition="UsersIndex",
     * )
     *
     */


    /**
     * @SWG\Get(
     *   path="/api/users",
     *   summary="UsersIndex",
     *   @SWG\Parameter(
     *     name="content-type",
     *     in="header",
     *     description="application/x-www-form-urlencoded",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="token",
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
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function index()
    {
        $users = User::all();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer())
            ->toArray();

    }

    /**
     * @SWG\Get(
     *   path="/api/user",
     *   summary="LoggedUserInfo",
     *   @SWG\Parameter(
     *     name="content-type",
     *     in="header",
     *     description="application/x-www-form-urlencoded",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="token",
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
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="token",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=403, description="unauthorized")
     * )
     *
     */
}
