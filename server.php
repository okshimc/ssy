<?php
// ① 필요한 라이브러리를 가져온다.
require_once("./vendor/autoload.php");
require_once("./server/Chat.php");
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// ② 서버를 만든다.
$server = IoServer::factory(
  new HttpServer(
    new WsServer(
     new Chat()
    )
  ),
  8888
);
// ③ 서버를 시작한다.
$server->run();

?>