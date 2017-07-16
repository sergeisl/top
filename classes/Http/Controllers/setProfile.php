<?php
/**
 * Created by PhpStorm.
 * User: Zver
 * Date: 16.07.2017
 * Time: 19:22
 */

namespace Http\Controllers;


class setProfile extends \AbstractController {

    public function registration($request, $response, $args) {

        $getBody = \Ohanzee\Helper\Arr::extract(
            $request->getParsedBody(),
            [
                'login',
                'password',
                'phone',
                'i_accept_the_rules'
            ], ''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sp2all.ru/api/setProfile');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $getBody);
        $data = curl_exec($ch);
        $header=substr($data,0,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        $body=substr($data,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        preg_match_all("/Set-Cookie: (.*?)=(.*?);/i",$header,$res);

        foreach ($res[1] as $key => $value) {
            setcookie('_'.$value, $res[2][$key]);
        };
        curl_close($ch);

        return $body;
    }

}