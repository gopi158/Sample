<?php

/**
 * This is the model class for table "fn_notes".
 *
 * The followings are the available columns in table 'fn_notes':
 * @property integer $note_id
 * @property integer $tracker_userid
 * @property integer $tracked_userid
 * @property integer $upload_sourceid
 * @property integer $upload_sourcetype
 * @property integer $view_status
 * @property integer $block_status
 * @property string $createddate
 */
class Notes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notes the static model class
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
		return 'fn_notes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tracker_userid, tracked_userid, upload_sourceid, upload_sourcetype, createddate', 'required'),
			array('tracker_userid, tracked_userid, upload_sourceid, upload_sourcetype, view_status, block_status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('note_id, tracker_userid, tracked_userid, upload_sourceid, upload_sourcetype, view_status, block_status, createddate', 'safe', 'on'=>'search'),
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
			'note_id' => 'Note',
			'tracker_userid' => 'Tracker Userid',
			'tracked_userid' => 'Tracked Userid',
			'upload_sourceid' => 'Upload Sourceid',
			'upload_sourcetype' => 'Upload Sourcetype',
			'view_status' => 'View Status',
			'block_status' => 'Block Status',
			'createddate' => 'Createddate',
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

		$criteria->compare('note_id',$this->note_id);
		$criteria->compare('tracker_userid',$this->tracker_userid);
		$criteria->compare('tracked_userid',$this->tracked_userid);
		$criteria->compare('upload_sourceid',$this->upload_sourceid);
		$criteria->compare('upload_sourcetype',$this->upload_sourcetype);
		$criteria->compare('view_status',$this->view_status);
		$criteria->compare('block_status',$this->block_status);
		$criteria->compare('createddate',$this->createddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}