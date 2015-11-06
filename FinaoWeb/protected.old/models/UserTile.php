<?php

/**
 * This is the model class for table "{{user_tile}}".
 *
 * The followings are the available columns in table '{{user_tile}}':
 * @property integer $user_tileid
 * @property integer $tile_id
 * @property string $tile_name
 * @property integer $userid
 * @property integer $tile_parentid
 * @property string $tile_bgurl
 * @property integer $status
 * @property string $createddate
 * @property integer $createdby
 * @property string $updateddate
 * @property integer $updatedby
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Users $createdby0
 * @property Users $updatedby0
 * @property UserTileFinao[] $userTileFinaos
 */
class UserTile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserTile the static model class
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
		return '{{user_tile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tile_id, tile_name, userid, createddate, createdby, updateddate, updatedby', 'required'),
			array('tile_id, userid, tile_parentid, status, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('tile_name', 'length', 'max'=>100),
			array('tile_bgurl', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_tileid, tile_id, tile_name, userid, tile_parentid, tile_bgurl, status, createddate, createdby, updateddate, updatedby', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'userid'),
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),
			'userTileFinaos' => array(self::HAS_MANY, 'UserTileFinao', 'tile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_tileid' => 'User Tileid',
			'tile_id' => 'Tile',
			'tile_name' => 'Tile Name',
			'userid' => 'Userid',
			'tile_parentid' => 'Tile Parentid',
			'tile_bgurl' => 'Tile Bgurl',
			'status' => 'Status',
			'createddate' => 'Createddate',
			'createdby' => 'Createdby',
			'updateddate' => 'Updateddate',
			'updatedby' => 'Updatedby',
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

		$criteria->compare('user_tileid',$this->user_tileid);
		$criteria->compare('tile_id',$this->tile_id);
		$criteria->compare('tile_name',$this->tile_name,true);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('tile_parentid',$this->tile_parentid);
		$criteria->compare('tile_bgurl',$this->tile_bgurl,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updateddate',$this->updateddate,true);
		$criteria->compare('updatedby',$this->updatedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}