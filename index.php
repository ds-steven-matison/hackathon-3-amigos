
<?php
//prepares the app based on environment variables
//print_r($_SERVER);

include "env.php";

// lets do some basic logic
if($NIFI_URL != '') { // this is APP DC1
    $STARGATE_URL = $NIFI_URL;
    // startpage should be WRITE DATE VIEW
    $startpage = "start_write.php";
} else if ($ASTRA_TOKEN == '') { // this is APP DC2
    // startpage should be READ DATA VIEW
    $startpage = "start_read.php";
    // this is for APP DC2

} else { // this is APP GCP
    // startpage should be READ DATA VIEW
    $startpage = "start_read.php";
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
        .wrapper{ padding: 20px; }
        .image1{ width: 400px; }
        .image2-3{ width: 202px; height: 225px; }
        .fingerprint{ width: 79px; height: 132px; padding: 2px;}
        .signature{ width: 809px; }
        .submit { width: 809px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include $startpage; ?>
    </div>    
</body>
<script type="text/javascript">
  $(document).ready(function() {
      $('#saveVoter').click(function(e){
        e.preventDefault();
        var action = "saveVoter";
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
</html>