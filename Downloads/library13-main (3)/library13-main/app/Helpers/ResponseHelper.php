<?php
 namespace App\Helpers;
    class ResponseHelper
    {
        public static function success($message , $data = [])
        {
            return [
                'message' => $message,
                'success' => true, 
                'data' => $data
            ];
        }
    
        public static function error($message ,  $data = [] )
        {
            return [
                'message' => $message,
                'success' => false,
                'data' => $data
            ];
        }
    }