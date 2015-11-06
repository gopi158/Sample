<?php

/**
 * This is the model class for table "{{blog_tags}}".
 *
 * The followings are the available columns in table '{{blog_tags}}':
 * @property integer $tag_id
 * @property string $tag_name
 * @property integer $tag_status
 * @property string $createdate
 * @property integer $createdby
 */
class BlogTags extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BlogTags the static model class
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
		return '{{blog_tags}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag_name', 'required'),
			array('tag_status, createdby', 'numerical', 'integerOnly'=>true),
			array('tag_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tag_id, tag_name, tag_status, createdate, createdby', 'safe', 'on'=>'search'),
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
			'tag_id' => 'Tag',
			'tag_name' => 'Tag Name',
			'tag_status' => 'Tag Status',
			'createdate' => 'Createdate',
			'createdby' => 'Createdby',
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

		$criteria->compare('tag_id',$this->tag_id);
		$criteria->compare('tag_name',$this->tag_name,true);
		$criteria->compare('tag_status',$this->tag_status);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('createdby',$this->createdby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}