<?php



/**

 * This is the model class for table "{{tracking}}".

 *

 * The followings are the available columns in table '{{tracking}}':

 * @property integer $tracking_id

 * @property integer $tracker_userid

 * @property integer $tracked_userid

 * @property integer $tracked_tileid

 * @property string $createddate

 * @property integer $status

 *

 * The followings are the available model relations:

 * @property UserFinaoTile $trackedTile

 * @property Users $trackedUser

 * @property Users $trackerUser

 */

class Tracking extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return Tracking the static model class

	 */
	public $tile_name;
	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}



	/**

	 * @return string the associated database table name

	 */

	public function tableName()

	{

		return '{{tracking}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('tracker_userid, tracked_userid, tracked_tileid, createddate, status', 'required'),

			array('tracker_userid, tracked_userid, tracked_tileid, status', 'numerical', 'integerOnly'=>true),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('tracking_id, tracker_userid, tracked_userid, tracked_tileid, createddate, status', 'safe', 'on'=>'search'),

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

			'trackedTile' => array(self::BELONGS_TO, 'UserFinaoTile', 'tracked_tileid'),

			'trackedUser' => array(self::BELONGS_TO, 'User', 'tracked_userid'),

			'trackerUser' => array(self::BELONGS_TO, 'User', 'tracker_userid'),

		);

	}



	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'tracking_id' => 'Tracking',

			'tracker_userid' => 'Tracker Userid',

			'tracked_userid' => 'Tracked Userid',

			'tracked_tileid' => 'Tracked Tileid',

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



		$criteria->compare('tracking_id',$this->tracking_id);

		$criteria->compare('tracker_userid',$this->tracker_userid);

		$criteria->compare('tracked_userid',$this->tracked_userid);

		$criteria->compare('tracked_tileid',$this->tracked_tileid);

		$criteria->compare('createddate',$this->createddate,true);

		$criteria->compare('status',$this->status);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

		));

	}

}