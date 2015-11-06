<?php

/**
 * This is the model class for table "{{groups}}".
 *
 * The followings are the available columns in table '{{groups}}':
 * @property integer $group_id
 * @property string $group_name
 * @property string $group_description
 * @property string $profile_image
 * @property string $temp_profile_image
 * @property string $profile_bg_image
 * @property string $temp_profile_bg_image
 * @property integer $group_status_ispublic
 * @property integer $group_activestatus
 * @property integer $upload_status
 * @property integer $updatedby
 * @property string $createddate
 * @property string $updatedate
 */
class Groups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Groups the static model class
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
		return '{{groups}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_description, profile_image, temp_profile_image, profile_bg_image, temp_profile_bg_image, createddate', 'required'),
			array('group_status_ispublic, group_activestatus, upload_status, updatedby', 'numerical', 'integerOnly'=>true),
			array('group_name, group_description, temp_profile_image, temp_profile_bg_image', 'length', 'max'=>50),
			array('profile_image, profile_bg_image', 'length', 'max'=>100),
			array('updatedate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, group_name, group_description, profile_image, temp_profile_image, profile_bg_image, temp_profile_bg_image, group_status_ispublic, group_activestatus, upload_status, updatedby, createddate, updatedate', 'safe', 'on'=>'search'),
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
			'group_id' => 'Group',
			'group_name' => 'Group Name',
			'group_description' => 'Group Description',
			'profile_image' => 'Profile Image',
			'temp_profile_image' => 'Temp Profile Image',
			'profile_bg_image' => 'Profile Bg Image',
			'temp_profile_bg_image' => 'Temp Profile Bg Image',
			'group_status_ispublic' => 'Group Status Ispublic',
			'group_activestatus' => 'Group Activestatus',
			'upload_status' => 'Upload Status',
			'updatedby' => 'Updatedby',
			'createddate' => 'Createddate',
			'updatedate' => 'Updatedate',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('group_name',$this->group_name,true);
		$criteria->compare('group_description',$this->group_description,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('temp_profile_image',$this->temp_profile_image,true);
		$criteria->compare('profile_bg_image',$this->profile_bg_image,true);
		$criteria->compare('temp_profile_bg_image',$this->temp_profile_bg_image,true);
		$criteria->compare('group_status_ispublic',$this->group_status_ispublic);
		$criteria->compare('group_activestatus',$this->group_activestatus);
		$criteria->compare('upload_status',$this->upload_status);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('updatedate',$this->updatedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}