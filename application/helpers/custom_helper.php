<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('smshorizon')) {
    function smshorizon($mobile, $msg) {
        $api_key='DK5c1dlo1iB1Giv5bol2';
        $sender_id='ECOIND';
        $type = "txt";

        $message = urlencode($msg);

        $ch = curl_init("https://smshorizon.co.in/api/sendsms.php?user=aneeshgold&apikey=".$api_key."&mobile=".$mobile."&senderid=".$sender_id."&message=".$message."&type=".$type);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);

        if (curl_errno($ch)) {
            $response['error']="access error : " . curl_error($ch);
        }else{
            $response['error'] = '';
        }
        curl_close($ch);
        return $response;
    }
}


if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
