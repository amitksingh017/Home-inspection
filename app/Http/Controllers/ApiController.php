<?php

namespace App\Http\Controllers;

use Response;
use App\Http\Controllers\Controller;

/**
 * Class ApiController
 * @package App\Modules\Api\Lesson\Controllers
 */
class ApiController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->beforeFilter('auth', ['on' => 'post']);
    }

    /**
    * To add success response  
    * @param req :[]
    * @param res : [success]
    */
    public function successRespond($data, $message = null, $code = 200)
    {
        $message_string = 'message'.'.'.$message;
        $message = config($message_string);
        return $this->respond([
            'success' => true,
            'code' => $code,
            'message' => $message,
            'result'=> ( isset($data) && !empty($data) ) ? $data: (object) $data
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
    
    public function respond($data, $code)
    {  
        return response()->json($data,$code);
        exit;
    }
    
}
