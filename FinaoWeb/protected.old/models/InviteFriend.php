<?php

/**
 * This is the model class for table "{{invite_friend}}".
 *
 * The followings are the available columns in table '{{invite_friend}}':
 * @property integer $invite_friend_id
 * @property string $source
 * @property string $invitee_social_network_id
 * @property string $invited_by_social_network_id
 * @property integer $invited_by_user_id
 * @property string $invited_request_id
 * @property string $invited_date
 * @property integer $status
 * @property string $invitee_email
 * @property integer $invitee_user_type
 */
class InviteFriend extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InviteFriend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invite_friend}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invited_by_user_id, invited_date, status, invitee_user_type', 'required'),
			array('invited_by_user_id, status, invitee_user_type', 'numerical', 'integerOnly'=>true),
			array('source, invitee_social_network_id, invited_by_social_network_id, invited_request_id', 'length', 'max'=>50),
			array('invitee_email', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invite_friend_id, source, invitee_social_network_id, invited_by_social_network_id, invited_by_user_id, invited_request_id, invited_date, status, invitee_email, invitee_user_type', 'safe', 'on'=>'search'),
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
			'invite_friend_id' => 'Invite Friend',
			'source' => 'Source',
			'invitee_social_network_id' => 'Invitee Social Network',
			'invited_by_social_network_id' => 'Invited By Social Network',
			'invited_by_user_id' => 'Invited By User',
			'invited_request_id' => 'Invited Request',
			'invited_date' => 'Invited Date',
			'status' => 'Status',
			'invitee_email' => 'Invitee Email',
			'invitee_user_type' => 'Invitee User Type',
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

		$criteria->compare('invite_friend_id',$this->invite_friend_id);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('invitee_social_network_id',$this->invitee_social_network_id,true);
		$criteria->compare('invited_by_social_network_id',$this->invited_by_social_network_id,true);
		$criteria->compare('invited_by_user_id',$this->invited_by_user_id);
		$criteria->compare('invited_request_id',$this->invited_request_id,true);
		$criteria->compare('invited_date',$this->invited_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('invitee_email',$this->invitee_email,true);
		$criteria->compare('invitee_user_type',$this->invitee_user_type);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}