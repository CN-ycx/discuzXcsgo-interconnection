<?php

function SteamID64ToSteamID32($steam64, $prefix)
{
	$tsid = array(substr($steam64, -1, 1) % 2 == 0 ? 0 : 1);
    $tsid[1] = bcsub($steam64, '76561197960265728');
    if(bccomp($tsid[1], '0') != 1){
        $steamid = '';
    }
    $tsid[1] = bcsub($tsid[1], $tsid[0]);
	list($tsid[1], ) = explode('.',bcdiv($tsid[1], 2), 2);
    $steamid = implode(':', $tsid);
    if($prefix){
        $steamid = 'STEAM_1:'.$steamid;
    }
	return $steamid;
}

function LogMessage($message)
{
    $fp = fopen( __DIR__ . "/errorlog.php", "a");
    fputs($fp, "<?PHP exit;?>    ");
    fputs($fp, $message);
    fputs($fp, "\n");
    fclose($fp);
}

function UpdateSteamProfiles($database, $apikey, $steamid, $uid)
{
    $array = array();
    
    // Get Summaries (name, id, avatar)
    $url = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=$apikey&steamids=$steamid";

    $curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	curl_close($curl);
    
    $json = json_decode($data, true);

    foreach($json as $key => $value)
	{
		foreach($value['players'] as $k => $v)
		{
			$array['nick'] = $v['personaname'];
			$array['steam'] = $v['steamid'];
			$array['avatar'] = $v['avatar'];
            $array['state'] = "Offline";
            $array['gameid'] = 0;

			if(isset($v['gameextrainfo'])){
                $array['state'] = $v['gameextrainfo'];
                $array['gameid'] = $v['gameid'];
            }elseif($v['personastate'] > 0){
                switch($v['personastate'])
                {
                    case 0: $array['state'] = "Offline"; break;
                    case 1: $array['state'] = "Online"; break;
                    case 2: $array['state'] = "Busy"; break;
                    case 3: $array['state'] = "Away"; break;
                    case 4: $array['state'] = "Snooze"; break;
                    case 5: $array['state'] = "looking to trade"; break;
                    case 6: $array['state'] = "looking to play"; break;
                }
            }elseif($v['communityvisibilitystate'] == 1){
                $array['state'] = "Private Profile";
            }
		}
	}
    
    if($steamid != $array['steam']){
        LogMessage("SteamID ERROR (".$steamid." : ".$array['steam'].")");
        return false;
    }

    // Get Badges (level, badges)
    $url = "https://api.steampowered.com/IPlayerService/GetBadges/v1/?key=$apikey&steamid=$steamid";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	curl_close($curl);
    
    $json = json_decode($data, true);

	foreach($json as $key => $value)
	{
		$array['badges'] = 0;
		$array['levels'] = $value['player_level'];
		if($value['player_level'] != null){
			foreach($value['badges'] as $k => $v)
			{
				$array['badges']++;
			}
		}
	}

    $array['nick'] = str_replace(array('&','<','>'),array('&amp;','&lt;','&gt;'), $array['nick']);
	$array['E_nick'] = mysqli_real_escape_string($database, $array['nick']);
    $array['E_avatar'] = mysqli_real_escape_string($database, $array['avatar']);
    $array['E_current'] = mysqli_real_escape_string($database, $array['state']);

    DB::query("UPDATE " . DB::table('steam_users') . " SET lastupdate = '".time()."', steamNickname = '".$array['E_nick']."', level = '".$array['levels']."', badges = '".$array['badges']."', avatar = '".$array['E_avatar']."', current = '".$array['E_current']."', gameid = '".$array['gameid']."' WHERE uid = '".$uid."'");
    return true;
}

// https://github.com/rossengeorgiev/vdf-parser/blob/master/vdf.php
function KeyValuesToArray($kv)
{
    if(!is_string($kv)){
        trigger_error("parameter is not string!", E_USER_NOTICE);
        return NULL;
    }

    if      (substr($kv, 0, 2) == "\xFE\xFF")         $kv = mb_convert_encoding($kv, 'UTF-8', 'UTF-16BE');
    else if (substr($kv, 0, 2) == "\xFF\xFE")         $kv = mb_convert_encoding($kv, 'UTF-8', 'UTF-16LE');
    else if (substr($kv, 0, 4) == "\x00\x00\xFE\xFF") $kv = mb_convert_encoding($kv, 'UTF-8', 'UTF-32BE');
    else if (substr($kv, 0, 4) == "\xFF\xFE\x00\x00") $kv = mb_convert_encoding($kv, 'UTF-8', 'UTF-32LE');

    $kv = preg_replace('/^[\xef\xbb\xbf\xff\xfe\xfe\xff]*/', '', $kv);

    $lines = preg_split('/\n/', $kv);

    $array = array();
    $stack = array(0=>&$array);
    $expect_bracket = false;
    $name = "";

    $re_keyvalue = '~^("(?P<qkey>(?:\\\\.|[^\\\\"])+)"|(?P<key>[a-z0-9\\-\\_]+))' .
                   '([ \t]*(' .
                   '"(?P<qval>(?:\\\\.|[^\\\\"])*)(?P<vq_end>")?' .
                   '|(?P<val>[a-z0-9\\-\\_]+)' .
                   '))?~iu';

    $j = count($lines);
    for($i = 0; $i < $j; $i++)
    {
        $line = trim($lines[$i]);

        if($line == "" || $line[0] == '/'){
            continue;
        }

        if($line[0] == "{"){
            $expect_bracket = false;
            continue;
        }

        if($expect_bracket){
            trigger_error("invalid syntax, expected a '}' on line " . ($i+1), E_USER_NOTICE);
            return Null;
        }

        if($line[0] == "}"){
            array_pop($stack);
            continue;
        }

        while(True)
        {
            preg_match($re_keyvalue, $line, $m);

            if(!$m){
                trigger_error("invalid syntax on line " . ($i+1), E_USER_NOTICE);
                return NULL;
            }

            $key = (isset($m['key']) && $m['key'] !== "") ? $m['key'] : $m['qkey'];
            $val = (isset($m['qval']) && (!isset($m['vq_end']) || $m['vq_end'] !== "")) ? $m['qval'] : (isset($m['val']) ? $m['val'] : False);

            if($val === False){
                if(!isset($stack[count($stack)-1][$key])){
                    $stack[count($stack)-1][$key] = array();
                }
                $stack[count($stack)] = &$stack[count($stack)-1][$key];
                $expect_bracket = true;
            }else{
                if(!isset($m['vq_end']) && isset($m['qval'])){
                    $line .= "\n" . $lines[++$i];
                    continue;
                }

                $stack[count($stack)-1][$key] = $val;
            }
            break;
        }
    }

    if(count($stack) !== 1){
        trigger_error("open parentheses somewhere", E_USER_NOTICE);
        return NULL;
    }

    return $array;
}

?>