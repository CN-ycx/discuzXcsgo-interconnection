<?php
if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}

require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/function.php';

$dzusers = DB::fetch_first("SELECT * FROM " . DB::table('steam_users') . " WHERE uid = $_G[uid]");

if(!$dzusers['steamID64']){

    showmessage("请您先关联您的Steam账户", 'home.php?mod=spacecp&ac=plugin&id=sq_steam_bind:steam_settings');
    
}

$allowtime = $dzusers['lastupdate']+60;

if($allowtime > time()){
    
    showmessage("请等待1分钟后再尝试刷新");
    
}

$database = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);

if(UpdateSteamProfiles($database, $api_key, $dzusers['steamID64'], $_G['uid'])){

    showmessage("已更新您的Steam账户数据", 'plugin.php?id=interconnection');

}else{
    
    showmessage("系统繁忙");

}

mysqli_close($database);

?>