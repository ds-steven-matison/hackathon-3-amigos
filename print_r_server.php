<?php print_r($_SERVER); 

# also used script to debug
echo dirname(realpath('.'))."/html/env.php";
echo "KEYSPACE: ".$_SERVER['KEYSPACE'];
$ip = getenv('REMOTE_ADDR');
echo "IP: ". $ip;
exit();
?>