<?php
$steamid = $_GET['steamid'];
$data = json_decode(file_get_contents("" . $steamid . "_friends.json"), true);
$data2 = json_decode(file_get_contents("" . $steamid . ".json"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $data2->name; ?>'s steam friends</title>
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
                echo "<h3 class='friends'>Steam friends</h3>";
                echo "<table class='table table-hover table-responsive' id='stats'>";
                echo "<thead><th>Avatar</th>";
                echo "<th>Name</th>";
                echo "<th>Friends for</th></thead>";
                foreach ($data['data'] as $theentity3)
                {
                    $steamid = $theentity3['steamid'];
                    $friend_name =  $theentity3['friendname'];
                    $fsince = $theentity3['friendsince'];
                    $av = $theentity3['friendav'];
                    echo "<tr>";
                    echo "<td><a href='http://steamcommunity.com/profiles/$steamid' title=$friend_name><img src='$av' class='img-circle img-responsive  table-img' width='84' height='84'></a></td>";
                    echo "<td><p class='details-tb'>$friend_name</a></p></td>";
                    echo "<td><p class='details-tb'>$fsince</p></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
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
    $(document).ready(function() {
        $("#stats").tablesorter();
    });
</script>
</body>
</html>
