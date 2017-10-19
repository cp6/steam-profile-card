<?php
ini_set('max_execution_time', 180);
$steamid = $_GET['steamid'];
$api_key = '';
//unix to days,hours,mins
function GetTimeDiff($timestamp)
{
    $how_long_ago = '';
    $seconds = time() - $timestamp;
    $minutes = (int)($seconds / 60);
    $hours = (int)($minutes / 60);
    $days = (int)($hours / 24);
    if ($days >= 1) {
        $how_long_ago = $days . ' day' . ($days != 1 ? 's' : '');
    } else if ($hours >= 1) {
        $how_long_ago = $hours . ' hour' . ($hours != 1 ? 's' : '');
    } else if ($minutes >= 1) {
        $how_log_ago = $minutes . ' minute' . ($minutes != 1 ? 's' : '');
    } else {
        $how_long_ago = $seconds . ' second' . ($seconds != 1 ? 's' : '');
    }
    return $how_long_ago;
}
function getav($steamid){
    global $api_key;
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$api_key."&steamids=".$steamid.""));
    $player = $data->response->players[0];
    $steamid = $player->steamid;
    $profileurl = $player->profileurl;
    $name          = $player->personaname;
    //$realname          = $player->realname;
    $link         = $player->profileurl;
    $avatar       = $player->avatarfull;
    return $avatar;
}
function getname($steamid){
    global $api_key;
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$api_key."&steamids=".$steamid.""));
    $player = $data->response->players[0];
    $name          = $player->personaname;
    //$realname          = $player->realname;
    return $name;
}
function getfriends($steamid){
    global $api_key;
    $data = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=".$api_key."&steamid=".$steamid."&relationship=friend"), true);
    $friendslist = array();
    foreach ($data['friendslist']['friends'] as $theentity)
    {
        $friendssteamid = $theentity['steamid']."";
        $friend_name =  getname($friendssteamid);
        $fsince = $theentity['friend_since']."";
        $playtime_converted4 = GetTimeDiff($fsince);
        $friendslist['friendslist'][] = array (
            'steamid' => $friendssteamid,
            'name' => $friend_name,
            'friendsfor' => $playtime_converted4);
    }
    $friendslist = json_encode($friendslist);
    $data4 = json_decode($friendslist, true);
    $array = array('data' => array());
    foreach ($data4['friendslist'] as $theentity3)
    {
        $steam_id = $theentity3['steamid'];
        $friend_name =  $theentity3['name'];
        $avatar = getav($steam_id);
        $fsince = $theentity3['friendsfor'];
        $array['data'][] = array ('steamid' => $steam_id, 'friendname' => $friend_name, 'friendav' => $avatar, 'friendsince' => $fsince);
    }
    $encode = json_encode($array);
    $fp = fopen("".$steamid."_friends.json", "w");
    fwrite($fp, $encode);
    fclose($fp);
}

echo getfriends($steamid);
