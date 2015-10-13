<?php
//$config=dirname(__FILE__).'/protected/config/main.php';
//require_once(dirname(__FILE__).'/../yii/framework/yii.php');
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
//date_default_timezone_set('America/Los_Angeles');
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
                    require_once(realpath(dirname(__FILE__).'/../yii/framework/yii.php'));
                    if(!Yii::app())
                    {
                        Yii::createWebApplication(dirname(__FILE__).'/protected/config/main.php');
                    }
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

                case 'system.bemyfriend':

                    try{
                        $user=User::model()->findByPk($tst_msg->from);
                    }
                    catch(\Exception $e)
                    {
                        Yii::app()->db->setActive(false);
                        Yii::app()->db->setActive(true);
                        $user=User::model()->findByPk($tst_msg->from);
                    }
                    $iftoexists=User::model()->findByPk($tst_msg->to);
                    if($user && $iftoexists)
                    {
                        $friendship=new Friendship();
                        $friendship->inviter_id=$tst_msg->from;
                        $friendship->friend_id=$tst_msg->to;
                        $friendship->status=0;
                        $friendship->acknowledgetime=0;
                        $friendship->requesttime=time();
                        $friendship->updatetime=0;
                        $friendship->message=$user->profile->firstname.' '.$user->profile->lastname.' wants add you to friends';
                        if($friendship->save())
                        {
                            $ccc = new CController('friendship');
                            $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($tst_msg->to);
                            $friendrequest=array();
                            for($i=0;$i<count($currusernotinviter);$i++)
                            {
                                $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                            }
                            $html = $ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true);
                            /*to friend*/
                            $response_arr = array(
                                'type' => 'system.bemyfriend',
                                'error'=>false,
                                'from' => $tst_msg->from,
                                'to'=>$tst_msg->to,
                                'inviterimage'=>Profile::model()->getLittleAvatar($user->id,'f-l friend-little-avatar'),
                                'inviterfullname'=>htmlspecialchars($user->profile->firstname).' '.htmlspecialchars($user->profile->lastname),
                                'inviterjobtitle'=>Profile::model()->jobTitle($user->id),
                                'message' =>$user->profile->firstname.' '.$user->profile->lastname.' wants add you to friends',
                                'html'=>$html
                            );
                            foreach($this->all_clients as $cli)
                            {
                                if($cli->user_id==$tst_msg->to)
                                {
                                    $cli->send(json_encode($response_arr));
                                }
                            }
                            /*to inviter*/
                            $response_arr = array(
                                'type' => 'system.bemyfriend',
                                'error'=>false,
                                'from' => $tst_msg->from,
                                'to'=>$tst_msg->to,
                                'message' =>'We sent request to '.$iftoexists->profile->firstname.' '.$iftoexists->profile->lastname
                            );
                            foreach($this->all_clients as $cli)
                            {
                                if($cli->user_id==$tst_msg->from)
                                {
                                    $cli->send(json_encode($response_arr));
                                }
                            }
                        }
                        else
                        {
                            /*to inviter*/
                            $response_arr = array(
                                'type' => 'system.bemyfriend',
                                'error'=>false,
                                'from' => $tst_msg->from,
                                'to'=>$tst_msg->to,
                                'message' =>'We doe\'s sent request to '.$iftoexists->profile->firstname.' '.$iftoexists->profile->lastname.'. Sorry!'
                            );
                            foreach($this->all_clients as $cli)
                            {
                                if($cli->user_id==$tst_msg->from)
                                {
                                    $cli->send(json_encode($response_arr));
                                }
                            }
                        }

                    }
                    break;
                    case 'system.addtofriends':
                        try{
                            $user=User::model()->findByPk($tst_msg->from);
                        }
                        catch(\Exception $e)
                        {
                            Yii::app()->db->setActive(false);
                            Yii::app()->db->setActive(true);
                            $user=User::model()->findByPk($tst_msg->from);
                        }
                        if(isset($tst_msg->to))
                        {
                            $iftoexists=User::model()->findByPk($tst_msg->to);
                            if($user && $iftoexists)
                            {
                                /*let's find this record in friendship table*/
                                $friendrequest=Friendship::model()->findByAttributes(array('inviter_id'=>$tst_msg->to,'friend_id'=>$tst_msg->from));
                                if($friendrequest)
                                {
                                    /*add this user to friend*/
                                    /*check if this record exist*/
                                    $indfriend=UserFriend::model()->findByAttributes(array('user_id'=>$tst_msg->from,'friend_id'=>$tst_msg->to));
                                    if(!$indfriend)
                                    {
                                        $newfriend=new UserFriend();
                                        $newfriend->user_id=$tst_msg->from;
                                        $newfriend->friend_id=$tst_msg->to;

                                        $friendind=UserFriend::model()->findByAttributes(array('user_id'=>$tst_msg->to,'friend_id'=>$tst_msg->from));
                                        if(!$friendind)
                                        {
                                            $newfriendoth=new UserFriend();
                                            $newfriendoth->user_id=$tst_msg->to;
                                            $newfriendoth->friend_id=$tst_msg->from;
                                            if($newfriend->save() && $newfriendoth->save())
                                            {
                                                /*and remove from friendship table*/
                                                $friendrequest->status = 1;
                                                $friendrequest->update();

                                                $message=new Message();
                                                $message->timestamp=strtotime(date('Y-m-d H:i:s'));
                                                $message->from_user_id=$tst_msg->from;
                                                $message->to_user_id=$tst_msg->to;
                                                $message->message='Hello! I added you to my friends list! =)';
                                                $message->message_read=0;
                                                $message->answered=0;
                                                $message->draft=0;
                                                $message->save();

                                                $ccc = new CController('friendship');
                                                $friends = $user->getFriendsList();
                                                $allusers=User::model()->findAllUsersWithout(array($user->id));
                                                $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($user->id);
                                                $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                                $friendrequest=array();
                                                for($i=0;$i<count($currusernotinviter);$i++)
                                                {
                                                    $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                                }
                                                $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                                $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                                $friendrequest=array();
                                                for($i=0;$i<count($currusernotinviter);$i++)
                                                {
                                                    $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                                }


                                                /*to me*/
                                                // $response_arr = array(
                                                //     'type' => 'system.addtofriends',
                                                //     'error'=>false,
                                                //     'from' => $tst_msg->from,
                                                //     'to'=>$tst_msg->to,
                                                //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                                //             'friends'=>$sortedfriend,
                                                //             'curruserinviter'=>$curruserinviter,
                                                //             'currusernotinviter'=>$currusernotinviter),true),
                                                //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                                //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                                //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)
                                                // );
                                                $response_arr = array(
                                                    'type' => 'system.addtofriends',
                                                    'error'=>false,
                                                    'from' => $tst_msg->from,
                                                    'to'=>$tst_msg->to,
                                                );
                                                foreach($this->all_clients as $cli)
                                                {
                                                    if($cli->user_id==$tst_msg->from || $cli->user_id==$tst_msg->to)
                                                    {
                                                        $cli->send(json_encode($response_arr));
                                                    }
                                                }

                                                /*to inviter*/

                                                // $friends = $iftoexists->getFriendsList();
                                                // $allusers=User::model()->findAllUsersWithout(array($iftoexists->id));
                                                // $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($iftoexists->id);
                                                // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                                // $friendrequest=array();
                                                // for($i=0;$i<count($currusernotinviter);$i++)
                                                // {
                                                //     $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                                // }
                                                // $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                                // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                                // $friendrequest=array();
                                                // for($i=0;$i<count($currusernotinviter);$i++)
                                                // {
                                                //     $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                                // }
                                                // $response_arr = array(
                                                //     'type' => 'system.addtofriends',
                                                //     'error'=>false,
                                                //     'from' => $tst_msg->from,
                                                //     'to'=>$tst_msg->to,
                                                //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                                //             'friends'=>$sortedfriend,
                                                //             'curruserinviter'=>$curruserinviter,
                                                //             'currusernotinviter'=>$currusernotinviter),true),
                                                //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                                //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                                //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)

                                                // );
                                                // foreach($this->all_clients as $cli)
                                                // {
                                                //     if($cli->user_id==$tst_msg->to)
                                                //     {
                                                //         $cli->send(json_encode($response_arr));
                                                //     }
                                                // }
                                            }
                                        }

                                    }
                                }
                            }
                        }

                        break;
                        case 'system.frienddecline':
                            try{
                                $user=User::model()->findByPk($tst_msg->from);
                            }
                            catch(\Exception $e)
                            {
                                Yii::app()->db->setActive(false);
                                Yii::app()->db->setActive(true);
                                $user=User::model()->findByPk($tst_msg->from);
                            }
                            if(isset($tst_msg->to))
                            {
                                $iftoexists=User::model()->findByPk($tst_msg->to);
                                if($user && $iftoexists)
                                {
                                    /*let's find this record in friendship table*/
                                    $friendrequest=Friendship::model()->findByAttributes(array('inviter_id'=>$tst_msg->to,'friend_id'=>$tst_msg->from));
                                    if($friendrequest)
                                    {
                                            /*and remove from friendship table*/
                                            $friendrequest->delete();
                                            $ccc = new CController('friendship');
                                            $friends = $user->getFriendsList();
                                            $allusers=User::model()->findAllUsersWithout(array($user->id));
                                            $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($user->id);
                                            $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                            $friendrequest=array();
                                            for($i=0;$i<count($currusernotinviter);$i++)
                                            {
                                                $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                            }
                                            $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                            $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                            $friendrequest=array();
                                            for($i=0;$i<count($currusernotinviter);$i++)
                                            {
                                                $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                            }


                                            /*to me*/
                                            // $response_arr = array(
                                            //     'type' => 'system.addtofriends',
                                            //     'error'=>false,
                                            //     'from' => $tst_msg->from,
                                            //     'to'=>$tst_msg->to,
                                            //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                            //             'friends'=>$sortedfriend,
                                            //             'curruserinviter'=>$curruserinviter,
                                            //             'currusernotinviter'=>$currusernotinviter),true),
                                            //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                            //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                            //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)
                                            // );
                                            $response_arr = array(
                                                'type' => 'system.frienddecline',
                                                'error'=>false,
                                                'from' => $tst_msg->from,
                                                'to'=>$tst_msg->to,
                                            );
                                            foreach($this->all_clients as $cli)
                                            {
                                                if($cli->user_id==$tst_msg->from || $cli->user_id==$tst_msg->to)
                                                {
                                                    $cli->send(json_encode($response_arr));
                                                }
                                            }

                                            /*to inviter*/

                                            // $friends = $iftoexists->getFriendsList();
                                            // $allusers=User::model()->findAllUsersWithout(array($iftoexists->id));
                                            // $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($iftoexists->id);
                                            // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                            // $friendrequest=array();
                                            // for($i=0;$i<count($currusernotinviter);$i++)
                                            // {
                                            //     $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                            // }
                                            // $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                            // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                            // $friendrequest=array();
                                            // for($i=0;$i<count($currusernotinviter);$i++)
                                            // {
                                            //     $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                            // }
                                            // $response_arr = array(
                                            //     'type' => 'system.addtofriends',
                                            //     'error'=>false,
                                            //     'from' => $tst_msg->from,
                                            //     'to'=>$tst_msg->to,
                                            //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                            //             'friends'=>$sortedfriend,
                                            //             'curruserinviter'=>$curruserinviter,
                                            //             'currusernotinviter'=>$currusernotinviter),true),
                                            //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                            //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                            //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)

                                            // );
                                            // foreach($this->all_clients as $cli)
                                            // {
                                            //     if($cli->user_id==$tst_msg->to)
                                            //     {
                                            //         $cli->send(json_encode($response_arr));
                                            //     }
                                            // }
                                    }
                                }
                            }
                        break;
                    case 'system.removefromfriends':

                        try{
                            $user=User::model()->findByPk($tst_msg->from);
                        }
                        catch(\Exception $e)
                        {
                            Yii::app()->db->setActive(false);
                            Yii::app()->db->setActive(true);
                            $user=User::model()->findByPk($tst_msg->from);
                        }
                        if(isset($tst_msg->to))
                        {
                            $iftoexists=User::model()->findByPk($tst_msg->to);
                            if($user && $iftoexists)
                            {
                                    /*check if this record exist*/
                                    $indfriend=UserFriend::model()->findByAttributes(array('user_id'=>$tst_msg->from,'friend_id'=>$tst_msg->to));
                                    if($indfriend)
                                    {
                                        $indfriend->delete();
                                    }
                                    $friendind=UserFriend::model()->findByAttributes(array('user_id'=>$tst_msg->to,'friend_id'=>$tst_msg->from));
                                    if($friendind)
                                    {
                                        $friendind->delete();
                                    }

                                    /*Try to delete old friend requests*/
                                    $friendrequest=Friendship::model()->findByAttributes(array('inviter_id'=>$tst_msg->to,'friend_id'=>$tst_msg->from));
                                    if($friendrequest)
                                    {
                                        $friendrequest->delete();
                                    }
                                    $friendrequest=Friendship::model()->findByAttributes(array('inviter_id'=>$tst_msg->from,'friend_id'=>$tst_msg->to));
                                    if($friendrequest)
                                    {
                                        $friendrequest->delete();
                                    }

                                    $ccc = new CController('friendship');
                                    $friends = $user->getFriendsList();
                                    $allusers=User::model()->findAllUsersWithout(array($user->id));
                                    $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($user->id);
                                    $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                    $friendrequest=array();
                                    for($i=0;$i<count($currusernotinviter);$i++)
                                    {
                                        $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                    }
                                    $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                    $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($user->id);
                                    $friendrequest=array();
                                    for($i=0;$i<count($currusernotinviter);$i++)
                                    {
                                        $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                    }


                                    /*to me*/
                                    // $response_arr = array(
                                    //     'type' => 'system.addtofriends',
                                    //     'error'=>false,
                                    //     'from' => $tst_msg->from,
                                    //     'to'=>$tst_msg->to,
                                    //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                    //             'friends'=>$sortedfriend,
                                    //             'curruserinviter'=>$curruserinviter,
                                    //             'currusernotinviter'=>$currusernotinviter),true),
                                    //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                    //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                    //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)
                                    // );

                                    $response_arr = array(
                                        'type' => 'system.removefromfriends',
                                        'error'=>false,
                                        'from' => $tst_msg->from,
                                        'to'=>$tst_msg->to,
                                    );

                                    foreach($this->all_clients as $cli)
                                    {
                                        if($cli->user_id==$tst_msg->from || $cli->user_id==$tst_msg->to)
                                        {
                                            $cli->send(json_encode($response_arr));
                                        }
                                    }

                                    /*to inviter*/

                                    // $friends = $iftoexists->getFriendsList();
                                    // $allusers=User::model()->findAllUsersWithout(array($iftoexists->id));
                                    // $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($iftoexists->id);
                                    // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                    // $friendrequest=array();
                                    // for($i=0;$i<count($currusernotinviter);$i++)
                                    // {
                                    //     $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
                                    // }
                                    // $sortedfriend=User::model()->sortFullNameByAlph($friends);

                                    // $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($iftoexists->id);
                                    // $friendrequest=array();
                                    // for($i=0;$i<count($currusernotinviter);$i++)
                                    // {
                                    //     $friendrequest[]=User::model()->findByAttributes(array('id'=>$currusernotinviter[$i]));
                                    // }
                                    // $response_arr = array(
                                    //     'type' => 'system.addtofriends',
                                    //     'error'=>false,
                                    //     'from' => $tst_msg->from,
                                    //     'to'=>$tst_msg->to,
                                    //     'allusershtml'=>$ccc->renderPartial('allusers',array( 'allusers'=>$allusers,
                                    //             'friends'=>$sortedfriend,
                                    //             'curruserinviter'=>$curruserinviter,
                                    //             'currusernotinviter'=>$currusernotinviter),true),
                                    //     'allfriendshtml'=>$ccc->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                    //     'requestshtml'=>$ccc->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                    //     'recenthtml'=>$ccc->renderPartial('recent',array('friends'=>$sortedfriend),true)

                                    // );
                                    // foreach($this->all_clients as $cli)
                                    // {
                                    //     if($cli->user_id==$tst_msg->to)
                                    //     {
                                    //         $cli->send(json_encode($response_arr));
                                    //     }
                                    // }
                            }
                        }
                    break;
            }
        }
        $numRecv = count($this->clients) - 1;
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