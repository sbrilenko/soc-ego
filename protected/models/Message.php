<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property string $id
 * @property string $timestamp
 * @property string $from_user_id
 * @property string $to_user_id
 * @property string $message
 * @property integer $message_read
 * @property integer $answered
 * @property integer $draft
 * @property integer $image
 */
class Message extends CActiveRecord
{
    public $full_name;
    public $pict;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('timestamp, from_user_id, to_user_id, message_read', 'required'),
            array('message_read, answered, draft', 'numerical', 'integerOnly'=>true),
            array('timestamp, from_user_id, to_user_id,image', 'length', 'max'=>10),
            array('message', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, timestamp, from_user_id, to_user_id, message, message_read, answered, draft', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'from_user_id' => 'From User',
            'to_user_id' => 'To User',
            'message' => 'Message',
            'message_read' => 'Message Read',
            'answered' => 'Answered',
            'draft' => 'Draft',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('timestamp',$this->timestamp,true);
        $criteria->compare('from_user_id',$this->from_user_id,true);
        $criteria->compare('to_user_id',$this->to_user_id,true);
        $criteria->compare('message',$this->message,true);
        $criteria->compare('message_read',$this->message_read);
        $criteria->compare('answered',$this->answered);
        $criteria->compare('draft',$this->draft);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getAllFriendsMessages($id)
    {
        $arr_id=array();
        $ret_message=array();
        $all_messages=$this->model()->findAllBySql("SELECT m.* FROM ".$this->tableName()." as m,".Friendship::model()->tableName()." as f WHERE (((f.inviter_id=".$id." and ((m.from_user_id=f.friend_id and m.to_user_id=".$id.") OR (m.to_user_id=f.friend_id and m.from_user_id=".$id."))) or (f.friend_id=".$id." and ((m.from_user_id=f.inviter_id and m.to_user_id=".$id.") OR (m.to_user_id=f.inviter_id and m.from_user_id=".$id.")))) AND f.status>0) ORDER BY m.timestamp DESC");
        foreach($all_messages as $message)
        {
            if($message->from_user_id==$id)
            {
                if(!in_array($message->to_user_id,$arr_id))
                {
                    $ret_message[]=$message;
                    $arr_id[]=$message->to_user_id;
                }
            }
            else
            {
                if(!in_array($message->from_user_id,$arr_id))
                {
                    $ret_message[]=$message;
                    $arr_id[]=$message->from_user_id;
                }
            }

        }
        return $ret_message;
    }
    /*get only need field*/

    public function messageStructure($array_message)
    {
        $ret=array();
        if(!empty($array_message))
        {
            foreach($array_message as $val)
            {
                $user_friends=$val->from_user_id==Yii::app()->user->id?Profile::model()->findByAttributes(array("user_id"=>$val->to_user_id)):Profile::model()->findByAttributes(array("user_id"=>$val->from_user_id));
                if($user_friends->avatar)
                {
                    $file_company=Files::model()->findByPk($user_friends->avatar);
                    if($file_company)
                    {
                        if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                        {
                            $icon="/files/".$file_company->image;
                        }
                        else
                        {
                            $icon="/img/default-user.png";
                        }
                    }
                    else
                    {
                        $icon="/img/default-user.png";
                    }
                }
                else
                {
                    $icon="/img/default-user.png";
                }

                /* Display date for non-today messages */
                if(date('Y:m:d',$val->timestamp) == date('Y:m:d')) {
                    $display_date = date('H:i',$val->timestamp);
                } else {
                    $display_date = date('d.m.y',$val->timestamp);
                }

                if (Yii::app()->user->id == $val->from_user_id) {
                    $from = $val->to_user_id;
                } else {
                    $from = $val->from_user_id;
                }
                $ret[]=array('count'=>Message::model()->notReadMessage($from, Yii::app()->user->id),'current_user_id'=>Yii::app()->user->id,'message_id'=>$val->id,'icon'=>$icon,'full_name'=>$user_friends->firstname." ".$user_friends->lastname, 'id'=>$from,'job_type'=>User::model()->getJobType($user_friends->id),'time'=>$display_date,'message'=>$val->message,'read'=>$val->message_read);
            }
        }
        return $ret;
    }
    /*count of not readable message*/
    public function notReadMessage($user_id,$dialog_user)
    {
        // $message=$this->model()->findAllBySql("SELECT m.* FROM ".$this->tableName()." as m,".Friendship::model()->tableName()." as f WHERE (((f.inviter_id=".$user_id." OR f.friend_id=".$user_id.") AND (f.inviter_id=".$dialog_user." OR f.friend_id=".$dialog_user.")) AND f.status>0) and ((m.from_user_id=".$user_id." OR m.to_user_id=".$user_id.") AND (m.from_user_id=".$dialog_user." OR m.to_user_id=".$dialog_user.")) AND m.message_read=0 ORDER BY m.timestamp DESC");
        $messages=$this->model()->findAll("from_user_id=:from_user_id AND to_user_id=:to_user_id AND message_read=:message_read",
                                         array(':from_user_id' => $user_id, ':to_user_id' => $dialog_user, ':message_read' => 0 ));
        return count($messages);
    }

    /*select all messages where to_user_id=Yii::app()->user->id*/
    public function getAllMessagesSendingToMe($user_id,$dialog_user)
    {
        return $this->model()->findAllBySql("SELECT m.* FROM ".$this->tableName()." as m,".Friendship::model()->tableName()." as f WHERE (((f.inviter_id=".$user_id." OR f.friend_id=".$user_id.") AND (f.inviter_id=".$dialog_user." OR f.friend_id=".$dialog_user.")) AND f.status>0) and ((m.from_user_id=".$user_id." OR m.to_user_id=".$user_id.") AND (m.from_user_id=".$dialog_user." OR m.to_user_id=".$dialog_user.")) ORDER BY m.timestamp ASC");
    }

    public function readMessages($sender, $reciever)
    {
        $messages=$this->model()->findAll("from_user_id=:from_user_id AND to_user_id=:to_user_id AND message_read=:message_read",
                                        array(':from_user_id' => $sender, ':to_user_id' => $reciever, ':message_read' => 0 ));
        foreach($messages as $message) {
            $this->model()->updateByPk($message->id, array('message_read'=>1));
        }
    }

    /*count of all not read messages for given user*/
    public function allNotReadMessages($user_id)
    {
        $messages=$this->model()->findAll("to_user_id=:to_user_id AND message_read=:message_read", array(':to_user_id' => $user_id, ':message_read' => 0 ));
        return count($messages);
    }

}
