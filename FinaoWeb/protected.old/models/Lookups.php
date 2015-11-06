<?php

/**
 * This is the model class for table "pv_lookups".
 *
 * The followings are the available columns in table 'pv_lookups':
 * @property integer $pv_lookup_id
 * @property string $lookup_name
 * @property string $lookup_type
 * @property integer $lookup_status
 * @property integer $lookup_parentid
 * @property string $createdate
 * @property string $updateddate
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Address[] $addresses1
 * @property EduPlanTasks[] $eduPlanTasks
 * @property EduPlanTasks[] $eduPlanTasks1
 * @property UserChildInterests[] $userChildInterests
 * @property Users[] $users
 * @property Users[] $users1
 */
class Lookups extends CActiveRecord
{
	public $hdnCategory;//Added on 29012013
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lookups the static model class
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
		return 'fn_lookups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lookup_name, lookup_type, lookup_status, createdate', 'required'),
			array('lookup_status, lookup_parentid', 'numerical', 'integerOnly'=>true),
			array('lookup_name, lookup_type', 'length', 'max'=>150),
			array('updateddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pv_lookup_id, lookup_name, lookup_type, lookup_status, lookup_parentid, createdate, updateddate', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'searchdistance'),
			'addresses1' => array(self::HAS_MANY, 'Address', 'address_tag'),
			'eduPlanTasks' => array(self::HAS_MANY, 'EduPlanTasks', 'task_status'),
			'eduPlanTasks1' => array(self::HAS_MANY, 'EduPlanTasks', 'goal_type'),
			'userChildInterests' => array(self::HAS_MANY, 'UserChildInterests', 'interestid'),
			'users' => array(self::HAS_MANY, 'Users', 'gender'),
			'users1' => array(self::HAS_MANY, 'Users', 'usertypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pv_lookup_id' => 'Pv Lookup',
			'lookup_name' => 'Lookup Name',
			'lookup_type' => 'Lookup Type',
			'lookup_status' => 'Lookup Status',
			'lookup_parentid' => 'Lookup Parentid',
			'createdate' => 'Createdate',
			'updateddate' => 'Updateddate',
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

		$criteria->compare('pv_lookup_id',$this->pv_lookup_id);
		$criteria->compare('lookup_name',$this->lookup_name,true);
		$criteria->compare('lookup_type',$this->lookup_type,true);
		$criteria->compare('lookup_status',$this->lookup_status);
		$criteria->compare('lookup_parentid',$this->lookup_parentid);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updateddate',$this->updateddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//Added on 24012013
	public function getIntresstNames($intrestId)
	{
			$modelIntresst = Lookups::model()->findAll(array('condition' => 'pv_lookup_id ="'.$intrestId.'" AND lookup_type="interests"'));
			if(isset($modelIntresst))
				if(count($modelIntresst) > 0)
					foreach($modelIntresst as $modInt)
						return $modInt['lookup_name'];
			else
				return $intrestId;	
	}
	//Ended on 24012013	
}