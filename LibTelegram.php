<?php

class bot_telegram {
    private $API_BOT;
    
    public function __construct($BOT){
        $this->API_BOT = $BOT;
    }

    private function init($API_BOT){
        return curl_init($API_BOT);
    }
    private function exec($handle){
        return curl_exec($handle);
    }


    public function sendMessage($method,$parametrs){
        if(!$parametrs){
            $parametrs = array();
        }
        $parametrs['method'] = $method;
        $handle = $this->init($this->API_BOT);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parametrs));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = $this->exec($handle);
        return $result;
    }


}