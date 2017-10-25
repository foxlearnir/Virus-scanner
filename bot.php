<?php
//site:foxlearn.ir
//telegram:@ghanbari615
//email:ghanbari615@gmail.com
$update = json_decode(file_get_contents('php://input'));
$token= "TOKEN"; //توکن شما
define('API_KEY',$token);
include("fnc.php");
$message = $update->message;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$textmessage = isset($update->message->text)?$update->message->text:'';
$myphoto = $update->message->file_size;
$chat_edit_id = $update->edited_message->chat->id;
$edit = $update->edited_message;
$message_edit_id = $update->edited_message->message_id;
$cllchatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$cllmsegid = $update->callback_query->message->message_id;
$cllfor = $update->callback_query->from->id;
if ($data == "ref")
{
	$data = file_get_contents("data/$cllchatid.txt");
	if($data != "0")
	{
	$scn = scan($data,$cllchatid);
	bot('editmessagetext',[
    'chat_id'=>$cllchatid,
	'message_id'=>$cllmsegid,
    'text'=>"<code>$scn</code>", 
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"🔄"."بروزرسانی",'callback_data'=>"ref"]
	]
    ]
    ])
    ]);
	}
	else
	{
	    bot('answercallbackquery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>"✅اسکن فایل شما پایان یافته است.",
        'show_alert'=>true
       ]);
	}
}
if($textmessage == "/start")
{
if(!is_file("data/$chat_id.txt"))
{
file_put_contents("data/$chat_id.txt","0");	
}
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"سلام,
	لینک فایل مورد نظر را ارسال نمائید...", 
    'reply_to_message_id'=>$message->message_id,
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"ارتباط با ما",'url'=>"http://telegram.me/ghanbari615"]
	]
    ]
    ])
  ]);
}
else if (filter_var($textmessage, FILTER_VALIDATE_URL))
{
if(file_get_contents("data/$chat_id.txt") == "0")
{
file_put_contents("data/$chat_id.txt","$textmessage");
$scn = scan($textmessage,$chat_id);
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"<code>$scn</code>", 
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
	[
	['text'=>"🔄"."بروزرسانی",'callback_data'=>"ref"]
	]
    ]
    ])
  ]);
}
else
{
	bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"🔴شما یک فایل درحال اسکن دارید.....
	تا زمانی که اسکن فایل قبلی به اتمام نرسد نمیتوانید فایل جدیدی ارسال کنید.
	✅جهت بروزرسانی وضعیت اسکن فایل ارسالی قبلی بروی دکمه بروزرسانی کلیک کنید.", 
    'parse_mode'=>'html'
  ]);
}
}
else
{
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"◀️"."آدرس وارد شده معتبر نمیباشد.نمونه آدرس معتبر:
	http://foxlearn.ir/test.zip", 
    'reply_to_message_id'=>$message->message_id,
    'parse_mode'=>'html'
  ]);
}
?>

