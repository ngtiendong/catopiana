<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    public function successResponse($data, $message = '')
    {
        return $this->apiResponse(1, $data, $message);
    }

    public function errorResponse($data, $message, $code = 0)
    {
        return $this->apiResponse($code, $data, $message);
    }

    protected function apiResponse($code, $data, $message, $error = [])
    {
        return \response()->json([
            'result'       => $code,
            'current_time' => time(),
            'message'      => $message,
            'data'         => !empty($data) ? $data : new \stdClass(),
            'error'        => !empty($error) ? $error : new \stdClass()
        ]);
    }
}
