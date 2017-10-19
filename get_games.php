<?php
include 'functions.php';
ini_set('max_execution_time', 180);
$steamid = $_GET['steamid'];
$api_key = '';
$data = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".$api_key."&steamid=".$steamid."&include_played_free_games=0&include_appinfo=1"),true);
$array = array('data' => array());
foreach ($data['response']['games'] as $theentity2)
{
    $appid = $theentity2['appid'];
    $glname = $theentity2['name'];
    $logo = $theentity2['img_logo_url'];
    $icon = $theentity2['img_icon_url'];
    $playtime = $theentity2['playtime_forever'];
    if(isset($theentity2['playtime_2weeks'])) {
        $playtime2weeks = $theentity2['playtime_2weeks'];
    }else{
        $playtime2weeks = '0';
    }
    if ($playtime == 0){
        $playtime = 0;//never played
        $playtime_converted = 0;
    } else {
        $playtime = $theentity2['playtime_forever'];
        $playtime_converted = convertToHoursMins($playtime, '%02d Hours, %02d Minutes');
    }
    if ($playtime2weeks == 0){
        $playtime_converted2 = 0;
    } else {
        $playtime_converted2 = convertToHoursMins($playtime2weeks, '%02d Hours, %02d Minutes');
    }
    $array['gameslist'][] = array (
        'game' => $theentity2['name'],
        'gameid' => $theentity2['appid'],
        'logo' => $theentity2['img_logo_url'],
        'playtimec' => $playtime_converted,
        'playtime2weeksc' => $playtime_converted2,
        'playtime' => $playtime,
        'playtime2weeks' => $playtime2weeks);
}
$encode = json_encode($array);
$fp = fopen("".$steamid."_games.json", "w");
fwrite($fp, $encode);
fclose($fp);
