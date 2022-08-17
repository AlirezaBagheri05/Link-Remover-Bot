<?php

function search_strings($haystack, $needle){
    $search = strpos($haystack, $needle);
    $search = strval($search);
    $search = ($search === '0')? true : $search;
    if($search){
        return true;
    }else{
        return false;
    }
}
function callbackMessage(){
    $callback_id=$update['callback_query']['id'];
    $chat_id=$update['callback_query']['message']['chat']['id'];
    $pv_id=$update['callback_query']['from']['id'];
    $date=$update['callback_query']['data'];
    $message_id=['callback_query']['message']['message_id'];
    $text=$update['callback_query']['message']['text'];
    MessageRequestJson('answerCallbackQuery',array['callback_query_id'=>$callback_id,'text'=>$text,'show_alert'=>false]);
}




