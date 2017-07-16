<?php

namespace Http\Controllers;

class Auth extends \AbstractController{

    public function login() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sp2all.ru/api/login?login=wertu&password=12345678');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $data = curl_exec($ch);
        $header=substr($data,0,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        $body=substr($data,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        preg_match_all("/Set-Cookie: (.*?)=(.*?);/i",$header,$res);

        foreach ($res[1] as $key => $value) {
            setcookie('_'.$value, $res[2][$key]);
        };
        curl_close($ch);

        return true;
    }

    public function vk(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://oauth.vk.com/authorize?client_id=5145107&scope=photos,email&redirect_uri=https://sp2all.ru/profile/vk/&response_type=code&display=popup');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $data = curl_exec($ch);
        $header=substr($data,0,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        $body=substr($data,curl_getinfo($ch,CURLINFO_HEADER_SIZE));
        preg_match_all("/Set-Cookie: (.*?)=(.*?);/i",$header,$res);

        foreach ($res[1] as $key => $value) {
            setcookie('_'.$value, $res[2][$key]);
        };
        curl_close($ch);

        return true;

    }
    //https://sp2all.ru/api/setProfile/?login=wertu&confirm_phone=delay&phone=%2B7(914)432-11-23&password=12345678&i_accept_the_rules=true&format=txt
}
