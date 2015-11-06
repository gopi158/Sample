<?php

/**
 * This is the model class for table "{{user_finao_journal}}".
 *
 * The followings are the available columns in table '{{user_finao_journal}}':
 * @property integer $finao_journal_id
 * @property integer $finao_id
 * @property string $finao_journal
 * @property integer $journal_status
 * @property string $journal_startdate
 * @property string $journal_enddate
 * @property integer $user_id
 * @property integer $status_value
 * @property integer $createdby
 * @property string $createddate
 * @property integer $updatedby
 * @property string $updateddate
 *
 * The followings are the available model relations:
 * @property Users $createdby0
 * @property UserFinao $finao
 * @property Users $updatedby0
 */
class UserFinaoJournal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserFinaoJournal the static model class
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
		return '{{user_finao_journal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('finao_id, finao_journal, journal_status, journal_startdate, user_id, createdby, createddate, updatedby, updateddate', 'required'),
			array('finao_id, journal_status, user_id, status_value, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('finao_journal', 'length', 'max'=>150),
			array('journal_enddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('finao_journal_id, finao_id, finao_journal, journal_status, journal_startdate, journal_enddate, user_id, status_value, createdby, createddate, updatedby, updateddate', 'safe', 'on'=>'search'),
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
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
			'finao' => array(self::BELONGS_TO, 'UserFinao', 'finao_id'),
			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'finao_journal_id' => 'Finao Journal',
			'finao_id' => 'Finao',
			'finao_journal' => 'Finao Journal',
			'journal_status' => 'Journal Status',
			'journal_startdate' => 'Journal Startdate',
			'journal_enddate' => 'Journal Enddate',
			'user_id' => 'User',
			'status_value' => 'Status Value',
			'createdby' => 'Createdby',
			'createddate' => 'Createddate',
			'updatedby' => 'Updatedby',
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

		$criteria->compare('finao_journal_id',$this->finao_journal_id);
		$criteria->compare('finao_id',$this->finao_id);
		$criteria->compare('finao_journal',$this->finao_journal,true);
		$criteria->compare('journal_status',$this->journal_status);
		$criteria->compare('journal_startdate',$this->journal_startdate,true);
		$criteria->compare('journal_enddate',$this->journal_enddate,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status_value',$this->status_value);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updateddate',$this->updateddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}