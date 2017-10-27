<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/function.php';

$steam64 = DB::fetch_first("SELECT * FROM " . DB::table('steam_users') . " WHERE uid = $_G[uid]")['steamID64'];

if(!$steam64){

    showmessage("请您先关联您的Steam账户", 'home.php?mod=spacecp&ac=plugin&id=sq_steam_bind:steam_settings');
    
}

$steamid = SteamID64ToSteamID32($steam64, true);

$coinnum = C::t('common_member_count')->fetch($_G['uid'])['extcredits1'];

$database = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);

if(($result = mysqli_query($database, "SELECT id, signature FROM playertrack_player WHERE steamid='$steamid'")) && ($row = mysqli_fetch_array($result))){

    $players = $row['id'];
    $oldsign = $row['signature'];
    
}

if($coinnum < 500){

    showmessage("更新签名失败, 您的信用点不足500!", 'plugin.php?id=interconnection&mod=signature');
    
}elseif($players < 1){

    showmessage("含有非法字符, 错误代码001!", 'plugin.php?id=interconnection&mod=signature');

}elseif(strcmp($oldsign, $_GET['newsignature']) == 0){

    showmessage("含有非法字符, 错误代码002!", 'plugin.php?id=interconnection&mod=signature');

}else{
    
    $replace = array('<','>','&','*','\\','^','\$','\'','"');
    $str = str_replace($replace, "", $_GET['newsignature']);
    $newsign = mysqli_real_escape_string($database, $str);

    if($newsign != -1){

        mysqli_query($database, "UPDATE playertrack_player SET signature='$newsign' WHERE steamid='$steamid'");

        if(mysqli_affected_rows($database) == 0){

            showmessage("含有非法字符, 错误代码003!", 'plugin.php?id=interconnection&mod=signature');

        }else{

            updatemembercount($_G['uid'], array('extcredits1'=>-500), '', '', '', '游戏签名设置', '游戏签名设置', '游戏签名设置');
            showmessage("更新签名成功!", 'plugin.php?id=interconnection&mod=signature');

        }
    }else{

        showmessage("含有非法字符, 错误代码004!", 'plugin.php?id=interconnection&mod=signature');
        
    }
}

?>