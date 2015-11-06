<?php

/**
 * This is the model class for table "{{comments}}".
 *
 * The followings are the available columns in table '{{comments}}':
 * @property integer $comment_id
 * @property integer $goal_id
 * @property string $goal_type
 * @property string $comment_content
 * @property integer $comment_author_id
 * @property integer $comment_parent_id
 * @property integer $status
 * @property string $commented_date
 *
 * The followings are the available model relations:
 * @property Users $commentAuthor
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return '{{comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('goal_id, goal_type, comment_content, comment_author_id, comment_parent_id', 'required'),
			array('goal_id, comment_author_id, comment_parent_id, comment_like, status', 'numerical', 'integerOnly'=>true),
			array('goal_type', 'length', 'max'=>50),
			array('comment_content', 'length', 'max'=>500),
			array('commented_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, goal_id, goal_type, comment_content, comment_author_id, comment_parent_id, status, commented_date', 'safe', 'on'=>'search'),
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
			'commentAuthor' => array(self::BELONGS_TO, 'User', 'comment_author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => 'Comment',
			'goal_id' => 'Goal',
			'goal_type' => 'Goal Type',
			'comment_content' => 'Comment Content',
			'comment_author_id' => 'Comment Author',
			'comment_parent_id' => 'Comment Parent',
			'comment_like' => 'Comment Like',
			'status' => 'Status',
			'commented_date' => 'Commented Date',
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

		$criteria->compare('comment_id',$this->comment_id);
		$criteria->compare('goal_id',$this->goal_id);
		$criteria->compare('goal_type',$this->goal_type,true);
		$criteria->compare('comment_content',$this->comment_content,true);
		$criteria->compare('comment_author_id',$this->comment_author_id);
		$criteria->compare('comment_parent_id',$this->comment_parent_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('commented_date',$this->commented_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}