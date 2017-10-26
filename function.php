<?php

ini_set("display_errors", "On");

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

?>