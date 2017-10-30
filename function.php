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

?>