<?php
define('HOST_NAME',"localhost"); 
define('PORT',"8090");
$null = NULL;

require_once("class.chathandler.php");
$chatHandler = new ChatHandler();

$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socketResource, 0, PORT);
socket_listen($socketResource);

$clientSocketArray = array($socketResource);
while (true) {
	$newSocketArray = $clientSocketArray;
	socket_select($newSocketArray, $null, $null, 0, 10);
	
	if (in_array($socketResource, $newSocketArray)) {
		$newSocket = socket_accept($socketResource);
		$clientSocketArray[] = $newSocket;
		
		$header = socket_read($newSocket, 1024);
		$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);

		$newSocketIndex = array_search($socketResource, $newSocketArray);
		unset($newSocketArray[$newSocketIndex]);
	}
	
	foreach ($newSocketArray as $newSocketArrayResource) {	
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			$socketMessage = $chatHandler->unseal($socketData);
			$messageObj = json_decode($socketMessage ,true);

			if($messageObj["data_type"] == "user_joined"){
                $chat_box_message = $chatHandler->newConnectionACK($messageObj["chat_user"]);
                $chatHandler->send($chat_box_message);
                break;
            }

            if($messageObj["data_type"] == "message"){
                $chat_box_message = $chatHandler->createChatBoxMessage($messageObj["chat_user"], $messageObj["chat_message"]);
                $chatHandler->send($chat_box_message);
                break;
            }


		}
	}
}
socket_close($socketResource);