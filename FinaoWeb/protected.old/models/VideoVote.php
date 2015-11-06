<?php

/**
 * This is the model class for table "fn_video_vote".
 *
 * The followings are the available columns in table 'fn_video_vote':
 * @property integer $vote_id
 * @property integer $voter_userid
 * @property integer $voted_userid
 * @property integer $voted_sourceid
 * @property string $createddate
 * @property integer $status
 */
class VideoVote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VideoVote the static model class
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
		return 'fn_video_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('voter_userid, voted_userid, voted_sourceid, createddate, status', 'required'),
			array('voter_userid, voted_userid, voted_sourceid, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vote_id, voter_userid, voted_userid, voted_sourceid, createddate, status', 'safe', 'on'=>'search'),
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
			'vote_id' => 'Vote',
			'voter_userid' => 'Voter Userid',
			'voted_userid' => 'Voted Userid',
			'voted_sourceid' => 'Voted Sourceid',
			'createddate' => 'Createddate',
			'status' => 'Status',
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

		$criteria->compare('vote_id',$this->vote_id);
		$criteria->compare('voter_userid',$this->voter_userid);
		$criteria->compare('voted_userid',$this->voted_userid);
		$criteria->compare('voted_sourceid',$this->voted_sourceid);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}