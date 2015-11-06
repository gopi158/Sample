<?php

/**
 * This is the model class for table "{{user_profile}}".
 *
 * The followings are the available columns in table '{{user_profile}}':
 * @property integer $user_profile_id
 * @property string $user_profile_msg
 * @property string $user_location
 * @property string $profile_image
 * @property string $profile_bg_image
 * @property integer $profile_status_Ispublic
 * @property integer $createdby
 * @property string $createddate
 * @property integer $updatedby
 * @property string $updateddate
 *
 * The followings are the available model relations:
 * @property Finao.users $createdby0
 * @property Finao.users $updatedby0
 */
class UserProfile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserProfile the static model class
	 */
	public $userprofileimage;
	public $bgimage;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_profile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createdby, createddate, updatedby, updateddate', 'required'),
			array('user_id, profile_status_Ispublic, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('user_profile_msg', 'length', 'max'=>150),
			array('user_location', 'length', 'max'=>100),
			array('profile_image, profile_bg_image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_profile_id, user_profile_msg, user_location, profile_image, profile_bg_image, profile_status_Ispublic, createdby, createddate, updatedby, updateddate', 'safe', 'on'=>'search'),
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
			'createdby0' => array(self::BELONGS_TO, 'Finao.users', 'createdby'),
			'updatedby0' => array(self::BELONGS_TO, 'Finao.users', 'updatedby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_profile_id' => 'User Profile',
			'user_profile_msg' => 'User Profile Msg',
			'user_location' => 'User Location',
			'profile_image' => 'Profile Image',
			'profile_bg_image' => 'Profile Bg Image',
			'profile_status_Ispublic' => 'Profile Status Ispublic',
			'createdby' => 'Createdby',
			'createddate' => 'Createddate',
			'updatedby' => 'Updatedby',
			'updateddate' => 'Updateddate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_profile_id',$this->user_profile_id);
		$criteria->compare('user_profile_msg',$this->user_profile_msg,true);
		$criteria->compare('user_location',$this->user_location,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('profile_bg_image',$this->profile_bg_image,true);
		$criteria->compare('profile_status_Ispublic',$this->profile_status_Ispublic);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updateddate',$this->updateddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}