<?php
ini_set('max_execution_time', 180);
$api_key = '';

function profile_status($call)
{
    $state = '';
    if ($call == 0) {
        $state = "Offline";
    } elseif ($call == 1) {
        $state = "Online";
    } elseif ($call == 2) {
        $state = "Busy";
    } elseif ($call == 3) {
        $state = "Away";
    } elseif ($call == 4) {
        $state = "Snooze";
    } elseif ($call == 5) {
        $state = "Looking to trade";
    } elseif ($call == 6) {
        $state = "Looking to play";
    };
    return $state;
}

function game_count($steamid)
{
    global $api_key;
    $data = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . $api_key . "&steamid=" . $steamid . "&include_played_free_games=0&include_appinfo=1"));
    return $data->response->game_count;
}

function friend_count($steamid)
{
    global $api_key;
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=" . $api_key . "&steamid=" . $steamid . "&relationship=friend"));
    return count($data->friendslist->friends);
}

//hours to mins converters
function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day'
        //'h' => 'hour',
        //'i' => 'minute',
        //'s' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function rp($steamid, $number)
{
    global $api_key;
    $data2 = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=" . $api_key . "&steamid=" . $steamid . "&format=json&count=5"), true);
    $rp1appid = $data2['response']['games'][$number]['appid'];
    $rp1name = $data2['response']['games'][$number]['name'];
    $rp1played_2 = $data2['response']['games'][$number]['playtime_2weeks'];
    $rp1playtime_converted2 = convertToHoursMins($rp1played_2, '%02d Hours, %02d Minutes');
    $rp1played_forever = $data2['response']['games'][$number]['playtime_forever'];
    $rp1playtime_converted3 = convertToHoursMins($rp1played_forever, '%02d Hours, %02d Minutes');
    $rp1logo = $data2['response']['games'][$number]['img_logo_url'];
    $rp1icon = $data2['response']['games'][$number]['img_icon_url'];
    //convert rp's 2 weeks
    $rplaytime2_converted1 = convertToHoursMins($rp1played_2, '%02d Hours, %02d Minutes');
//convert rp's
    $rplaytime_converted1 = convertToHoursMins($rp1played_forever, '%02d Hours, %02d Minutes');
    return array('game' => $rp1name, 'appid' => $rp1appid, 'played2weeks' => $rp1played_2, 'playedforever' => $rp1played_forever, 'played2weeksc' => $rplaytime2_converted1, 'playedforeverc' => $rplaytime_converted1, 'logo' => $rp1logo, 'icon' => $rp1icon);
}

function game_logo($appid, $logo)
{
    return "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $appid . "/" . $logo . ".jpg";
}

function game_link($appid)
{
    return "http://steamcommunity.com/app/" . $appid . "";
}
