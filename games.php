<?php
if (isset($_GET['steamid'])) {
    $steamid = $_GET['steamid'];
} else {
    echo "?steamid= is missing";
    exit;
}
if (file_exists("{$steamid}_games.json")) {
    $data = json_decode(file_get_contents("{$steamid}_games.json"), true);
} else {
    echo "{$steamid}_games.json does not exist";
    exit;
}
if (file_exists("{$steamid}.json")) {
    $data2 = json_decode(file_get_contents("{$steamid}.json"));
} else {
    echo "{$steamid}.json does not exist";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $data2->name; ?>'s steam games</title>
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
                echo "<a href='" . $data2->profileurl . "'><img src='" . $data2->avatar . "' class='img-circle' width='122' height='122'></a>";
                echo "<h1 class='friends'><a href='" . $data2->profileurl . "'>" . $data2->name . "</a></h1>";
                echo "<h3 class='friends'>Steam games</h3>";
                echo "<table class='table table-hover table-responsive' id='stats'>";
                echo "<thead><th class='details-tb'>Logo</th>";
                echo "<th class='details-tb'>Game</th>";
                echo "<th class='details-tb'>Played</th></thead>";
                foreach ($data['gameslist'] as $theentity2) {
                    $appid = $theentity2['gameid'];
                    $name = $theentity2['game'];
                    $logo = $theentity2['logo'];
                    $playtime = $theentity2['playtime'];
                    $playtimec = $theentity2['playtimec'];
                    $playtime2weeks = $theentity2['playtime2weeksc'];
                    echo "<tr>";
                    echo "<td><a href='http://steamcommunity.com/app/$appid' title=$name><img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/" . $appid . "/" . $logo . ".jpg' class='img-rounded table-img img-responsive'></a></td>";
                    echo "<td><p class='details-tb'>$name</p></td>";
                    echo "<td><p class='details-tb'>$playtime</p></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                ?>
            </div>
        </div>
        <div class="col-lg-3">
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript' src='tablesorter.min.js'></script>
<script>
    $(document).ready(function () {
        $("#stats").tablesorter();
    });
</script>
</body>
</html>