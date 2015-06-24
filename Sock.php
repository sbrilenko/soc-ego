<?php
$config=dirname(__FILE__).'/protected/config/main.php';
require_once(dirname(__FILE__).'/../yii/framework/yii.php');
Yii::createWebApplication($config);
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
date_default_timezone_set('America/Los_Angeles');
class Sock implements MessageComponentInterface {
    protected $clients;
    protected $all_clients;
    public function __construct() {
        set_time_limit(0);
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $tst_msg = json_decode($msg); //json decode
        if ($tst_msg) {
            // decoded object
            $type = $tst_msg->type;
            switch ($type) {
                case 'system.init_user_online':
                    $user=null;
                    try{
                        $user=User::model()->findByPk($tst_msg->from_user_id);
                    }
                    catch(\Exception $e)
                    {
                        Yii::app()->db->setActive(false);
                        Yii::app()->db->setActive(true);
                        $user=User::model()->findByPk($tst_msg->from_user_id);
                    }
                    if($user)
                    {
                        $from->user_id=$user->id;
                        $this->all_clients[]=$from;
                        $response_arr = array(
                            'type' => 'system.init_user_online',
                            'user_id' => $user->id,
                            'message' =>' is online'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$user->id)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    break;
                case 'system.message':
                    $data=$tst_msg->data;
                    $from_user=$to_user=null;
                    $text="";
                    foreach($data as $d)
                    {
                        if($d->name=='Message[from_user_id]') $from_user=$d->value;
                        elseif($d->name=='Message[to_user_id]') $to_user=$d->value;
                        elseif($d->name=='Message[message]') $text=$d->value;
                    }
                    $from_user=trim($from_user);
                    $to_user=trim($to_user);
                    $text=trim($text);
                    if(empty($from_user) || !User::model()->findByPk($from_user))
                    {
                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'User that send do not exists'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id=$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    elseif(empty($to_user) || !User::model()->findByPk($to_user))
                    {
                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'Please choose the user'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    elseif(empty($text))
                    {
                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'Message cannot be empty'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    $message=new Message();
                    $message->timestamp=strtotime(date('Y-m-d H:i:s'));
                    $message->from_user_id=$from_user;
                    $message->to_user_id=$to_user;
                    $message->message=$text;
                    $message->message_read=0;
                    $message->answered=0;
                    $message->draft=0;
                    if($message->save())
                    {
                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>false,
                            'from_name' => Profile::model()->getName($from_user),
                            'from' => $from_user,
                            'to'=>$to_user,
                            'to_name' => Profile::model()->getName($to_user),
                            'date'=>date('H:i',$message->timestamp),
                            'message' =>$text,
                            'count'=>Message::model()->notReadMessage($from_user,$to_user)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }

                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>false,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'date'=>date('H:i',$message->timestamp),
                            'message' =>$text,
                            'count'=>Message::model()->notReadMessage($to_user,$from_user)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$to_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    else
                    {
                        $response_arr = array(
                            'type' => 'system.message',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>print_r($message->getErrors(),true)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    break;
                case 'system.quickmessage':
                    $data=$tst_msg->data;
                    $from_user=$to_user=null;
                    $text="";
                    foreach($data as $d)
                    {
                        if($d->name=='from_user') $from_user=$d->value;
                        elseif($d->name=='to_user') $to_user=$d->value;
                        elseif($d->name=='text') $text=$d->value;
                    }
                    $from_user=trim($from_user);
                    $to_user=trim($to_user);
                    $text=trim($text);
                    if(empty($from_user) || !User::model()->findByPk($from_user))
                    {
                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'User that send do not exists'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id=$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    elseif(empty($to_user) || !User::model()->findByPk($to_user))
                    {
                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'Please choose the user'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    elseif(empty($text))
                    {
                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>'Message cannot be empty'
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    $message=new Message();
                    $message->timestamp=strtotime(date('Y-m-d H:i:s'));
                    $message->from_user_id=$from_user;
                    $message->to_user_id=$to_user;
                    $message->message=$text;
                    $message->message_read=0;
                    $message->answered=0;
                    $message->draft=0;
                    if($message->save())
                    {
                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>false,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'date'=>date('H:i',$message->timestamp),
                            'message' =>$text,
                            'count'=>Message::model()->notReadMessage($from_user,$to_user)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }

                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>false,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'date'=>date('H:i',$message->timestamp),
                            'message' =>$text,
                            'count'=>Message::model()->notReadMessage($to_user,$from_user)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$to_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    else
                    {
                        $response_arr = array(
                            'type' => 'system.quickmessage',
                            'error'=>true,
                            'from' => $from_user,
                            'to'=>$to_user,
                            'message' =>print_r($message->getErrors(),true)
                        );
                        foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$from_user)
                            {
                                $cli->send(json_encode($response_arr));
                            }
                        }
                    }
                    break;
                case 'system.friendmessage':
                    
                    // TODO: Add message validation.

                    $send_to = $tst_msg->send_to;
                    foreach($this->all_clients as $cli)
                        {
                            if($cli->user_id==$send_to)
                            {
                                $cli->send(json_encode($tst_msg));
                            }
                        }
                    break;
            }
        }
        $numRecv = count($this->clients) - 1;
        //echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        /*foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }*/
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}