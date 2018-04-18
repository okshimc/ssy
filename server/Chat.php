<?php
// ① 초기 설정
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// ② 클래스를 정의한다
class Chat implements MessageComponentInterface {
 
 private $clients;
 
 // ③ 생성자
 public function __construct(){
  $this->clients = new SplObjectStorage();
 }
 // ④ 접속되었을 때의 처리 내용
 public function onOpen(ConnectionInterface $conn){
  print "onOpen....\n";
  $this->clients->attach($conn);
 }
 // ⑤ 메시지가 전송되었을 때의 처리 내용
 public function onMessage(ConnectionInterface $from, $msg){
  print "onMessage [" . mb_convert_encoding($msg,"EUC-KR","UTF-8")."]\n";
  foreach($this->clients as $client){
   if($client != $from){
    $item = array(
      'type' => 'recv',
      'message' => $msg
    );
   }
   else{
    $item = array(
      'type' => 'send',
      'message' => $msg
    );
   }
   $client->send(json_encode($item));
  }
 }
 // ⑥ 접속 에러가 발생했을 때의 처리 내용
 public function onError(ConnectionInterface $conn, Exception $e){
  print "onError....\n";
  $this->clients->detach($conn);
 }

 // ⑦ 접속이 끊겼을 때의 처리 내용
 public function onClose(ConnectionInterface $conn){
  print "onClose \n";
  $this->clients->detach($conn);
 }
}

?>