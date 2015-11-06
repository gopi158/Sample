<?php

/**
 * This is the model class for table "{{video_userinfo}}".
 *
 * The followings are the available columns in table '{{video_userinfo}}':
 * @property integer $vid
 * @property integer $contesttype
 * @property string $userid
 * @property string $school
 * @property string $graduate
 * @property string $major
 */
class VideoUserinfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VideoUserinfo the static model class
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
		return '{{video_userinfo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contesttype', 'numerical', 'integerOnly'=>true),
			array('userid, school, graduate, major', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vid, contesttype, userid, school, graduate, major', 'safe', 'on'=>'search'),
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
			'vid' => 'Vid',
			'contesttype' => 'Contesttype',
			'userid' => 'Userid',
			'school' => 'School',
			'graduate' => 'Graduate',
			'major' => 'Major',
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

		$criteria->compare('vid',$this->vid);
		$criteria->compare('contesttype',$this->contesttype);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('school',$this->school,true);
		$criteria->compare('graduate',$this->graduate,true);
		$criteria->compare('major',$this->major,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}