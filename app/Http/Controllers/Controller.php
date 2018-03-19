<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    /**
     * @SWG\Swagger(
     *   basePath="/",
     *   @SWG\Info(
     *     title="Posts Crud",
     *     version="1.0.0",
     *     license="Maric Djordje"
     *   )
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
