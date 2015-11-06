<?php

/**
 * This is the model class for table "{{tilesinfo}}".
 *
 * The followings are the available columns in table '{{tilesinfo}}':
 * @property integer $tilesinfo_id
 * @property integer $tile_id
 * @property string $tilename
 * @property string $tile_imageurl
 * @property string $temp_tile_imageurl
 * @property integer $Is_customtile
 * @property integer $status
 * @property integer $createdby
 * @property string $createddate
 * @property integer $updatedby
 * @property string $updateddate
 */
class TilesInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TilesInfo the static model class
	 */
	
	public $userid ;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tilesinfo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tile_id, tilename, createdby, createddate, updatedby, updateddate', 'required'),
			array('tile_id, Is_customtile, status, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('tilename', 'length', 'max'=>50),
			array('tile_imageurl, temp_tile_imageurl', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tilesinfo_id, tile_id, tilename, tile_imageurl, temp_tile_imageurl, Is_customtile, status, createdby, createddate, updatedby, updateddate', 'safe', 'on'=>'search'),
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
			//'tileinfo'=>array(self::HAS_ONE, 'UserFinaoTile', 'user_tileid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tilesinfo_id' => 'Tilesinfo',
			'tile_id' => 'Tileid',
			'tilename' => 'Tile Name',
			'tile_imageurl' => 'Tile Imageurl',
			'temp_tile_imageurl' => 'Temp Tile Imageurl',
			'Is_customtile' => 'Is Customtile',
			'status' => 'Status',
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

		$criteria->compare('tilesinfo_id',$this->tilesinfo_id);
		$criteria->compare('tile_id',$this->user_tileid);
		$criteria->compare('tilename',$this->tilename,true);
		$criteria->compare('tile_imageurl',$this->tile_imageurl,true);
		$criteria->compare('temp_tile_imageurl',$this->temp_tile_imageurl,true);
		$criteria->compare('Is_customtile',$this->Is_customtile);
		$criteria->compare('status',$this->status);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createddate',$this->createddate,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updateddate',$this->updateddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}