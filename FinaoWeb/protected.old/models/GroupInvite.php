<?php

/**
 * This is the model class for table "{{group_invite}}".
 *
 * The followings are the available columns in table '{{group_invite}}':
 * @property integer $invite_id
 * @property integer $inviter_userid
 * @property integer $invited_userid
 * @property integer $inviter_groupid
 * @property string $createddate
 * @property integer $status
 */
class GroupInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupInvite the static model class
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
		return '{{group_invite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inviter_userid, invited_userid, inviter_groupid, createddate, status', 'required'),
			array('inviter_userid, invited_userid, inviter_groupid, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invite_id, inviter_userid, invited_userid, inviter_groupid, createddate, status', 'safe', 'on'=>'search'),
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
			'invite_id' => 'Invite',
			'inviter_userid' => 'Inviter Userid',
			'invited_userid' => 'Invited Userid',
			'inviter_groupid' => 'Inviter Groupid',
			'createddate' => 'Createddate',
			'status' => 'Status',
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

		$criteria->compare('invite_id',$this->invite_id);
		$criteria->compare('inviter_userid',$this->inviter_userid);
		$criteria->compare('invited_userid',$this->invited_userid);
		$criteria->compare('inviter_groupid',$this->inviter_groupid);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}