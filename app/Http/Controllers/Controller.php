<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($message, $result = [],$code = 200)
    {
        // $res = array_walk_recursive($result,function(&$item){$item=strval($item);});
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];
        return response()->json($response, $code);
    }

    public function sendError($error, $code = 404, $errorMessages = [])
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response,$code);

    }


}
