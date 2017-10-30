<?php
if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}

require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/function.php';

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

if($credits < 0 || $coinnum < 0){

    showmessage('转换失败, 错误码100', 'plugin.php?id=interconnection&mod=credits');

}else if($storeid < 1){

    showmessage('转换失败, 错误码101', 'plugin.php?id=interconnection&mod=credits');

}else{

    if($_GET['type']=='coin'){

        if($coinnum >= $_GET['count']){

            mysqli_query($database,"UPDATE store_players SET credits=credits+$_GET[count] WHERE authid='$steamid' and id = '$storeid'");
            
            if(mysqli_affected_rows($database) == 0){

                showmessage('转换失败, 错误码103', 'plugin.php?id=interconnection&mod=credits');

            }else{

                updatemembercount($_G['uid'], array('extcredits1'=>-$_GET[count]), '', '', '','积分转换','积分转换','转换信用点到CSGO');
                $newcredits = $_GET['count']+$credits;
                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $newcredits, $_GET[count], '论坛兑换信用点至游戏', UNIX_TIMESTAMP())");
                showmessage('已成功转换'.$_GET['count'].'信用点到CSGO', 'plugin.php?id=interconnection&mod=credits');
                
            }

        }else{

            showmessage('论坛上的信用点不够', 'plugin.php?id=interconnection&mod=credits');

        }
    }else if($_GET['type']=='credits'){

        if($credits >= $_GET['count']){

            mysqli_query($database,"UPDATE store_players SET credits=credits-$_GET[count] WHERE authid='$steamid' AND ban=0");

            if(mysqli_affected_rows($database) == 0){
                
                showmessage('转换失败, 错误码104', 'plugin.php?id=interconnection&mod=credits');
                
            }else{

                updatemembercount($_G['uid'], array('extcredits1'=>$_GET[count]), '', '', '','积分转换','积分转换','转换CSGO到信用点');
                $newcredits = $credits-$_GET['count'];
                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $newcredits, -$_GET[count], '游戏兑换信用点至论坛', UNIX_TIMESTAMP())");
                showmessage('已成功转换'.$_GET['count'].'信用点至论坛', 'plugin.php?id=interconnection&mod=credits');

            }
        }else{

            showmessage('游戏内信用点不够', 'plugin.php?id=interconnection&mod=credits');

        }
    }
}

mysqli_close($database);

?>