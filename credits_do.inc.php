<?php
if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}

require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/function.php';

$coinnum = -1;
$credits = -1
$storeid = -1;
$steamid = null;

LogMessage("Init Application: " . __DIR__ . "credits_do.inc.php");

if($steam64 = DB::fetch_first("SELECT steamID64 FROM " . DB::table('steam_users') . " WHERE uid = $_G[uid]")['steamID64']){

    $steamid = SteamID64ToSteamID32($steam64, false);
    
    $database = mysqli_connect($db_host, $db_user, $db_pswd, $db_name);

    $coinnum = C::t('common_member_count')->fetch($_G['uid'])['extcredits1'];

    if($result = mysqli_query($database, "SELECT id,credits FROM store_players WHERE authid='$steamid32' LIMIT 1") && $row = mysqli_fetch_array($result)){

        $credits = $row['credits'];
        $storeid = $row['id'];

    }

    if($credits < 0 || $coinnum < 0){

        echo '转换失败, 错误码100';

    }else if($storeid < 1){

        echo '转换失败, 错误码101';

    }else{

        if($_GET['type']=='coin'){

            if($coinnum >= $_GET['count']){

                mysqli_query($database,"UPDATE store_players SET credits=credits+$_GET[count] WHERE authid='$steamid32' and id = '$storeid'");
                
                if(mysqli_affected_rows($database) == 0){

                    echo '转换失败, 错误码103';

                }else{
                    
                    updatemembercount($_G['uid'], array('extcredits1'=>-$_GET[count]), '', '', '','积分转换','积分转换','转换信用点到CSGO');
                    echo '已成功转换'.$_GET['count'].'信用点到CSGO';
                    $newcredits = $_GET['count']+$credits;
                    mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $newcredits, $_GET[count], '论坛兑换信用点至游戏', UNIX_TIMESTAMP())");

                }
 
            }else{

                echo '论坛上的信用点不够';

            }
        }else if($_GET['type']=='credits'){

            if($credits >= $_GET['count']){

                mysqli_query($database,"UPDATE store_players SET credits=credits-$_GET[count] WHERE authid='$steamid32' AND ban=0");
                
                if(mysqli_affected_rows($database) == 0){
                    
                    echo '转换失败, 错误码104';
                    
                }else{

                    updatemembercount($_G['uid'], array('extcredits1'=>$_GET[count]), '', '', '','积分转换','积分转换','转换CSGO到信用点');
                    $newcredits = $credits-$_GET['count'];
                    mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $newcredits, -$_GET[count], '游戏兑换信用点至论坛', UNIX_TIMESTAMP())");
                    echo '已成功转换'.$_GET['count'].'信用点至论坛';

                }
            }else{

                echo '游戏内信用点不够';

            }
        }
    }
    mysqli_close($database);
}
?>