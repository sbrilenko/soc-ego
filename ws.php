<?php
date_default_timezone_set('America/Los_Angeles');
require dirname(__FILE__) . '/vendor/autoload.php';
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require 'Sock.php';

$server = IoServer::factory(
new HttpServer(
new WsServer(
new Sock()
)
),
1600
);

$server->run();