<?php

/**
 * This is the model class for table "friendship".
 *
 * The followings are the available columns in table 'friendship':
 * @property integer $inviter_id
 * @property integer $friend_id
 * @property integer $status
 * @property integer $acknowledgetime
 * @property integer $requesttime
 * @property integer $updatetime
 * @property string $message
 */
class Friendship extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'friendship';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inviter_id, friend_id, status, message', 'required'),
			array('inviter_id, friend_id, status, acknowledgetime, requesttime, updatetime', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('inviter_id, friend_id, status, acknowledgetime, requesttime, updatetime, message', 'safe', 'on'=>'search'),
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
			'inviter_id' => 'Inviter',
			'friend_id' => 'Friend',
			'status' => 'Status',
			'acknowledgetime' => 'Acknowledgetime',
			'requesttime' => 'Requesttime',
			'updatetime' => 'Updatetime',
			'message' => 'Message',
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

		$criteria->compare('inviter_id',$this->inviter_id);
		$criteria->compare('friend_id',$this->friend_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('acknowledgetime',$this->acknowledgetime);
		$criteria->compare('requesttime',$this->requesttime);
		$criteria->compare('updatetime',$this->updatetime);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Friendship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /*get users ids by id, if user inviter*/
    public function getAllUsersByIdIfInviter($userid)
    {
        $retarray=array();
        $allrec=$this::model()->findAllBySql('SELECT friend_id FROM '.$this->tableName().' WHERE inviter_id='.$userid.' and status=0');
        if($allrec)
        {
            foreach($allrec as $rec)
                $retarray[]=$rec->friend_id;
        }
        return $retarray;
    }

    /*get users ids by id, if user not inviter*/
    public function getAllUsersByIdIfNotInviter($userid)
    {
        $retarray=array();
        $allrec=$this::model()->findAllBySql('SELECT inviter_id FROM '.$this->tableName().' WHERE friend_id='.$userid.' and status=0');
        if($allrec)
        {
            foreach($allrec as $rec)
                $retarray[]=$rec->inviter_id;
        }
        return $retarray;
    }

    public function countFriendRequests($userid)
    {
        $requests = $this::model()->findAll("friend_id=:friend_id AND status=:status", array(':friend_id' => $userid, ':status' => 0));
        return count($requests);
    }

}
