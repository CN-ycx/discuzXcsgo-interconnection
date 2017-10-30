<?php

if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}

require_once(__DIR__ . "/storeitem.inc.php");

$itemnum = 0;
$alprice = 0;

if(($result = mysqli_query($database, "SELECT * FROM store_players WHERE authid='$steamid'")) && ($row = mysqli_fetch_array($result))){

    $storeid = $row['id'];
    $credits = $row['credits'];

    if($storeid > 0){

        if($coinnum < 0 && $credits > 0){
            
            mysqli_query($database, "UPDATE store_players SET credits=credits+$coinnum WHERE authid='$steamid' AND id = '$storeid'");

            if(mysqli_affected_rows($database) != 0){

                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $credits+$coinnum, $coinnum, '补全负数信用点', UNIX_TIMESTAMP())");
                updatemembercount($_G['uid'], array('extcredits1'=>-$coinnum), '', '', '', '积分补全', '积分补全', '补全负数信用点');
                showmessage("已为您更新商店数据,请刷新页面!", 'home.php?mod=spacecp&ac=plugin&id=interconnection:credits');

            }

        }elseif($coinnum > 0 && $credits < 0){

            mysqli_query($database,"UPDATE store_players SET credits=0 WHERE authid='$steamid' AND id = '$storeid'");
            
            if(mysqli_affected_rows($database) != 0){

                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, 0, -$credits, '补全负数信用点', UNIX_TIMESTAMP())");
                updatemembercount($_G['uid'], array('extcredits1'=>$credits), '', '', '', '积分补全', '积分补全', '补全负数信用点');
                showmessage("已为您更新商店数据,请刷新页面!", 'home.php?mod=spacecp&ac=plugin&id=interconnection:credits');

            }
        }

        if($result2 = mysqli_query($database, "SELECT a.id, a.type, a.unique_id, a.date_of_purchase, a.date_of_expiration, a.price_of_purchase, b.slot FROM store_items a LEFT JOIN store_equipment b ON a.unique_id = b.unique_id and a.player_id = b.player_id WHERE a.player_id=$storeid GROUP BY a.id ORDER BY a.price_of_purchase DESC")){
            
            $rows = array();
            
            $start = 0;
            while(($array = PushingPersonalItem($steam32, $start)))
            {
                $itemnum++;
                $rows[] = $array;
            }

            while($row2 = mysqli_fetch_array($result2))
            {
                $itemnum++;
                $alprice += $row2['price_of_purchase'];

                if($row2['price_of_purchase'] >= 50000){
                    
                    $row2['gift'] = true;
                    $row2['price'] = "<font color='orange'>" . number_format($row2['price_of_purchase'], 0) . "</font>";
                    
                }elseif($row2['price_of_purchase'] == 0 || $row2['price_of_purchase'] == 15){
                    
                    $row2['price'] = "<font color='red'>特殊渠道</font>";
                    
                }elseif($row2['price_of_purchase'] == 2 || $row2['price_of_purchase'] == 30 || $row2['price_of_purchase'] == 1001 || $row2['price_of_purchase'] == 650 || ($row2['price_of_purchase'] >= 504 && $row2['price_of_purchase'] <= 515)){
                    
                    $row2['price'] = "<font color='red'>活动获得</font>";
                    
                }elseif($row2['price_of_purchase'] == 233){
                    
                    $row2['price'] = "<font color='red'>开箱获得</font>";
                    
                }elseif($row2['price_of_purchase'] == 50){
                    
                    $row2['price'] = "<font color='red'>矿场兑换</font>";
                    
                }elseif($row2['price_of_purchase'] >= 10000){
                    
                    $row2['gift'] = true;
                    $row2['price'] = "<font color='#CD2990'>" . number_format($row2['price_of_purchase'], 0) . "</font>";
                    
                }else{
                    
                    $row2['gift'] = true;
                    $row2['price'] = "<font color='#9AC0CD'>" . number_format($row2['price_of_purchase'], 0) . "</font>";

                }

                $row2['expired'] = $row2['date_of_expiration'] == 0 ? "永久" : date("Y/m/d", $row2['date_of_expiration']); //Y/m/d H:i:s
                $row2['remaning'] = $row2['date_of_expiration'] == 0 ? "N/A" : date("z天G小时", $row2['date_of_expiration']-time());
                $row2['achieve'] = $row2['date_of_purchase'] == 0 ? "未知" : date("Y/m/d", $row2['date_of_purchase']);
                $row2['name'] = GetNameByUnique($row2['unique_id']);
                $row2['slot'] = GetSlotBySlot($row2['slot'], $row2['type']);
                $row2['type'] = GetTypeByType($row2['type']);
                $row2['itemid'] = $row2['id'];
                $row2['id'] = str_pad($row2['id'], 6, "0", STR_PAD_LEFT);

                $rows[] = $row2;
            }
        }else{
            $itemnum = -1;
        }
    }else{
        
        showmessage("请您先进入一次服务器", 'plugin.php?id=interconnection');

    }
}

?>