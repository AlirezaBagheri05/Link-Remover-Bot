<?php 
require_once('env.php');
require_once('LibTelegram.php');

$content = file_get_contents('php://input');
$update = json_decode($content , true);

$chat_id = $update['message']['chat']['id'];
$message_id = $update['message']['message_id'];
$user_id = $update['message']['from']['id'];

$firstbot = new bot_telegram(API_URL1);

if(isset($update['message']['entities'])){
    $parametrs = array(
        'chat_id'=>$chat_id,
        'user_id'=>$user_id
    );
    $information = $firstbot->Request('getChatMember',$parametrs);
    $info = json_decode($information,true);
    $text = $info['result']['status'];
    // $parametrs = array(
    //     'chat_id'=>"-1001598991331",
    //     'text'=>$text
    // );
    // $information3 = $firstbot->Request('sendMessage',$parametrs);
    // exit;
    if($text != 'administrator' && $text != 'creator'){
        foreach($update['message']['entities'] as $link){
            $verify = $link['type'];
            if($verify !== 'phone_number'){
                $parametrs = array(
                    'chat_id'=>$chat_id,
                    'message_id'=>$message_id
                );
                $firstbot->Request('deleteMessage',$parametrs);
                exit;
            }
        }
    }
}

$parametrs = array(
    'chat_id'=>"-1001598991331",
    'user_id'=>$user_id
);
$information3 = $firstbot->Request('getChatMember',$parametrs);




?>