<?php

namespace Http\Controllers;

class Auth extends \AbstractController {

    public function login($request, $response, $args) {

        $getBody = \Ohanzee\Helper\Arr::extract(
            $request->getParsedBody(),
            [
                'login',
                'password'
            ], ''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sp2all.ru/api/login');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $getBody);
        $data = curl_exec($ch);
        $header=substr($data,0,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        $body=substr($data,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        preg_match_all("/Set-Cookie: (.*?)=(.*?);/i",$header,$res);

        foreach ($res[1] as $key => $value) {
            setcookie('_'.$value, $res[2][$key]);
            $_SESSION[cookis][$value] = $res[2][$key];
        };

        curl_close($ch);

        return $body;
    }
}





