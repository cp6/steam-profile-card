<?php
include 'functions.php';
$steamid = $_GET['steamid'];
function sum($steamid)
{
global $api_key;
$data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $api_key . "&steamids=" . $steamid . ""));
$main = $data->response->players[0];
$profile_state = $main->profilestate;
$name = $main->personaname;
$lastlogoff = $main->lastlogoff;
$profileurl = $main->profileurl;
$personastate = $main->personastate;
$realname = $main->realname;
$timecreated = $main->timecreated;
$loccountrycode = $main->loccountrycode;
$avatar = $main->avatarfull;
$created_on = date("Y-m-d\TH:i:s", $timecreated);
$llo = date("Y-m-d\TH:i:s", $lastlogoff);
//Level stuff
$data2 = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetBadges/v1/?key=" . $api_key . "&steamid=" . $steamid . ""));
$badge_count = count($data2->response->badges);
$steam_level = $data2->response->player_level;
$steam_xp = $data2->response->player_xp;
$steam_xp_needed_to_level_up = $data2->response->player_xp_needed_to_level_up;
$steam_xp_needed_current_level = $data2->response->player_xp_needed_current_level;

$array = array('profile_state' => $profile_state,
'name' => $name,
'lastlogoff' => $lastlogoff,
'llo' => $llo,
'profileurl' => $profileurl,
'personastate' => $personastate,
'realname' => $realname,
'timecreated' => $timecreated,
'created_date' => $created_on,
'avatar' => $avatar,
'profilestate' => profile_status($profile_state),
'gamecount' => game_count($steamid),
'friendcount' => game_count($steamid),
'badge_count' => $badge_count,
'steam_level' => $steam_level,
'steam_xp' => $steam_xp,
'xp_levelup' => $steam_xp_needed_to_level_up,
'xp_levelnow' => $steam_xp_needed_current_level);
$encode = json_encode($array);
$fp = fopen(''.$steamid.'.json', "w");
fwrite($fp, $encode);
fclose($fp);
return 1;
}

echo sum($steamid);
