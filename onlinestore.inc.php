<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/function.php';

if($_GET['type'] != 'dele'){
    
    showmessage("功能开发中");

}

if($_GET['itemid'] < 0){
    
    showmessage("ItemID错误");

}

$steam64 = DB::fetch_first("SELECT * FROM " . DB::table('steam_users') . " WHERE uid = $_G[uid]")['steamID64'];

if(!$steam64){

    showmessage("请您先关联您的Steam账户", 'home.php?mod=spacecp&ac=plugin&id=sq_steam_bind:steam_settings');
    
}

$steamid = SteamID64ToSteamID32($steam64, false);

$coinnum = C::t('common_member_count')->fetch($_G['uid'])['extcredits1'];

$database = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);

if(($result = mysqli_query($database, "SELECT * FROM store_players WHERE authid='$steamid'")) && ($row = mysqli_fetch_array($result))){

    $credits = $row['credits'];
    $storeid = $row['id'];

}

mysqli_query($database, "DELETE FROM store_items WHERE player_id = $storeid AND id = $_GET[itemid]");

mysqli_close($database);

showmessage("操作完成", 'plugin.php?id=interconnection&mod=onlinestore');

?>