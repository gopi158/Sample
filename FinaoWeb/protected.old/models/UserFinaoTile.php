<?php



/**

 * This is the model class for table "{{user_finao_tile}}".

 *

 * The followings are the available columns in table '{{user_finao_tile}}':

 * @property integer $user_tileid

 * @property integer $tile_id

 * @property string $tile_name

 * @property integer $userid

 * @property integer $finao_id

 * @property string $tile_profileImagurl

 * @property integer $status

 * @property string $createddate

 * @property integer $createdby

 * @property string $updateddate

 * @property integer $updatedby

 *

 * The followings are the available model relations:

 * @property UserFinao $finao

 * @property Users $createdby0

 * @property Users $updatedby0

 * @property Users $user

 */

class UserFinaoTile extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return UserFinaoTile the static model class

	 */
	public $finaomessage;
	public $Usercnt;
	public $tilename;
	public $tile_imageurl;
	public $Is_customtile;
	
	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}



	/**

	 * @return string the associated database table name

	 */

	public function tableName()

	{

		return '{{user_finao_tile}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('tile_id, tile_name, userid, finao_id, createddate, createdby, updateddate, updatedby', 'required'),

			array('tile_id, userid, finao_id, status, createdby, updatedby', 'numerical', 'integerOnly'=>true),

			array('tile_name', 'length', 'max'=>100),

			array('tile_profileImagurl', 'length', 'max'=>250),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('user_tileid, tile_id, tile_name, userid, finao_id, tile_profileImagurl, status, createddate, createdby, updateddate, updatedby', 'safe', 'on'=>'search'),

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

			'finao' => array(self::BELONGS_TO, 'UserFinao', 'finao_id'),

			'createdby0' => array(self::BELONGS_TO, 'User', 'createdby'),

			'updatedby0' => array(self::BELONGS_TO, 'User', 'updatedby'),

			'user' => array(self::BELONGS_TO, 'User', 'userid'),

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

			'finao_id' => 'Finao',

			'tile_profileImagurl' => 'Tile Profile Imagurl',

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

		$criteria->compare('finao_id',$this->finao_id);

		$criteria->compare('tile_profileImagurl',$this->tile_profileImagurl,true);

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