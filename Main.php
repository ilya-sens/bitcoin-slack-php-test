<?php
/**
 * Created by PhpStorm.
 * User: ilya
 * Date: 21.10.17
 * Time: 09:46
 */
require_once 'config/Config.php';

class Main {
    public function __construct() {
        $maxValue = Config::$x;
        $channel = Config::$channel;
        $value = $this->getData()->USD->last;
        if ($value > $maxValue) {
            var_dump($this->postToSlack($channel, "Current value $value is bigger than $maxValue!"));
        }
    }

    private function getData() {
        $ch = curl_init("https://blockchain.info/ticker"); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

    private function postToSlack($channel, $message) {
        $ch = curl_init("https://slack.com/api/chat.postMessage");
        $data = http_build_query([
            "token" => Config::$token,
            "channel" => $channel,
            "text" => $message,
            "username" => "blockchainbot",
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

new Main();