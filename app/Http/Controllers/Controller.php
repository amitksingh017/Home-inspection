<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * To add success response
    */
    public function successRespond($data, $response, $code = 200)
    {
    
        return $this->respond([
            'success' => true,
            'code' => $code,
            'message' => $response,
            'result'=> (isset($data) && !empty($data)) ? $data: (object) $data
        ], $code);
    }

    /**
    * To add error response  
    * @param req :[]
    * @param res : [error]
    */
    public function errorRespond($message = null,  $code = 400)
    {
        
        if ( is_object($message) ) {
            $data =  json_decode(json_encode($message), true);
            $message = '';
            foreach ($data as $key => $val) {
                $message .= $val[0];
            }
        } else {
            $message_string = 'message'.'.'.$message;
            $message_temp = $message;
            $message = config($message_string);
            if (empty($message) || $message == null) {
                $message = $message_temp;
            }
        }
        return $this->respond([
            'success' => false,
            'code' => $code,
            'message' => $message
        ], $code );
    }

    public function sendResetLinkFailedResponse($data, $response = null,  $code = 400)
    {
        
        if ( is_object($response) ) {
            $data =  json_decode(json_encode($response), true);
            $message = '';
            foreach ($data as $key => $val) {
                $message .= $val[0];
            }
        } else {
            $message_string = 'message'.'.'.$response;
            $message_temp = $response;
            $message = config($message_string);
            if (empty($message) || $message == null) {
                $message = $message_temp;
            }
        }
        return $this->respond([
            'success' => false,
            'code' => $code,
            'message' => $message
        ], $code );
    }

    public function respond($data, $code)
    {  
        return response()->json($data,$code);
        exit;
    }
}
