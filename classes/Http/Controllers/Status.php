<?php

namespace Http\Controllers;

use \Model;
use Carbon\Carbon;

class Status extends \AbstractController{

    public function get_site(){
        set_time_limit(99999999999999999);
        for ($count = 1;$count<=2;$count++) {

            $data = json_decode(file_get_contents("https://sp2all.ru/api/getSuppliers/?&page=$count&format=json"), true);

//            $fp = fopen('file.txt', 'a+');

            foreach ($data["items"] as $item) {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "{$item['site']}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $output = curl_exec($ch);
                curl_close($ch);

                if ($output) {

           /*         $subject = $output;
                    $pattern = '/src=".*?logo.*?\.(svg|jpg|png|gif).*?"/im';
                    preg_match_all($pattern, $subject, $matches);

                    echo "-------------------<br>есть:{$item['site']}   ID:{$item['id']}<br>";

                    for ($count = 0;$count<count($matches[0]);$count++) {
                        preg_match_all('/"(.*?)"/', $matches[0][$count], $logo);

                        if(!preg_match('/(http:\/\/)/', $logo[1][0], $logo_res)){
                            echo '<img src="'.$item['site'].'/'.$logo[1][0].'">';
                        } else {
                            echo '<img src="'.$logo[1][0].'">';
                        }
                        echo '<br>';
                    }*/

                } else {
                   // fwrite($fp, "ID:{$item['id']}:{$item['site']}"."\r\n");
                }
            }
          //  fclose($fp);
        }

    }

}
