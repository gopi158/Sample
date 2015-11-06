<?php

/**
 * This is the model class for table "finao_tagnote".
 *
 * The followings are the available columns in table 'finao_tagnote':
 * @property integer $finao_id
 * @property string $finao
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $private
 * @property string $design
 * @property string $location
 * @property string $method
 * @property string $finao_code
 * @property integer $refer
 * @property string $status
 * @property string $updated_date
 * @property string $created_date
 */
class FinaoTagnote extends MagentoActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FinaoTagnote the static model class
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
		return 'finao_tagnote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finao, private, design, location, method, finao_code, updated_date, created_date', 'required'),
			array('user_id, product_id, order_id, private, refer', 'numerical', 'integerOnly'=>true),
			array('finao', 'length', 'max'=>200),
			array('design, location, method', 'length', 'max'=>100),
			array('finao_code', 'length', 'max'=>5),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('finao_id, finao, user_id, product_id, order_id, private, design, location, method, finao_code, refer, status, updated_date, created_date', 'safe', 'on'=>'search'),
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
			'finao_id' => 'Finao',
			'finao' => 'Finao',
			'user_id' => 'User',
			'product_id' => 'Product',
			'order_id' => 'Order',
			'private' => 'Private',
			'design' => 'Design',
			'location' => 'Location',
			'method' => 'Method',
			'finao_code' => 'Finao Code',
			'refer' => 'Refer',
			'status' => 'Status',
			'updated_date' => 'Updated Date',
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

		$criteria->compare('finao_id',$this->finao_id);
		$criteria->compare('finao',$this->finao,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('private',$this->private);
		$criteria->compare('design',$this->design,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('finao_code',$this->finao_code,true);
		$criteria->compare('refer',$this->refer);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}