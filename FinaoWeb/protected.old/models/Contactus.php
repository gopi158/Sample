<?php

/**
 * This is the model class for table "{{contactus}}".
 *
 * The followings are the available columns in table '{{contactus}}':
 * @property integer $contact_id
 * @property string $contact_name
 * @property string $contact_company
 * @property string $contact_help
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $contact_title
 * @property integer $newsletter
 */
class Contactus extends CActiveRecord
{
	public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contactus the static model class
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
		return '{{contactus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_name, contact_company, contact_help, contact_email, contact_phone, contact_title, newsletter', 'required'),
			array('newsletter', 'numerical', 'integerOnly'=>true),
			array('contact_name, contact_company, contact_email', 'length', 'max'=>50),
			array('contact_help', 'length', 'max'=>4000),
			array('contact_phone, contact_title', 'length', 'max'=>20),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'captchaRequired'),
			array('verifyCode', 'required','on'=>'captchaRequired'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contact_id, contact_name, contact_company, contact_help, contact_email, contact_phone, contact_title, newsletter', 'safe', 'on'=>'search'),
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
			'contact_id' => 'Contact',
			'contact_name' => 'Contact Name',
			'contact_company' => 'Contact Company',
			'contact_help' => 'Contact Help',
			'contact_email' => 'Contact Email',
			'contact_phone' => 'Contact Phone',
			'contact_title' => 'Contact Title',
			'newsletter' => 'Newsletter',
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

		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_company',$this->contact_company,true);
		$criteria->compare('contact_help',$this->contact_help,true);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('contact_phone',$this->contact_phone,true);
		$criteria->compare('contact_title',$this->contact_title,true);
		$criteria->compare('newsletter',$this->newsletter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}