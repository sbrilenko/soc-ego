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
 */
class Message extends CActiveRecord
{
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
			array('timestamp, from_user_id, to_user_id', 'length', 'max'=>10),
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
        return $this->model()->findAllBySql("SELECT m.* FROM ".$this->tableName()." as m,".Friendship::model()->tableName()." as f WHERE ((f.inviter_id=".$id." OR f.friend_id) AND f.status>0) and (m.from_user_id=".$id." OR m.to_user_id=".$id.") ORDER BY m.timestamp DESC");
    }
}
