<?php 
require_once('env.php');
require_once('LibTelegram.php');
require_once('lib.php');
require_once('functions.php');

$content = file_get_contents('php://input');
$update = json_decode($content , true);

if(isset($update['message'])){
    $chat_id = $update['message']['chat']['id'];
    $user_name = $update['message']['from']['first_name'];
    $message_id = $update['message']['message_id'];
    $text = $update['message']['text'];
}else if(isset($update['callback_query'])){
    callbackMessage($update);
}


$value = new lib(SERVER_NAME,USER_NAME,USER_PASSWORD,DB_NM);

$text = ANS($text,$value);

// $parametrs = array(
//     'chat_id'=>$chat_id,
//     'text'=>$text,
//     'reply_to_message_id'=>$message_id,
//     'reply_markup'=>array(resize_keyboard =>true,'keyboard'=>array(
//         array('/jock','/poem'),
//         array('/jock_maker','/poem_maker')
//     )),
//     'parse_mode'=>'HTML'
// );
$parametrs = array(
    'chat_id'=>$chat_id,
    'text'=>$text,
    // 'reply_to_message_id'=>$message_id,
    'reply_markup'=>array('inline_keyboard'=>array(
        array(array('text'=>'simple button','url'=>'https://alirezazerila.ir')),
        array(array('text'=>'Get Jock','callback_data'=>'/jock'),array('text'=>'Get Poem','callback_data'=>'/poem')),
        array(array('text'=>'Get Help jock','callback_data'=>'/jock_maker'),array('text'=>'Get Help Poem','callback_data'=>'/poem_maker'))
    )),
    'parse_mode'=>'HTML'
);
$firstbot = new bot_telegram(API_URL1);
$firstbot->sendMessage('sendMessage',$parametrs);

?>