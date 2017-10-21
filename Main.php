<?php
/**
 * Created by PhpStorm.
 * User: ilya
 * Date: 21.10.17
 * Time: 09:46
 */
require_once 'config/Config.php';

class Main
{
    public function __construct()
    {
        $value = Config::$x;
        $chanel = Config::$chanel;
        print($this->getData()->USD->last);
    }

    private function getData() {
        $ch = curl_init("https://blockchain.info/ticker"); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }
}

new Main();