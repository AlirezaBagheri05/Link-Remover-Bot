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
function callbackMessage($update){
    $callback_id=$update['callback_query']['id'];
    $chat_id=$update['callback_query']['message']['chat']['id'];
    $pv_id=$update['callback_query']['from']['id'];
    $data=$update['callback_query']['data'];
    $message_id=$update['callback_query']['message']['message_id'];
    $text=$update['callback_query']['message']['text'];

    $value = new lib(SERVER_NAME,USER_NAME,USER_PASSWORD,DB_NM);
    $text = ANS($data,$value);

    $parametrs = array(
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"$text",
        // 'reply_to_message_id'=>$message_id,
        'reply_markup'=>array('inline_keyboard'=>array(
            array(array('text'=>'simple button','url'=>'https://alirezazerila.ir')),
            array(array('text'=>'Get Jock','callback_data'=>'/jock'),array('text'=>'Get Poem','callback_data'=>'/poem')),
            array(array('text'=>'Get Help jock','callback_data'=>'/jock_maker'),array('text'=>'Get Help Poem','callback_data'=>'/poem_maker'))
        )),
        'parse_mode'=>'HTML'
    );

    // $parametrs = array(
    //     'callback_query_id'=>$callback_id,
    //     'text'=>"it is a simple text:/",
    //     'show_alert'=>false
    // );
    // $firstbot = new bot_telegram(API_URL1);
    // $firstbot->sendMessage('answerCallbackQuery',$parametrs);

    $firstbot = new bot_telegram(API_URL1);
    $firstbot->sendMessage('editMessageText',$parametrs);
    exit;
}

function ANS($text,$value){
    $made_jock = search_strings($text,'جک یاد بگیر');
    $made_poem = search_strings($text,'شعر یاد بگیر');
    if($text == '/jock'){
        $max = $value->count(JBOT);
        $id = rand(1,$max);
        $txt = $value->select_jock($id);
        if($txt){
            $txtv = urldecode($txt['value']);
            $text = $txt['name']."\n".'نویسنده : '.$txt['maker']."\n\n".$txtv;
        }else{
            $text = 'حافظم پاک شده. بهم یاد بده 🥲';
        }
    }else if($text == '/poem'){
        $max = $value->count(PBOT);
        $id = rand(1,$max);
        $txt = $value->select_poem($id);
        if($txt){
            $txtv = urldecode($txt['value']);
            $text = $txt['name']."\n".'نویسنده : '.$txt['maker']."\n\n".$txtv;
        }else{
            $text = 'حافظم پاک شده. بهم یاد بده 🥲';
        }
    }else if($text == '/poem_maker'){
        $text = "راهنما🐶\nفقط کافیه در اول نوشته کلمه 'شعر یاد بگیر' رو بزاری😍\n*هر خط یک جمله حساب میشود\n\nمثلا\nشعر یاد بگیر\nامیر گر شود خمیر به امیرعلی ربطی ندارع😐😐🤣\nوشعر بعدی...";
    }else if($text == '/jock_maker'){
        $text = "راهنما🐈\nفقط کافیه اول جملت کلمه 'جک یاد بگیر' رو بزاری😍\n*هر خط یک جمله حساب میشود\n\nمثلا\nجک یاد بگیر امیر خورد به امین خمیر شد😂😐\nو جک بعدی...";
    }else if($made_jock){
        $text =  str_replace('جک یاد بگیر',"",$text);
        $array_data = explode("\n",$text);
        foreach ($array_data as $text){
            $name = "jock";
            
            $text = trim($text," ");
            if(!empty($text)){
                $text = urlencode($text);
                $txt = $value->insert_jock($name,$text,$user_name);
            }
        }
        
        if($txt){
            $text = 'باموفقیت ثبت شد';
        }else{
            $text = 'متاسفانه ثبت نشد';
        }
    }else if($made_poem){
        $text =  str_replace('شعر یاد بگیر',"",$text);
        $array_data = explode("\n",$text);
        foreach ($array_data as $text){
            $name = "poem";
            $text = trim($text," ");
            if(!empty($text)){
                $text = urlencode($text);
                $txt = $value->insert_poem($name,$text,$user_name);
            }
        }
        
        if($txt){
            $text = 'باموفقیت ثبت شد';
        }else{
            $text = 'متاسفانه ثبت نشد';
        }
    }else if($text == '/start'){
        $text = "به اولین ربات من خوش اومديد😍\n\nاین ربات قادر به ارسال جک و شعر میباشد🙃❤️\nو همچنین میتونید بهش شعر و جک هم یاد بدید🤩";
    }else{
        $text ="دستور وارد شده صحیح نمیباشد";
    }

    $text .= "\n\n\n<a href=\"https://www.eawall.ir/\">It is my site:)</a>";
    return $text;
}