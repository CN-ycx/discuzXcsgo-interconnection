<?php

function GetSlotBySlot($slot, $type)
{
    if($type == 'playerskin'){
        
        switch($slot)
        {
            case 0: $slot = "TE";break;
            case 1: $slot = "CT";break;
            case 2: $slot = "通用";break;
        }
    }elseif($type == 'hat'){
        
        switch($slot)
        {
            case  1: $slot = "头饰";break;
            case  2: $slot = "面具";break;
            case  3: $slot = "翅膀";break;
            default: $slot = "默认";break;
        }
    }else{
        
        if($slot === NULL){
            
            $slot = "未装载";
            
        }else{
            
            $slot = "默认";
            
        }
    }
    
    return $slot;
}

function PushingPersonalItem($steamid, &$start)
{
    if(strcmp($steamid, "STEAM_1:1:44083262") == 0){

        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/vocaloid/hatsune_miku/cybertech/miku_v2.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "CT";
            
            $start = 1;

            return $array;

        }elseif($start < 2){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/vocaloid/hatsune_miku/nightmare/miku.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "TE";
            
            $start = 2;

            return $array;
            
        }elseif($start < 3){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{Magenta}Princess{green}] ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 3;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:166655872") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/neptunia/blanc/nextform/nextwhite_glow.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }elseif($start < 2){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/vocaloid/hatsune_miku/nightmare/miku.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 2;

            return $array;
            
        }elseif($start < 3){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("{green}[{lightblue}萌新出厂{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 3;

            return $array;
            
        }
    }elseif(strcmp($steamid, "STEAM_1:0:85922133") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/sword_art_online/kirito/sao/kirito.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }elseif($start < 2){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{orange}歼星舰{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 2;

            return $array;
            
        }
    }elseif(strcmp($steamid, "STEAM_1:1:2359822") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/sword_art_online/kirito/sao/kirito.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:1:69539801") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/utau/meiji/one_dress/meiji.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:1:82430760") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/vocaloid/luka/baka/luka.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:181409964") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{pink}Nokyo{green}] ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:103918523") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{yellow}马王{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:211984941") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{lightred}王子{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:98534074") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{green}蠢蛇{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:1:161803745") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{yellow}烂水果{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:1:105159493") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{darkred}フラン{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }elseif($start < 2){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "人物皮肤";
            $array['name'] = GetNameByUnique("models/player/custom_player/maoling/vocaloid/hatsune_miku/nightmare/miku.mdl");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 2;

            return $array;

        }
    }elseif(strcmp($steamid, "STEAM_1:0:104388155") == 0){
        
        if($start < 1){
            
            $array = array();
            
            $array['price'] = "<font color='Magenta'>有价无市</font>";
            $array['remaning'] = "N/A";
            $array['expired'] = "永久";
            $array['achieve'] = "未知";
            $array['type'] = "名字标签";
            $array['name'] = GetNameByUnique("{green}[{silver}玄学{green}]{teamcolor} ");
            $array['id'] = "专属物品";
            $array['slot'] = "未知";
            
            $start = 1;

            return $array;

        }
    }

    return "";
}

function GetTypeByType($type)
{
    switch($type)
    {
        case 'Aura':
            $type = '光环';
            break;
        case 'grenadetrail':
            $type = '手雷轨迹';
            break;
        case 'grenadeskin':
            $type = '手雷模型';
            break;
        case 'hat':
            $type = '装饰品';
            break;
        case 'msgcolor':
            $type = '消息颜色';
            break;
        case 'namecolor':
            $type = '名字颜色';
            break;
        case 'nametag':
            $type = '名字标签';
            break;
        case 'neon':
            $type = '霓虹';
            break;
        case 'Particles':
            $type = '粒子足迹';
            break;
        case 'playerskin':
            $type = '人物皮肤';
            break;
        case 'sound':
            $type = '音效';
            break;
        case 'spray':
            $type = '喷漆';
            break;
        case 'trail':
            $type = '普通足迹';
            break;
        case 'vwmodel':
            $type = '武器模型';
            break;
    }
    return $type;
}

function GetNameByUnique($unique_id)
{
    switch($unique_id)
    {
        case 'grenadetrail_laserbeam_zise': $unique_id = '紫色';break;
        case 'Trail9': $unique_id = '9号足迹';break;
        case 'models/maoling/wings/kiana/kiana_wings.mdl': $unique_id = '月光翅膀';break;
        case 'models/player/custom_player/maoling/neptunia/noire/nextform/nextblack_nothruster.mdl': $unique_id = 'NextBlack';break;
        case 'models/player/custom_player/maoling/idolm@ster/kanzaki_ranko/kanzaki.mdl':$unique_id = '神崎兰子';break;
        case 'models/player/custom_player/maoling/vocaloid/ia/ia.mdl': $unique_id = 'IA.Orignal(TDA)';break;
        case 'models/player/custom_player/maoling/starcraft2/terran/raynor/raynor.mdl': $unique_id = 'Jim.Raynor雷日天';break;
        case 'models/player/custom_player/maoling/idolm@ster/ninomiya_asuka/ninomiya.mdl': $unique_id = '二宮飛鳥';break;
        case 'models/player/custom_player/maoling/neptunia/adult_neptune/normal/neptune.mdl': $unique_id = '大個子妮普褆努';break;
        case 'models/player/custom_player/maoling/neptunia/hatsumi_sega/normal/sega_girl.mdl': $unique_id = '世嘉少女';break;
        case 'models/player/custom_player/maoling/misc/peter/peter_v2.mdl';    $unique_id = 'Peter';break;
        case 'models/player/custom_player/maoling/neptunia/noire/normal/noire.mdl': $unique_id = '诺瓦露';break;
        case 'models/player/custom_player/maoling/date_a_live/yoshino/spirit/yoshino.mdl': $unique_id = '四糸乃';break;
        case 'models/player/custom_player/maoling/vocaloid/hatsune_miku/tda/miku.mdl': $unique_id = '初音ミク.TDA';break;
        case 'models/player/custom_player/maoling/vocaloid/hatsune_miku/magnet/miku.mdl': $unique_id = '初音ミク.和服';break;
        case 'models/player/custom_player/maoling/misc/rikka/rikka.mdl': $unique_id = '小鸟游六花';break;
        case 'models/player/custom_player/maoling/black_rock_shooter/brs/brs.mdl': $unique_id = '黑岩射手';break;
        case 'models/player/custom_player/maoling/kantai_collection/amatsukaze/amatsukaze.mdl': $unique_id = '天津风';break;
        case 'models/player/custom_player/maoling/lovelive/kotori/school/kotori.mdl': $unique_id = '南小鸟';break;
        case 'models/player/custom_player/maoling/kantai_collection/hikibi/hikibi.mdl': $unique_id = '响';break;
        case 'models/player/custom_player/maoling/vocaloid/haku/uniform/haku.mdl': $unique_id = '弱音';break;
        case 'models/player/custom_player/maoling/neptunia/neptune/swimsuit/neptune.mdl': $unique_id = '妮普褆努.泳装';break;
        case 'models/player/custom_player/maoling/neptunia/neptune/swimwear/neptune.mdl': $unique_id = '妮普褆努.夏日鮮黃';break;
        case 'models/player/custom_player/maoling/re0/ram/ram.mdl': $unique_id = '拉姆';break;
        case 'models/player/custom_player/maoling/neptunia/blanc/normal/blanc.mdl': $unique_id = '布蘭';break;
        case 'models/player/custom_player/maoling/neptunia/vert/normal/vert.mdl': $unique_id = '貝兒';break;
        case 'models/player/custom_player/maoling/guilty_crown/inori_v2/inori.mdl': $unique_id = '蝶祈';break;
        case 'models/player/custom_player/maoling/misc/banana_joe/banana_joe.mdl': $unique_id = '香蕉人';break;
        case 'models/player/custom_player/maoling/date_a_live/tohka/spirit/tohka.mdl': $unique_id = '夜刀神十香';break;
        case 'models/player/custom_player/maoling/date_a_live/kurumi/spirit/kurumi.mdl': $unique_id = '时崎狂三';break;
        case 'models/player/custom_player/maoling/touhou/remilia_scarlet/remilia_scarlet.mdl': $unique_id = '蕾米莉亚';break;
        case 'models/player/custom_player/maoling/touhou/flandre_scarlet/flandre_scarlet.mdl': $unique_id = '芙兰朵露';break;
        case 'models/player/custom_player/maoling/seirei_tsukai_no_blade_dance/terminus_est/terminus_est.mdl': $unique_id = '提露密努斯艾斯特';break;
        case 'models/player/custom_player/maoling/kantai_collection/shimakaze/shimakaze.mdl': $unique_id = '岛风';break;
        case 'models/player/custom_player/maoling/haipa/haipa.mdl': $unique_id = '害怕';break;
        case 'models/player/custom_player/maoling/date_a_live/kotori/school/kotori.mdl': $unique_id = '琴里.校服';break;
        case 'models/player/custom_player/maoling/closeronline/seulbi/seulbi.mdl': $unique_id = 'Seulbi.Agent';break;
        case 'models/player/custom_player/maoling/kantai_collection/U511/u511.mdl': $unique_id = 'U-511';break;
        case 'models/player/custom_player/maoling/closeronline/cybernetic/cybernetic.mdl': $unique_id = 'Violet.Cybernetic';break;
        case 'models/player/custom_player/maoling/closeronline/violet/violet.mdl': $unique_id = 'Seulbi.Queen';break;
        case 'models/player/custom_player/maoling/vocaloid/luotianyi/canary/lty.mdl': $unique_id = '洛天依.金丝雀旗袍(TDA)';break;
        case 'models/player/custom_player/maoling/vocaloid/yuezhengling/canary/yzl.mdl': $unique_id = '乐正绫.金丝雀旗袍(TDA)';break;
        case 'models/player/custom_player/maoling/re0/rem/rem.mdl': $unique_id = '蕾姆';break;
        case 'models/player/custom_player/maoling/neptunia/uni/normal/uni.mdl': $unique_id = '優尼';break;
        case 'models/player/custom_player/maoling/hongkai_impact3/kiana/kiana.mdl': $unique_id = '琪亚娜';break;
        case 'models/player/custom_player/maoling/neptunia/neptune/nextform/nextpurple_nothruster.mdl': $unique_id = 'NextPurple';break;
        case 'models/player/custom_player/maoling/touhou/momiji/momiji.mdl': $unique_id = '犬走椛';break;
        case 'models/player/custom_player/maoling/kantai_collection/hoppou/hoppou.mdl': $unique_id = '北方栖姬';break;
        case 'models/player/custom_player/maoling/neptunia/histoire/normal/histoire.mdl': $unique_id = '希斯';break;
        case 'models/player/custom_player/maoling/fairyfancyf/tiara/tiara.mdl': $unique_id = '褆亞拉';break;
        case 'models/player/custom_player/maoling/neptunia/pururut/normal/pururut.mdl': $unique_id = '普魯魯特';break;
        case 'models/player/custom_player/maoling/re0/emilia_v2/emilia.mdl': $unique_id = '艾米莉亚';break;
        case 'models/player/custom_player/maoling/kantai_collection/yuudachi/yuudachi.mdl': $unique_id = '夕立';break;
        case 'models/player/custom_player/maoling/vocaloid/luka/punk/luka.mdl': $unique_id = '巡音露卡.摇滚';break;
        case 'models/player/custom_player/maoling/vocaloid/hatsune_miku/cybertech/miku_v2.mdl': $unique_id = 'CyberTech.Miku';break;
        case 'models/player/custom_player/maoling/vocaloid/hatsune_miku/nightmare/miku.mdl': $unique_id = 'Nightmare.Miku';break;
        case 'models/player/custom_player/maoling/neptunia/blanc/nextform/nextwhite_glow.mdl': $unique_id = 'Next White';break;
        case 'models/player/custom_player/maoling/misc/EnoshimaJunko/ej.mdl': $unique_id = 'Enoshima.Junko';break;
        case 'models/player/custom_player/maoling/sword_art_online/kirito/sao/kirito.mdl': $unique_id = '桐子';break;
        case 'models/player/custom_player/maoling/utau/meiji/one_dress/meiji.mdl': $unique_id = '歌幡meiji';break;
        case 'models/player/custom_player/maoling/vocaloid/luka/baka/luka.mdl': $unique_id = 'Luka(Kimono)';break;
        case 'models/player/custom_player/maoling/date_a_live/kotori/commander/kotori.mdl': $unique_id = '琴里.指挥官';break;
        case 'models/player/custom_player/maoling/date_a_live/kotori/spirit/kotori.mdl': $unique_id = '琴里.灵装';break;
        case 'models/player/custom_player/maoling/neptunia/Million_Arthur/swimwear/million.mdl': $unique_id = '百万亚瑟王';break;
        case 'models/player/custom_player/maoling/sword_art_online/shino/ggo/shino.mdl': $unique_id = '朝田诗乃';break;
        case 'models/player/custom_player/maoling/neptunia/neptune/hdd/purpleheart.mdl': $unique_id = 'PupleHeart';break;
        case 'models/maoling/wings/kiana/kiana_wings.mdl': $unique_id = '月光之翼';break;
        case 'models/shop/perfectworld_wings01_v3.mdl': $unique_id = '燕子翅膀';break;
        case 'models/shop/perfectworld_wings03_v3.mdl': $unique_id = '冰火之翼';break;
        case 'models/shop/perfectworld_wings04_v3.mdl': $unique_id = '精灵之翼';break;
        case 'models/shop/perfectworld_wings05_v3.mdl': $unique_id = '大天使之翼';break;
        case 'models/shop/perfectworld_wings06_v3.mdl': $unique_id = 'Hawk Wing';break;
        case 'models/shop/perfectworld_wings07_v3.mdl': $unique_id = '妖精之翼';break;
        case 'models/shop/perfectworld_wings08_v3.mdl': $unique_id = '恶魔之翼';break;
        case 'models/shop/perfectworld_wings09_v3.mdl': $unique_id = '翼展天际';break;
        case 'models/player/holiday/facemasks/facemask_chicken.mdl': $unique_id = 'Chicken(动态)';break;
        case 'models/player/holiday/facemasks/facemask_pumpkin.mdl': $unique_id = '南瓜面具';break;
        case 'models/vikinghelmet/vikinghelmet.mdl': $unique_id = '维京海盗';break;
        case 'models/sam/antlers.mdl': $unique_id = '鹿角';break;
        case 'models/astronauthelmet/astronauthelmet.mdl': $unique_id = '宇航员头盔 ';break;
        case 'models/gmod_tower/fedorahat.mdl': $unique_id = '软呢帽';break;
        case 'models/gmod_tower/pimphat.mdl': $unique_id = '特务帽';break;
        case 'models/gmod_tower/seusshat.mdl': $unique_id = 'Seuss帽';break;
        case 'models/gmod_tower/sombrero.mdl': $unique_id = '墨西哥草帽';break;
        case 'models/gmod_tower/toetohat.mdl': $unique_id = '鼠帽';break;
        case 'models/gmod_tower/witchhat.mdl': $unique_id = '女巫帽';break;
        case 'models/gmod_tower/afro.mdl': $unique_id = '爆炸头';break;
        case 'models/gmod_tower/catears.mdl': $unique_id = '猫耳';break;
        case 'models/gmod_tower/tophat.mdl': $unique_id = '顶帽';break;
        case 'models/player/holiday/santahat.mdl': $unique_id = '圣诞帽';break;
        case 'models/gmod_tower/kfcbucket.mdl': $unique_id = 'KFC';break;
        case 'models/pikahat/pikahat.mdl': $unique_id = '皮卡丘';break;
        case 'models/anime_patron/animepatr.mdl': $unique_id = '赛亚人';break;
        case 'models/duncehat/duncehat.mdl': $unique_id = '舞会帽';break;
        case 'models/store/hats/uncle_sam_hat.mdl': $unique_id = '山姆大叔';break;
        case 'models/store/hats/daft_punk_v1.mdl': $unique_id = 'Daft Punk';break;
        case 'models/gmod_tower/starglasses.mdl': $unique_id = '星星眼镜';break;
        case 'models/gmod_tower/3dglasses.mdl': $unique_id = '3D眼镜';break;
        case 'models/gmod_tower/aviators.mdl': $unique_id = '飞行墨镜';break;
        case 'models/gmod_tower/klienerglasses.mdl': $unique_id = '施瓦辛格';break;
        case 'models/store/hats/hylian_shield.mdl': $unique_id = 'Hylian Shield';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '红色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '柠檬绿';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '蓝色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '白杏色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '深粉红';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '深红色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '米色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '土豪金';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '亮菊黄';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '紫罗兰红';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '橙色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '苍麒麟色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '桃肉色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '紫色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '巧克力色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '水鸭色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '蓟色';break;
        case 'materials/sprites/laserbeam.vmt': $unique_id = '矢车菊蓝色';break;
        case 'models/props/cs_italy/orange.mdl': $unique_id = '橙子';break;
        case 'models/props/cs_italy/bananna.mdl': $unique_id = 'Banana';break;
        case 'models/props_junk/watermelon01.mdl': $unique_id = 'Watermelon';break;
        case 'materials/maoling/sprays/cglogo2.vmt': $unique_id = 'CG社区[涂鸦]';break;
        case 'materials/maoling/sprays/cglogo.vmt': $unique_id = 'CG社区';break;
        case 'materials/maoling/sprays/laia.vmt': $unique_id = '互相伤害';break;
        case 'materials/maoling/sprays/na.vmt': $unique_id = '呐!!';break;
        case 'materials/maoling/sprays/cghaipa.vmt': $unique_id = '害怕';break;
        case 'materials/maoling/sprays/slaydog.vmt': $unique_id = '友谊的小狗';break;
        case 'materials/maoling/sprays/50highnoon.vmt': $unique_id = '50已到';break;
        case 'materials/maoling/sprays/paomianwang.vmt': $unique_id = '琴里[泡面]';break;
        case 'materials/maoling/sprays/yaomeng1.vmt': $unique_id = '妖梦[温斯顿]';break;
        case 'materials/maoling/sprays/peter.vmt': $unique_id = 'Peter[尴尬]';break;
        case 'maoling/store/overwatch/genji.mp3': $unique_id = '源氏';break;
        case 'maoling/store/overwatch/hanzo.mp3': $unique_id = '半藏';break;
        case 'maoling/store/overwatch/junkrat.mp3': $unique_id = '狂鼠';break;
        case 'maoling/store/overwatch/mccree.mp3': $unique_id = '麦爹';break;
        case 'maoling/store/overwatch/mei.mp3': $unique_id = '小美';break;
        case 'maoling/store/overwatch/lucio.mp3': $unique_id = 'DJ';break;
        case 'cheer/cheer_1.mp3': $unique_id = '笑声1';break;
        case 'cheer/cheer_2.mp3': $unique_id = '笑声2';break;
        case 'cheer/cheer_3.mp3': $unique_id = '笑声3';break;
        case 'cheer/cheer_4.mp3': $unique_id = '笑声4';break;
        case 'cheer/cheer_5.mp3': $unique_id = '笑声5';break;
        case 'cheer/cheer_6.mp3': $unique_id = '笑声6';break;
        case 'cheer/cheer_7.mp3': $unique_id = '笑声7';break;
        case 'cheer/cheer_8.mp3': $unique_id = '笑声8';break;
        case 'cheer/cheer_9.mp3': $unique_id = '笑声9';break;
        case 'cheer/cheer_10.mp3': $unique_id = '笑声10';break;
        case 'cheer/cheer_11.mp3': $unique_id = '笑声11';break;
        case 'cheer/cheer_12.mp3': $unique_id = '笑声12';break;
        case 'cheer/cheer_13.mp3': $unique_id = '笑声13';break;
        case 'cheer/cheer_14.mp3': $unique_id = '笑声14';break;
        case 'cheer/cheer_15.mp3': $unique_id = '笑声15';break;
        case 'models/maoling/weapon/overwatch/knife/genji/katana_v.mdl': $unique_id = '龙神剑';break;
        case 'models/maoling/weapon/borderlands2/knife/zero/sword_v.mdl': $unique_id = 'Zero Sword';break;
        case 'models/maoling/weapon/neptunia/knife/neptune/sword_4_v.mdl': $unique_id = 'PurpleHeart`s Sword 4';break;
        case 'models/maoling/weapon/neptunia/knife/neptune/sword_3_v.mdl': $unique_id = 'PurpleHeart`s Sword 3';break;
        case 'models/maoling/weapon/neptunia/knife/neptune/sword_2_v.mdl': $unique_id = 'PurpleHeart`s Sword 2';break;
        case 'models/maoling/weapon/neptunia/knife/neptune/sword_1_v.mdl': $unique_id = 'PurpleHeart`s Sword 1';break;
        case 'models/maoling/weapon/neptunia/knife/neptune/nextpurple_sword_v.mdl': $unique_id = 'NextPurple`s Sword';break;
        case 'models/maoling/weapon/neptunia/awp/neptune/awp.mdl': $unique_id = 'Neptune AWP';break;
        case 'models/maoling/weapon/vocaloid/deagle/deagle.mdl': $unique_id = 'Vocaloid Deagle';break;
        case 'materials/maoling/trails/planeptune.vmt': $unique_id = 'Planeptune';break;
        case 'materials/maoling/trails/huaji.vmt': $unique_id = '滑稽';break;
        case 'materials/maoling/trails/doge.vmt': $unique_id = 'Doge';break;
        case 'materials/sprites/store/trails/arrowrainbow.vmt': $unique_id = '彩色箭头';break;
        case 'materials/sprites/store/trails/awesome.vmt': $unique_id = '305';break;
        case 'materials/sprites/store/trails/banknote.vmt': $unique_id = '钞票';break;
        case 'materials/sprites/store/trails/bluelightning.vmt': $unique_id = '闪电';break;
        case 'materials/sprites/store/trails/crown.vmt': $unique_id = '皇冠';break;
        case 'materials/sprites/store/trails/fuu1.vmt': $unique_id = '暴漫 Fuu 1';break;
        case 'materials/sprites/store/trails/pokeball.vmt': $unique_id = '数码宝贝';break;
        case 'materials/sprites/store/trails/psychball.vmt': $unique_id = '精神球';break;
        case 'materials/sprites/store/trails/rainbow.vmt': $unique_id = '*彩虹*';break;
        case 'materials/sprites/store/trails/smugleaf.vmt': $unique_id = '藤藤蛇';break;
        case 'materials/sprites/store/trails/spongebob.vmt': $unique_id = '海绵宝宝';break;
        case 'materials/sprites/store/trails/trollface.vmt': $unique_id = '暴漫 Troll';break;
        case 'materials/sprites/store/trails/windows.vmt': $unique_id = 'Windows';break;
        case 'materials/sprites/store/trails/yingyang2.vmt': $unique_id = '太极';break;
        case 'Trail': $unique_id = '渐变粒子';break;
        case 'Trail5': $unique_id = '火焰粒子';break;
        case 'Trail2': $unique_id = '鞭炮粒子';break;
        case 'Trail3': $unique_id = '浪花粒子';break;
        case 'Trail4': $unique_id = '喷射粒子';break;
        case 'Trail7': $unique_id = '绿色星火';break;
        case 'Trail8': $unique_id = '星光粒子';break;
        case 'Trail9': $unique_id = '粉色尖刺';break;
        case 'Trail10': $unique_id = '细菌孢子';break;
        case 'Trail11': $unique_id = '橙色星火';break;
        case 'Aura1': $unique_id = '橙色旋风';break;
        case 'Aura2': $unique_id = '红色尖刺黑洞';break;
        case 'Aura3': $unique_id = '蓝紫尖刺';break;
        case 'Aura4': $unique_id = '绿色尖刺黑洞';break;
        case 'Aura5': $unique_id = '慢-星空';break;
        case 'Aura6': $unique_id = '星空';break;
        case 'Aura7': $unique_id = '粒子漩涡';break;
        case 'Aura8': $unique_id = '青紫粒子漩涡';break;
        case 'Aura9': $unique_id = '蓝色粒子漩涡';break;
        case 'Aura10': $unique_id = '紫色尖刺漩涡';break;
        //case '': $unique_id = '';break;
        //case '': $unique_id = '';break;
        //case '': $unique_id = '';break;
        //case '': $unique_id = '';break;
        //case '': $unique_id = '';break;
        //case '': $unique_id = '';break;
    }

    return $unique_id;
}

?>