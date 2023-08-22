<?php

namespace App\Http\Controllers;

use App\Traits\Response\ApiResponseTrait;
use App\Transformers\TransformTrait;

class BaseController extends Controller
{
    use ApiResponseTrait;
    use TransformTrait;

}