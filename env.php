<?php

$KEYSPACE = $_SERVER['KEYSPACE'];
$K8S_USERNAME = $_SERVER['K8S_USERNAME'];
$K8S_PASSWORD = $_SERVER['K8S_PASSWORD'];
$K8S_AUTH_URL = $_SERVER['K8S_AUTH_URL'];
$STARGATE_URL = $_SERVER['STARGATE_URL'];
$GRAPHQL_URL = $_SERVER['GRAPHQL_URL'];
$NIFI_URL = $_SERVER['NIFI_URL'];
$PULSAR_SERVICE_URL = $_SERVER['PULSAR_SERVICE_URL'];
$PULSAR_TOKEN = $_SERVER['PULSAR_TOKEN']; 
$ASTRA_TOKEN = $_SERVER['ASTRA_TOKEN'];
$APP_COLOR = $_SERVER['APP_COLOR'];
$APP_R = $_SERVER['APP_R'];
$APP_G = $_SERVER['APP_G'];
$APP_B = $_SERVER['APP_B'];

// lets do some basic logic
if($NIFI_URL != '${NIFI_URL}') { // this is APP DC1
    $STARGATE_URL = $NIFI_URL;
    // startpage should be WRITE DATA VIEW
    $startpage = "start_write.php";
} else if ($ASTRA_TOKEN == '${ASTRA_TOKEN}') { // this is APP DC2
    // startpage should be READ DATA VIEW
    $startpage = "start_read.php";
    // this is for APP DC2
    // this ENV should be able to READ DATA from stargate/cassandra/dse
} else { // this is APP GCP
    // startpage should be READ DATA VIEW
    $startpage = "start_read.php";
}
?>