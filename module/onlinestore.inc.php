<?php

if(!defined('IN_DISCUZ')){
    exit('Access Denied');
}

$itemnum = 0;
$alprice = 0;
$item_parent = array();
$item_childs = array();
$itemInventory = array();
$itemEquipment = array();

// Load store info
$result = null;
$row = array();
if(($result = mysqli_query($database, "SELECT * FROM store_players WHERE authid='$steamid'")) && ($row = mysqli_fetch_array($result))){

    $storeid = $row['id'];
    $credits = $row['credits'];

    if($storeid > 0){

        // check credits
        if($coinnum < 0 && $credits > 0){
            
            mysqli_query($database, "UPDATE store_players SET credits=credits+$coinnum WHERE authid='$steamid' AND id = '$storeid'");

            if(mysqli_affected_rows($database) != 0){

                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, $credits+$coinnum, $coinnum, '补全负数信用点', UNIX_TIMESTAMP())");
                updatemembercount($_G['uid'], array('extcredits1'=>-$coinnum), '', '', '', '积分补全', '积分补全', '补全负数信用点');
                showmessage("已为您更新商店数据,请刷新页面!", 'plugin.php?id=interconnection&mod=onlinestore');

            }

        }elseif($coinnum > 0 && $credits < 0){

            mysqli_query($database,"UPDATE store_players SET credits=0 WHERE authid='$steamid' AND id = '$storeid'");
            
            if(mysqli_affected_rows($database) != 0){

                mysqli_query($database,"INSERT INTO store_newlogs VALUES (DEFAULT, $storeid, 0, -$credits, '补全负数信用点', UNIX_TIMESTAMP())");
                updatemembercount($_G['uid'], array('extcredits1'=>$credits), '', '', '', '积分补全', '积分补全', '补全负数信用点');
                showmessage("已为您更新商店数据,请刷新页面!", 'plugin.php?id=interconnection&mod=onlinestore');

            }
        }
        
        unset($result);
        unset($row);
        // Load Equipment
        if($result = mysqli_query($database, "SELECT * FROM  store_equipment WHERE player_id=$storeid")){

            while($row = mysqli_fetch_array($result))
            {
                $itemEquipment[] = $row;
            }
        }

        unset($result);
        unset($row);
        // Load Store catelogies
        if($result = mysqli_query($database, "SELECT * FROM store_item_parent ORDER BY id ASC")){
            
            while($row = mysqli_fetch_array($result))
            {
                if($row['type'] == 'playerskin' && $row['slot'] == 2){
                    
                    continue;
                    
                }

                $item_parent[] = $row;
            }
        }
       
        unset($result);
        unset($row);
        // Load Store items
        if($result = mysqli_query($database, "SELECT * FROM store_item_child ORDER BY parent ASC")){
            
            while($row = mysqli_fetch_array($result))
            {
                $row['pname'] = "未知分类";

                foreach($item_parent as $k_1 => $v_1)
                {
                    if($v_1['id'] == $row['parent']){
                        
                        if($v_1['id'] == 0){
                            $row['pname'] = $v_1['name']."皮肤";
                        }elseif($v_1['parent'] == 16){ // models
                            $row['pname'] = "武器皮肤->".$row['pname'];
                        }elseif($v_1['parent'] == 17){ // overwatch
                            $row['pname'] = "音效->".$row['pname'];
                        }else{
                            $row['pname'] = $v_1['name'];
                        }
                    }
                }
  
                if(stripos($row['auth'], $steam32) !== FALSE){
                    
                    $itemnum++;
                    $temp = array();
                    $temp['unique_id'] = $row['uid'];
                    $temp['price_of_purchase'] = 0;
                    $temp['price'] = "<font color='Magenta'>有价无市</font>";
                    $temp['remaning'] = "无限制";
                    $temp['expired'] = "永久";
                    $temp['achieve'] = "未知";
                    $temp['id'] = "专属物品";
                    $temp['itemid'] = 0;
                    $temp['gift'] = false;
                    $temp['desc'] = $row['desc'];
                    $temp['name'] = $row['name'];
                    $temp['parent'] = $row['pname'];
                    $temp['slot'] = "未装备";

                    foreach($itemEquipment as $eq => $dt)
                    {
                        if($dt['unique_id'] == $row['uid']){
                            
                            if(stripos($row['uid'], "skin_") == 0){
                                
                                switch($dt['slot'])
                                {
                                    case 1: $temp['slot'] = "CT/通用"; break;
                                    case 0: $temp['slot'] = "TE/通用"; break;
                                }
                            }elseif(stripos($row['uid'], "hat") == 0){
                                $temp['slot'] = "帽子";
                            }elseif(stripos($row['uid'], "facemask") == 0){
                                $temp['slot'] = "面具";
                            }elseif(stripos($row['uid'], "wing") == 0){
                                $temp['slot'] = "翅膀";
                            }elseif(stripos($row['uid'], "glass") == 0){
                                $temp['slot'] = "眼睛";
                            }else{
                                $temp['slot'] = "默认";
                            }
                        }
                    }
                    
                    $itemInventory[] = $temp;
                    unset($temp);
                }
                
                $item_childs[] = $row;
            }
        }
         
        unset($result);
        unset($row);
        // Load Inventory
        if($result = mysqli_query($database, "SELECT * FROM store_items WHERE player_id = $storeid ORDER BY price_of_purchase DESC")){
            
            while($row = mysqli_fetch_array($result))
            {
                $itemnum++;
                $alprice += $row['price_of_purchase'];

                $row['gift'] = false;
                $row['itemid'] = $row['id'];
                $row['id'] = str_pad($row['id'], 6, "0", STR_PAD_LEFT);

                if($row['price_of_purchase'] >= 50000){
                    
                    $row['gift'] = true;
                    $row['price'] = "<font color='orange'>" . number_format($row['price_of_purchase'], 0) . "</font>";
                    
                }elseif($row['price_of_purchase'] == 0 || $row['price_of_purchase'] == 15){
                    
                    $row['price'] = "<font color='red'>特殊渠道</font>";
                    
                }elseif($row['price_of_purchase'] == 2 || $row['price_of_purchase'] == 30 || $row['price_of_purchase'] == 1001 || $row['price_of_purchase'] == 650 || ($row['price_of_purchase'] >= 504 && $row['price_of_purchase'] <= 515)){
                    
                    $row['price'] = "<font color='red'>活动获得</font>";
                    
                }elseif($row['price_of_purchase'] == 233){
                    
                    $row['price'] = "<font color='red'>开箱获得</font>";
                    
                }elseif($row['price_of_purchase'] == 50){
                    
                    $row['price'] = "<font color='red'>矿场兑换</font>";
                    
                }elseif($row['price_of_purchase'] >= 10000){
                    
                    $row['gift'] = true;
                    $row['price'] = "<font color='#CD2990'>" . number_format($row['price_of_purchase'], 0) . "</font>";
                    
                }else{
                    
                    $row['gift'] = true;
                    $row['price'] = "<font color='#9AC0CD'>" . number_format($row['price_of_purchase'], 0) . "</font>";

                }
               
                $row['slot'] = "未装备";
                
                foreach($itemEquipment as $eq => $dt)
                {
                    if($dt['unique_id'] == $row['uid']){
                        
                        if(stripos($row['uid'], "skin_") == 0){
                            
                            switch($dt['slot'])
                            {
                                case 2: $row['slot'] = "通用"; break;
                                case 1: $row['slot'] = "CT"; break;
                                case 0: $row['slot'] = "TE"; break;
                            }
                        }elseif(stripos($row['uid'], "hat") == 0){
                            $row['slot'] = "帽子";
                        }elseif(stripos($row['uid'], "facemask") == 0){
                            $row['slot'] = "面具";
                        }elseif(stripos($row['uid'], "wing") == 0){
                            $row['slot'] = "翅膀";
                        }elseif(stripos($row['uid'], "glass") == 0){
                            $row['slot'] = "眼睛";
                        }else{
                            $row['slot'] = "默认";
                        }
                    }
                }
               
                $row['expired'] = $row['date_of_expiration'] == 0 ? "永久" : date("Y/m/d", $row['date_of_expiration']); //Y/m/d H:i:s
                $row['remaning'] = $row['date_of_expiration'] == 0 ? "N/A" : date("z天G小时", $row['date_of_expiration']-time());
                $row['achieve'] = $row['date_of_purchase'] == 0 ? "未知" : date("Y/m/d", $row['date_of_purchase']);
                
                foreach($item_childs as $k => $v)
                {
                    if($v['uid'] == $row['unique_id']){
                        
                        $row['name'] = $v['name'];
                        $row['parent'] = $v['pname'];
                        $row['desc'] = $v['desc'];

                    }
                }

                $itemInventory[] = $row;
            }
        }
    }else{
        
        showmessage("请您先进入一次服务器", 'plugin.php?id=interconnection');

    }
}

$Data_Client = array();
//首先是特殊物品
foreach($itemInventory as $item => $data)
{
    if($data['price_of_purchase'] == 0 || $data['price_of_purchase'] == 15){
        
        $Data_Client[] = $data;
        unset($itemInventory[$item]);
        
    }
}
//其次是活动物品
foreach($itemInventory as $item => $data)
{
    if($data['price_of_purchase'] == 2 || $data['price_of_purchase'] == 30 || $data['price_of_purchase'] == 1001 || $data['price_of_purchase'] == 650 || ($data['price_of_purchase'] >= 504 && $data['price_of_purchase'] <= 515)){
        
        $Data_Client[] = $data;
        unset($itemInventory[$item]);
        
    }
}
//然后是矿场物品
foreach($itemInventory as $item => $data)
{
    if($row['price_of_purchase'] == 50){
        
        $Data_Client[] = $data;
        unset($itemInventory[$item]);
        
    }
}
//接着是开箱物品
foreach($itemInventory as $item => $data)
{
    if($row['price_of_purchase'] == 233){
        
        $Data_Client[] = $data;
        unset($itemInventory[$item]);
        
    }
}
//最后是其它物品
foreach($itemInventory as $item => $data)
{
    $Data_Client[] = $data;
    unset($itemInventory[$item]);
}
?>