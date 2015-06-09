<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property string $id
 * @property integer $avatar
 * @property string $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $street
 * @property string $city
 * @property string $about
 * @property string $phone
 * @property integer $sex
 * @property integer $user_location
 * @property integer $bday
 */
class Profile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, bday', 'required'),
			array('avatar, sex, user_location, bday', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('lastname, firstname', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>512),
			array('about', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, avatar, user_id, lastname, firstname,  street, city, about, phone, sex, user_location, bday', 'safe', 'on'=>'search'),
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
			'avatar' => 'Avatar',
			'user_id' => 'User',
			'lastname' => 'Lastname',
			'firstname' => 'Firstname',
			'street' => 'Street',
			'city' => 'City',
			'about' => 'About',
			'phone' => 'Phone',
			'sex' => 'Sex',
			'user_location' => 'User Location',
			'bday' => 'Bday',
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
		$criteria->compare('avatar',$this->avatar);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('user_location',$this->user_location);
		$criteria->compare('bday',$this->bday);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getLittleAvatar($user_sess)
    {
        $return="<img src='/img/default-user.png'/>";
        if($user_sess)
        {
            $avatar_id=Profile::model()->findByAttributes(array("user_id"=>$user_sess));
            if($avatar_id)
            {
                $file_avatar=Files::model()->findByPk($avatar_id->avatar);
                if($file_avatar)
                {
                    if(file_exists(Yii::app()->basePath."/../files/".$file_avatar->image))
                    {
                        $return="<img src='/files/".$file_avatar->image."'/>";
                    }
                }

            }
        }
        return $return;
    }

    public function getAvatarUrl()
    {
        $return="/img/default-user.png";

        $avatar = Files::model()->findByPk($this->avatar);
        if($avatar) {
            if(file_exists(Yii::app()->basePath . "/../files/" . $avatar->image))
            {
                $return="/files/" . $avatar->image;
            }
        }

        return $return;
    }

    public function getName($user_id)
    {
        $user=Profile::model()->findByAttributes(array("user_id"=>$user_id));
        if($user)
            return $user->firstname." ".$user->lastname;
        else return "";
    }

    /**/
    public function birthdayImg($user_id)
    {
        $ret="";
        if(isset($user_id))
        {
            $profile=Profile::model()->findByAttributes(array('user_id'=>$user_id));
            $bday=date("d",$profile->bday);
            $bmonth=date("m",$profile->bday);
            $signs_img = array("capricorn.png", "aquarius.png", "pisces.png", "aries.png", "taurus.png", "gemini.png", "cancer.png", "leo.png", "virgo.png", "libra.png", "Scorpio.png", "Sagittarius.png");
            $signsstart = array(1 => 21, 2 => 20, 3 => 20, 4 => 20, 5 => 20, 6 => 20, 7 => 21, 8 => 22, 9 => 23, 10 => 23, 11 => 23, 12 => 23);
            $ret.="<img src='/img/";
            $ret.=$bday < $signsstart[$bmonth + 1] ? $signs_img[$bmonth - 1] : $signs_img[$bmonth%12];
            $ret.="' />";
        }
        return $ret;

    }

    /**/

    public function birthdayDate($user_id)
    {
        $profile=Profile::model()->findByAttributes(array('user_id'=>$user_id));
        if($profile)
            return date("d.m.Y",$profile->bday);
        else return "";
    }
    /**/

    public function birthdayName($user_id)
    {
        $profile=Profile::model()->findByAttributes(array('user_id'=>$user_id));
        if($profile)
        {
            $bday=date("d",$profile->bday);
            $bmonth=date("m",$profile->bday);
            $signs = array("capricorn", "aquarius", "pisces", "aries", "taurus", "gemini", "cancer", "leo", "virgo", "libra", "Scorpio", "Sagittarius");
            $signsstart = array(1 => 21, 2 => 20, 3 => 20, 4 => 20, 5 => 20, 6 => 20, 7 => 21, 8 => 22, 9 => 23, 10 => 23, 11 => 23, 12 => 23);
            return $bday < $signsstart[$bmonth + 1] ? $signs[$bmonth - 1] : $signs[$bmonth % 12];
        }
        else return "";
    }
    /**/
    public function rankImgClass($user_id)
    {
        $user_rank=User::model()->findByPk($user_id);
        $rank_class=null;
        if($user_rank)
        {
            $job_type=JobType::model()->findByPk($user_rank->job_type)->job_type;
            $job_title=JobTitle::model()->findByPk($user_rank->job_title)->job_title;
            switch (strtolower($job_type)){
            case "developer":
                switch (strtolower($job_title))
                {
                case "youngling":
                    $rank_class="developers-rank-1";
                    break;
                case "padawan":
                    $rank_class="developers-rank-2";
                    break;
                case "jedi":
                    $rank_class="developers-rank-3";
                    break;
                case "jedi survivor":
                    $rank_class="developers-rank-4";
                    break;
                case "jedi knight":
                    $rank_class="developers-rank-5";
                    break;
                case "master jedi":
                    $rank_class="developers-rank-6";
                    break;
                case "the chosen one":
                    $rank_class="developers-rank-7";
                    break;
                case "yoda":
                    $rank_class="developers-rank-8";
                    break;
                case "darth vader":
                    $rank_class="developers-rank-9";
                    break;
                }
                break;
            case "pm":
                switch (strtolower($job_title))
                {
                case "pixie":
                    $rank_class="pms-rank-1";
                    break;
                case "tinker bell":
                    $rank_class="pms-rank-2";
                    break;
                case "nymph":
                    $rank_class="pms-rank-3";
                    break;
                case "fairy":
                    $rank_class="pms-rank-4";
                    break;
                case "djinni":
                    $rank_class="pms-rank-5";
                    break;
                case "witch":
                    $rank_class="pms-rank-6";
                    break;
                case "snow queen":
                    $rank_class="pms-rank-7";
                    break;
                case "cruella de cil":
                    $rank_class="pms-rank-8";
                    break;
                }
                break;
            case "designer":
                switch (strtolower($job_title))
                {
                case "muggle/gunter":
                    $rank_class="designers-rank-1";
                    break;
                case "muggle-born/peppermint butler":
                    $rank_class="designers-rank-2";
                    break;
                case "house-elf/jake the dog":
                    $rank_class="designers-rank-3";
                    break;
                case "wizard/fin":
                    $rank_class="designers-rank-4";
                    break;
                case "metamorphmagus/billy":
                    $rank_class="designers-rank-5";
                    break;
                case "auror the/ice king":
                    $rank_class="designers-rank-6";
                    break;
                case "albus dumbledore/the lich":
                    $rank_class="designers-rank-7";
                    break;
                case "lord voldemort/lemongrab":
                    $rank_class="designers-rank-8";
                    break;
                }
                break;
            case "qa":
                switch (strtolower($job_title))
                {
                case "gremlin":
                    $rank_class="qas-rank-1";
                    break;
                case "elf":
                    $rank_class="qas-rank-2";
                    break;
                case "leprechaun":
                    $rank_class="qas-rank-3";
                    break;
                case "warlock":
                    $rank_class="qas-rank-4";
                    break;
                case "whitelighter":
                    $rank_class="qas-rank-5";
                    break;
                case "sorcerer":
                    $rank_class="qas-rank-6";
                    break;
                case "driad":
                    $rank_class="qas-rank-7";
                    break;
                case "merlin":
                    $rank_class="qas-rank-8";
                    break;
                }
                break;
            case "hr":
                switch (strtolower($job_title))
                {
                case "flora":
                    $rank_class="hrs-rank-1";
                    break;
                case "demeter":
                    $rank_class="hrs-rank-2";
                    break;
                case "terra":
                    $rank_class="hrs-rank-3";
                    break;
                case "aurora":
                    $rank_class="hrs-rank-4";
                    break;
                case "luna":
                    $rank_class="hrs-rank-5";
                    break;
                case "aphrodite":
                    $rank_class="hrs-rank-6";
                    break;
                case "athena":
                    $rank_class="hrs-rank-7";
                    break;
                case "artemis":
                    $rank_class="hrs-rank-8";
                    break;
                }
                break;
            case "v.i.p.":
                switch (strtolower($job_title))
                {
                case "iron man":
                    $rank_class="vip-rank-1";
                    break;
                case "captain america":
                    $rank_class="vip-rank-2";
                    break;
                case "magneto":
                    $rank_class="vip-rank-3";
                    break;
                case "rogue":
                    $rank_class="vip-rank-4";
                    break;
                }
                break;
            }
        }
        return $rank_class;
    }

    /**/

    public function jobTitle($user_id)
    {
        $user_rank=User::model()->findByPk($user_id);
        if($user_rank)
            return JobTitle::model()->findByPk($user_rank->job_title)->job_title;
        else return "";
    }

    /**/

    public function jobType($user_id)
    {
        $user_rank=User::model()->findByPk($user_id);
        if($user_rank)
            return JobType::model()->findByPk($user_rank->job_type)->job_type;
        else return "";
    }

    /*company*/
    public function companyImg($user_id)
    {
        $ret="";
        $company_id=Company::model()->findByAttributes(array("id"=>User::model()->findByPk($user_id)->company_id));
        if($company_id)
        {
            $file_company=Files::model()->findByPk($company_id->image);
            if($file_company)
            {
                if(file_exists(Yii::app()->basePath."/../files/".$file_company->image))
                {
                    $ret="<img style='padding: 0;' src='/files/".$file_company->image."'/>";
                }
            }
        }
        return $ret;
    }
}
