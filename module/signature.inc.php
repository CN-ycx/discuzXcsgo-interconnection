<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

if(($result = mysqli_query($database,"SELECT id,signature FROM playertrack_player WHERE steamid='$steam32' order by id asc LIMIT 1")) && ($row = mysqli_fetch_array($result))){

    $players = $row['id'];
    $oldsign = $row['signature'];

}

if($players < 1){
    
    showmessage("请您先进入一次服务器", 'plugin.php?id=interconnection');

}

?>