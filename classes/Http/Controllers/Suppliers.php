<?php
/**
 * Created by PhpStorm.
 * User: Zver
 * Date: 14.07.2017
 * Time: 17:00
 */

namespace Http\Controllers;
use Utilities\BB as BB;

class Suppliers extends \AbstractController {

     private function get_data($page){
        $data_get = file_get_contents("https://sp2all.ru/api/getSuppliers/?&page=$page&format=json");
        //$data_get = preg_replace('#^' . chr(0xEF) . chr(0xBB) . chr(0xBF) . '#', '', $data_get);
        return json_decode($data_get,true);
    }

    public function get_reviews($request, $response, $args){

        $getBody = \Ohanzee\Helper\Arr::extract(
            $request->getParsedBody(),
            [
                'id',
                '_cookie'
            ], ''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sp2all.ru/api/Karma/?id=".$getBody['id']."&type=user_supplier&act=get&format=json&uid=241079");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID='.$getBody['_cookie']);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function get_Suppliers($request, $response, $args) {
        $page = $request->getAttribute('page');
        $page = (empty($page)?1:$page);
        $data = $this->get_data($page);
        $desc = array();
        foreach ($data["items"] as $item){
            $desc[$item["id"]] = BB::bb2html($item["desc"]);
        }

        $array = [
            "page" => $page,
            "data" => $data,
            "desc" => $desc
        ];
        return $this->view->render($response, 'main/index.html',$array);
    }
}