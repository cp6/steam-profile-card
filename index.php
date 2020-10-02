<?php
require_once('functions.php');
if (isset($_GET['steamid'])) {
    $steamid = $_GET['steamid'];
} else {
    echo "?steamid= is missing";
    exit;
}
if (file_exists("{$steamid}.json")) {
    $data = json_decode(file_get_contents("{$steamid}.json"));
} else {
    echo "{$steamid}.json does not exist";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $data->name; ?>'s steam profile card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="custom.css">
    <link href="https://fonts.googleapis.com/css?family=Anton|Asap" rel="stylesheet">
</head>
<body>
<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="well">
                <?php
                echo "<a href='" . $data->profileurl . "'><img src='" . $data->avatar . "' class='img-circle'></a>";
                echo "<h1><a href='" . $data->profileurl . "'>" . $data->name . "</a></h1>";
                if (is_null($data->realname)) {
                } else {
                    echo "<p class='details'>" . $data->realname . "</p>";
                };
                if ($data->profile_state == 0) {
                    echo "<p class='details' style='color:#ff2b23;'>" . profile_status($data->profile_state) . "</p>";
                } elseif ($data->profile_state == 1) {
                    echo "<p class='details' style='color:lawngreen;'>" . profile_status($data->profile_state) . "</p>";
                } else {
                    echo "<p class='details'>" . profile_status($data->profile_state) . "</p>";
                };
                echo "<p class='details'><a href='games.php?steamid=" . $steamid . "' class='details'>" . $data->gamecount . " Games</a></p>";
                echo "<p class='details'><a href='friends.php?steamid=" . $steamid . "' class='details'>" . $data->friendcount . " Friends</a></p>";
                $levelup_p = ($data->steam_xp / $data->xp_levelup * 100);
                echo "<p class='details'>Level " . $data->steam_level . "</p>";
                echo "<p class='details'>Badges: " . $data->badge_count . "</p>";
                echo "<p class='details'>Created: " . time_elapsed_string($data->created_date, $full = true) . "</p>";
                if ($data->profile_state == 0) {
                    echo "<p  class='details'>Last on: " . time_elapsed_string($data->llo, $full = true) . "</p>";
                } else {
                };
                $rp1 = rp($steamid, 0);
                $rp2 = rp($steamid, 1);
                $rp3 = rp($steamid, 2);
                $rp4 = rp($steamid, 3);
                echo "<h3 class='r-p'>Recently played</h3>";
                if (is_null($rp1)) {
                } else {
                    echo "<div class='rp-green'>";
                    echo "<a href='http://steamcommunity.com/app/" . $rp1['appid'] . "' title='" . $rp1['game'] . "'><img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $rp1['appid'] . "/" . $rp1['logo'] . ".jpg' class='img-rounded rpimg'></a>";
                    echo "<h3>" . $rp1['game'] . "</h3>";
                    echo "<p class='game-details-orange'>Played last 2 weeks:</p><p class='game-details'> " . $rp1['played2weeksc'] . "</p>";
                    echo "<p class='game-details-orange'>Played total:</p><p class='game-details'> " . $rp1['playedforeverc'] . "</p>";
                    echo "</div>";
                }
                if (is_null($rp2)) {
                } else {
                    echo "<div class='rp-blue'>";
                    echo "<a href='http://steamcommunity.com/app/" . $rp2['appid'] . "' title='" . $rp2['game'] . "'><img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $rp2['appid'] . "/" . $rp2['logo'] . ".jpg' class='img-rounded rpimg'></a>";
                    echo "<h3>" . $rp2['game'] . "</h3>";
                    echo "<p class='game-details-orange'>Played last 2 weeks:</p><p class='game-details'> " . $rp2['played2weeksc'] . "</p>";
                    echo "<p class='game-details-orange'>Played total:</p><p class='game-details'> " . $rp2['playedforeverc'] . "</p>";
                    echo "</div>";
                }
                if (is_null($rp3)) {
                } else {
                    echo "<div class='rp-purple'>";
                    echo "<a href='http://steamcommunity.com/app/" . $rp3['appid'] . "' title='" . $rp3['game'] . "'><img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $rp3['appid'] . "/" . $rp3['logo'] . ".jpg' class='img-rounded rpimg'></a>";
                    echo "<h3>" . $rp3['game'] . "</h3>";
                    echo "<p class='game-details-orange'>Played last 2 weeks:</p><p class='game-details'> " . $rp3['played2weeksc'] . "</p>";
                    echo "<p class='game-details-orange'>Played total:</p><p class='game-details'> " . $rp3['playedforeverc'] . "</p>";
                    echo "</div>";
                }
                if (is_null($rp3)) {
                } else {
                    echo "<div class='rp-pink'>";
                    echo "<a href='http://steamcommunity.com/app/" . $rp4['appid'] . "' title='" . $rp4['game'] . "'><img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $rp4['appid'] . "/" . $rp4['logo'] . ".jpg' class='img-rounded rpimg'></a>";
                    echo "<h3>" . $rp4['game'] . "</h3>";
                    echo "<p class='game-details-orange'>Played last 2 weeks:</p><p class='game-details'> " . $rp4['played2weeksc'] . "</p>";
                    echo "<p class='game-details-orange'>Played total:</p><p class='game-details'> " . $rp4['playedforeverc'] . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <div class="col-lg-3">
        </div>
    </div>
</div>
</body>
</html>