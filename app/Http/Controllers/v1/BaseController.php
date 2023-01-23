<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($resource, $message)
    {
    	$res = [
            'success' => true,
            'message' => $message,
            'data'    => $resource,
        ];

        return response()->json($resource, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $code)
    {
    	$res = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($res, $code);
    }
}
