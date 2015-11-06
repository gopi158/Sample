<?php

/**
 * This is the model class for table "{{like}}".
 *
 * The followings are the available columns in table '{{like}}':
 * @property integer $like_id
 * @property string $like_type
 * @property integer $source_like_id
 * @property integer $user_id
 * @property string $created_date
 */
class Like extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Like the static model class
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
		return '{{like}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('like_type, source_like_id, user_id', 'required'),
			array('source_like_id, user_id, rating', 'numerical', 'integerOnly'=>true),
			array('like_type', 'length', 'max'=>50),
			array('rating', 'length', 'max'=>11),
			array('created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('like_id, like_type, rating, source_like_id, user_id, created_date', 'safe', 'on'=>'search'),
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
			'like_id' => 'Like',
			'like_type' => 'Like Type',
			'source_like_id' => 'Source Like',
			'user_id' => 'User',
			'created_date' => 'Created Date',
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

		$criteria->compare('like_id',$this->like_id);
		$criteria->compare('like_type',$this->like_type,true);
		$criteria->compare('source_like_id',$this->source_like_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}