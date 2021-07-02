<?php
// .env variables for credentials are also mapped in www.conf
$KEYSPACE = getenv('KEYSPACE');
$K8S_USERNAME = getenv('K8S_USERNAME');
$K8S_PASSWORD = getenv('K8S_PASSWORD');
$K8S_AUTH_URL = getenv('K8S_AUTH_URL');
$STARGATE_URL = getenv('STARGATE_URL');
$GRAPHQL_URL = getenv('GRAPHQL_URL');
?>