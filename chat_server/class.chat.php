<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/inc/class/KufurFiltresi/Filter.php';
error_reporting(0);
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface {
	private $clients = [];
	private $dbh;
	private $auth;
	private $users = array();
    private $bans = array();
    private $spamBanTime = 30;
    private $spamTimeLimit = 5;
    private $spamMessageLimit = 10;
    private $filter;
    private $colors = array(
	    "#f44336",
        "#E91E63",
        "#9C27B0",
        "#673AB7",
        "#3F51B5",
        "#2196F3",
        "#00BCD4",
        "#009688",
        "#4CAF50",
        "#CDDC39",
        "#FFC107",
        "#FF9800",
        "#FF5722"
    );

	
	public function __construct() {
        global $dbh, $auth;
        $this->dbh 		= $dbh;
        $this->auth     = $auth;
        $this->filter   = new Filter();
    }
	
	public function onOpen(ConnectionInterface $conn) {
		$this->clients[$conn->resourceId] = $conn;
	}

	public function onMessage(ConnectionInterface $conn, $data) {

		$data = json_decode($data, true);

		if(isset($data['data']) && count($data['data']) != 0){

			$type = $data['type'];
			$user = isset($this->users[$conn->resourceId]) ? $this->users[$conn->resourceId]['name'] : false;

			switch($type){

                case "register":
                    $this->registerUser($conn, $data);
                break;

                case "chat_message":
                    $this->chatMessage($conn, $data, $user, false);
                break;

                case "chat_message_img":
                    $this->chatMessage($conn, $data, $user, true);
                    break;

                case "fetch":
                    $this->fetchMessages($conn);
                break;

                case"message_delete":
                    $this->deleteMessage($conn,$data);
                break;

                case "ban_user":
                    $this->banUserManuel($conn, $data);
                break;

                default:
                    return null;
                break;
            }

		}

	}

    public function onClose(ConnectionInterface $conn) {
        if( isset($this->users[$conn->resourceId]) ){
            unset($this->users[$conn->resourceId]);
        }
        if( isset($this->clients[$conn->resourceId]) ){
            unset($this->clients[$conn->resourceId]);
        }

        //Check online status for users
        $this->checkOnliners($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    /* My custom functions */
    private function registerUser($conn, $data){
        $name = $this->filter->setText(htmlspecialchars($data['data']['name']))->replace();
        $color = isset($data['data']['color'])? $data['data']['color'] : $this->randomColor();
        $isAdmin = isset($data['data']['session_hash'])? $this->auth->checkSessionSimple($data["data"]["session_hash"]) : 0;

        $this->users[$conn->resourceId] = array(
            "resource_id" => $conn->resourceId,
            "ip" => $conn->remoteAddress,
            "is_admin" => $isAdmin,
            "name" 	=> $name,
            "color" => $color
        );

        if($this->users[$conn->resourceId]["is_admin"]){
            //Load previous messages for admin
            $this->send($conn, "fetch", $this->getSqlMessages($conn));
        }
        $this->checkOnliners($conn);
        $this->isBanned($conn);
    }

    private  function chatMessage($conn, $data, $user, $with_image){
        if($this->isSpam($conn)){return;}

        $msg = htmlspecialchars($data['data']['msg']);
        $msg_filtered = $this->filter->setText($msg)->replace();
        $user_color = $this->users[$conn->resourceId]['color'];
        $user_ip = $this->users[$conn->resourceId]['ip'];
        $uniqid = uniqid();

        try{
            $sql = $this->dbh->prepare("INSERT INTO `chat_log` (`ip` , `uniqid`, `with_image`, `name`, `color`, `msg`) VALUES(?, ?, ?, ?, ?, ?)");
            $sql->execute(array($user_ip,$uniqid, ($with_image?1:0),$user, $user_color, $msg));
            $id = $this->dbh->lastInsertId();
            $send_type = "single";

            $img_array = array();
            if($with_image){
                $send_type = "single_with_image";
                foreach ($data["data"]["images"] as $value){
                    $sql = $this->dbh->prepare("UPDATE `chat_images` SET message_id = :id WHERE id = :img_id");
                    $sql->execute(array(
                        "id" => $id,
                        "img_id" => $value["img_id"]
                    ));
                    array_push($img_array, $value["img_path"]);
                }

            }

            foreach ($this->clients as $client => $conn) {
                $msg_tosend = $msg_filtered;
                if($this->users[$conn->resourceId]["is_admin"]){
                    $msg_tosend = $msg;
                }
                $this->send($conn, $send_type, array("uniqid" => $uniqid, "name" => $user, "color" => $user_color, "message" => $msg_tosend, "date" => date("Y-m-d H:i:s"), "images" => $img_array));
            }

        }catch (PDOException $e){
            $this->sendError($conn, "Mesaj veritabanına işlenemedi: ".$e->getMessage());
        }
    }

    private function deleteMessage($conn, $data){
        if(!$this->users[$conn->resourceId]["is_admin"]){
            $this->send($conn,"message_delete_error",array("message" => "User Not Authorized"));
            return;
        }

        try{
            $sql = $this->dbh->prepare("DELETE FROM `chat_log` WHERE `chat_log`.`uniqid` = ?");
            $sql->execute(array($data["data"]["id"]));
            foreach ($this->clients as $client => $conn) {
                $this->send($conn, "message_delete", array("id" => $data["data"]["id"]));
            }
        }catch (PDOException $e){
            $this->sendError($conn,"Mesaj silinemedi:". $e->getMessage());
        }
    }

    private function banUserManuel($conn, $data){
        if(!$this->users[$conn->resourceId]["is_admin"]){
            $this->send($conn,"ban_user_error",array("message" => "User Not Authorized"));
            return;
        }
        $this->banUser($data["data"]["resource_id"], $data["data"]["resource_id"], $data["data"]["time"]);
        $this->send($conn, "ban_user_success", array());
    }

    private function banUser($u_id, $ip, $ban_time){
        $ban_deadline = ($ban_time == 0 ) ? 0 : time() + $ban_time;
        $this->bans[$ip] = $ban_deadline;
        $ban_deadline_date = ($ban_deadline == 0 )? "sınırsız" : date("G:i:s",$ban_deadline);
        $this->send($this->clients[$u_id], "ban_user", array("deadline" => $ban_deadline, "deadline_date" => $ban_deadline_date));
    }

    private function isBanned($conn){

	    if($this->users[$conn->resourceId]["is_admin"]){return false;}

        if(array_key_exists($conn->remoteAddress,$this->bans)){
            $ban_deadline = $this->bans[$conn->remoteAddress];

            if($ban_deadline <= time()){
                unset($this->bans[$conn->remoteAddress]);
                return false;
            }

            $ban_deadline_date = ($ban_deadline == 0 )? "sınırsız" : date("G:i:s d/m/Y",$ban_deadline);
            $this->send($conn, "ban_user", array("deadline" => $ban_deadline, "deadline_date" => $ban_deadline_date));
            return true;
        }

        return false;
    }

    private function isSpam($conn){

        if($this->users[$conn->resourceId]["is_admin"]){return false;}
        if($this->isBanned($conn)){return true;}


        try{
            $sql = $this->dbh->prepare("SELECT * FROM `chat_log` WHERE `ip` = :ip AND DATE_SUB(now(), INTERVAL :spamtimelimit SECOND) < date ");
            $sql->execute(array(
                "ip"=>$conn->remoteAddress,
                "spamtimelimit" => $this->spamTimeLimit
            ));
            if($sql->rowCount() >= $this->spamMessageLimit){
                $this->banUser($conn->resourceId, $conn->remoteAddress, $this->spamBanTime);
                return true;
            }
            return false;
        }catch(PDOException $e){
            $this->sendError($conn, $e->getMessage());
            return false;
        }
    }

    private function fetchMessages($conn){
        if(!$this->users[$conn->resourceId]["is_admin"]){
            $this->sendError($conn, "User Not Authorized");
            return;
        }

        $this->checkOnliners($conn);
        $this->send($conn, "fetch", $this->getSqlMessages());
	}

	private function getSqlMessages($conn){
        try{
            $sql = $this->dbh->query("SELECT * FROM `chat_log`");
            $msgs = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($msgs as $key => $value){
                if($value["with_img"] == "1"){
                    $sql1 = $this->dbh->query("SELECT * FROM `chat_images` WHERE message_id=".$value["id"]);
                    $imgs = $sql1->fetchAll(PDO::FETCH_ASSOC);
                    $images_array = array();
                    foreach ( $imgs as $value1){
                        array_push($images_array,$value1["name"]);
                    }
                    $msgs[$key]["images"] = $images_array;
                }
            }
            return $msgs;
        }catch (PDOException $e){
            $this->sendError($conn, $e->getMessage());
            return null;
        }
    }

    private function checkOnliners($logged){
	    /* Send online users to everyone */
		$data = $this->users;
		if(!$logged){
		    unset($data["ip"]);
		    unset($data["is_admin"]);
        }
		foreach ($this->clients as $client => $conn) {
			$this->send($conn, "onliners", $data);
		}
	}

    private function send($client, $type, $data){
		$send = array(
			"type" => $type,
			"data" => $data
		);
		$send = json_encode($send, true);
		$client->send($send);
	}

	private function sendError($conn, $msg){
        $this->send($conn,"error",array("message" => $msg));
    }

    private function randomColor(){
	    return $this->colors[array_rand($this->colors)];
    }
}
?>