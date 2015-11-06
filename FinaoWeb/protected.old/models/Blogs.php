<?php

/**
 * This is the model class for table "{{blogs}}".
 *
 * The followings are the available columns in table '{{blogs}}':
 * @property string $blog_id
 * @property string $blog_title
 * @property integer $blog_category_id
 * @property string $type
 * @property string $blog_content
 * @property integer $blog_parent_id
 * @property integer $status
 * @property integer $createdby
 * @property string $created_date
 * @property integer $updatedby
 * @property string $updated_date
 * @property string $blog_post_under
 * The followings are the available model relations:
 * @property Lookups $blogCategory
 * @property Users $createdby0
 */
class Blogs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Blogs the static model class
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
		return '{{blogs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blog_title, blog_content', 'required'),
			array('blog_category_id, blog_parent_id,status, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('blog_title , blog_post_under , avg_rating, type', 'length', 'max'=>255),
			array('likes, total_rating,no_of_user', 'length', 'max'=>11),
			array('blog_content', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('blog_id, blog_title,blog_post_under, blog_category_id, blog_content, blog_parent_id, status, createdby, created_date, updatedby, updated_date', 'safe', 'on'=>'search'),
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
			'blogCategory' => array(self::BELONGS_TO, 'Lookups', 'blog_category_id'),
			'user' => array(self::BELONGS_TO, 'User', 'createdby'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'blog_id' => 'Blog',
			'blog_title' => 'Blog Title',
			'blog_category_id' => 'Blog Category',
			'blog_content' => 'Blog Content',
			'blog_parent_id' => 'Blog Parent',
			'status' => 'Status',
			'createdby' => 'Createdby',
			'created_date' => 'Created Date',
			'updatedby' => 'Updatedby',
			'updated_date' => 'Updated Date',
			'type' =>'Type',
			'blog_post_under'=>'Post Under',
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

		$criteria->compare('blog_id',$this->blog_id,true);
		$criteria->compare('blog_title',$this->blog_title,true);
		$criteria->compare('blog_category_id',$this->blog_category_id);
		$criteria->compare('blog_content',$this->blog_content,true);
		$criteria->compare('blog_parent_id',$this->blog_parent_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('blog_post_under',$this->blog_post_under,true);	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}