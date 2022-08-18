<?php 
require_once('env.php');
require_once('LibTelegram.php');

$content = file_get_contents('php://input');
$update = json_decode($content , true);

if(isset($update['message']['entities'])){
    $chat_id = $update['message']['chat']['id'];
    $message_id = $update['message']['message_id'];
    foreach($update['message']['entities'] as $link){
        $verify = $link['type'];
        if($verify != 'phone_number'){
            $parametrs = array(
                'chat_id'=>$chat_id,
                'message_id'=>$message_id
            );
            $firstbot = new bot_telegram(API_URL1);
            $firstbot->Request('deleteMessage',$parametrs);
        }
    }
}


?>