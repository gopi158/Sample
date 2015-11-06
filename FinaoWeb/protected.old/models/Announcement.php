<?php

/**
 * This is the model class for table "{{group_announcement}}".
 *
 * The followings are the available columns in table '{{group_announcement}}':
 * @property integer $anno_id
 * @property integer $uploadsourcetype
 * @property integer $uploadsourceid
 * @property string $announcement
 * @property integer $createdby
 * @property string $createddate
 * @property integer $status
 */
class Announcement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Announcement the static model class
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
		return '{{group_announcement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uploadsourcetype, uploadsourceid, createdby, status', 'numerical', 'integerOnly'=>true),
			array('announcement', 'length', 'max'=>255),
			array('createddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anno_id, uploadsourcetype, uploadsourceid, announcement, createdby, createddate, status', 'safe', 'on'=>'search'),
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
			'anno_id' => 'Anno',
			'uploadsourcetype' => 'Uploadsourcetype',
			'uploadsourceid' => 'Uploadsourceid',
			'announcement' => 'Announcement',
			'createdby' => 'Createdby',
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

		$criteria->compare('anno_id',$this->anno_id);
		$criteria->compare('uploadsourcetype',$this->uploadsourcetype);
		$criteria->compare('uploadsourceid',$this->uploadsourceid);
		$criteria->compare('announcement',$this->announcement,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}