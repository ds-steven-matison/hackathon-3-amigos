
<?php
//prepares the app based on environment variables
//print_r($_SERVER);

include "env.php";

function adjustBrightness($hexCode, $adjustPercent) {
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as & $color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hackathon 3-Amigos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
        body { background-color: <?php echo adjustBrightness($APP_COLOR,.7); ?> }
        .wrapper{ padding: 20px; }
        .topStrip { background-color: black; width: 100%; heigh: 50px; color: white; padding:10px }
        #showCard { border: 5px solid black; background-color: black; }
        .image1{ width: 400px; }
        .image2-3{ width: 202px; height: 225px; }
        .fingerprint{ width: 79px; height: 132px; padding: 2px;}
        .signature{ width: 809px; }
        .submit { width: 809px; }
        .hidden { display:none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include $startpage; ?>
    </div>    
    <div class="wrapper">
        <div id="GHP_counter"></div>
    </div>    
</body>
<!-- end GHP Counter -->
<div id="GHP_counter"></div>
<script type="text/javascript">
var GHP_siteid='hackathon-3-amigos';
var GHP_url = ("https:" == document.location.protocol ? "https://" : "http://") + "ghptracker.site/counter/?siteid=" + GHP_siteid;
var GHP_object = new XMLHttpRequest();
GHP_object.open("GET", GHP_url, false);
GHP_object.send(null);
var obj = JSON.parse(GHP_object.response);
document.getElementById("GHP_counter").innerHTML += '<img src="//img.shields.io/badge/views-' + obj.counter.value + '-blue">';
</script>
<!-- end GHP Counter -->
<script type="text/javascript">
  $(document).ready(function() {
      $('#saveCard').click(function(e){
        e.preventDefault();
        var action = "saveCard";
        $.ajax({
            type: "POST",
            url: "/api/",
            dataType: "json",
            data: {action:action},
            success : function(data){
                if (data.code == "200"){
                    alert("Success: " +data.msg);
                } else {
                    $(".display-error").html("<ul>"+data.msg+"</ul>");
                    $(".display-error").css("display","block");
                }
            }
        });
      });
  });
</script>

<!-- start GHP Listener -->
<script type="text/javascript">
var GHP_siteid='hackathon-3-amigos'; 
var GHP_refer = encodeURIComponent(document.referrer);
var GHP_url = encodeURIComponent(document.URL);
var ghpscript_url = ("https:" == document.location.protocol ? "https://" : "http://") + "ghptracker.site/track/" + "?siteid=" + GHP_siteid + "&refer=" + GHP_refer + "&url=" + GHP_url;
var GHP_object = new XMLHttpRequest();
GHP_object.open("GET", ghpscript_url, false);
GHP_object.send(null);
</script>
<!-- end GHP Listener -->
</html>