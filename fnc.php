<?php
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
 function sendmessage($chat_id, $text, $model){
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$text,
 'parse_mode'=>$mode
 ]);
 }
 function sendphoto($chat_id, $photo, $captionl){
 bot('sendphoto',[
 'chat_id'=>$chat_id,
 'photo'=>$photo,
 'caption'=>$caption,
 ]);
 }
 function sendsticker($chat_id, $photo, $captionl){
 bot('sendsticker',[
 'chat_id'=>$chat_id,
 'sticker'=>$photo,
 'caption'=>$caption,
 ]);
 }
 function sendaudio($chat_id, $audio, $caption){
 bot('sendaudio',[
 'chat_id'=>$chat_id,
 'audio'=>$audio,
 'caption'=>$caption,
 ]);
 }
 function sendvoice($chat_id, $voice, $caption){
 bot('sendvoice',[
 'chat_id'=>$chat_id,
 'voice'=>$voice,
 'caption'=>$caption,
 ]);
 }

 function sendaction($chat_id, $action){
 bot('sendchataction',[
 'chat_id'=>$chat_id,
 'action'=>$action
 ]);
 }
    function get_data($url,$request=null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
        curl_setopt($curl, CURLOPT_NOBODY, false);
        //curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if(!empty($request)){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($request));
        }
        $data = curl_exec($curl);
        return $data;
    }
    function scan($url,$chat_id)
    {
    $url = urlencode($url);
    $jsn=get_data("https://www.virustotal.com/ui/urls?url=$url",array("url"=>"null"));
    $jsn=json_decode($jsn);
    $id=$jsn->data->id;
    $id=explode("-",$id);
    $id=$id[1];
    $urlscan = "https://www.virustotal.com/ui/search?query=$url&relationships[url]=network_location%2Clast_serving_ip_address&relationships[comment]=author%2Citem";
    $jsn=json_decode(get_data($urlscan),true);
    $str="";
    if(isset($jsn['data'][0]['attributes']['last_analysis_results']['ESET']))
    {
	file_put_contents("data/$chat_id.txt","0");
	$str="☑️نتیجه اسکن:\n";
    $jsn=$jsn['data'][0]['attributes']['last_analysis_results'];
    foreach($jsn As $key=>$value)
    {
        $str .= "🔶$key--->".$value['result']."\n";
    }
    }
    else
    {
        $timenow = "Last Update:".time();
        $str = "درحال اسکن..........\nشناسه فایل:\n$id\n$timenow";
    }
    return $str;
    }
?>

