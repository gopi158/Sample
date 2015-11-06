<?php



/**

 * This is the model class for table "{{trackingnotifications}}".

 *

 * The followings are the available columns in table '{{trackingnotifications}}':

 * @property integer $trackingnotification_id

 * @property integer $tracker_userid

 * @property integer $tile_id

 * @property integer $finao_id

 * @property integer $journal_id

 * @property integer $notification_action

 * @property integer $updateby

 * @property string $updateddate

 * @property integer $createdby

 * @property string $createddate

 *

 * The followings are the available model relations:

 * @property Users $trackerUser

 * @property UserFinaoTile $tile

 * @property Users $updateby0

 * @property Users $createdby0

 * @property Lookups $notificationAction

 */

class Trackingnotifications extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return Trackingnotifications the static model class

	 */

	public $finao_msg; 

	public $finaostatus;

	public $finaoupdateddate;

	public $fname;

	public $lname;

	public $lookup_name;

	public $tile_id;

	

	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}



	/**

	 * @return string the associated database table name

	 */

	public function tableName()

	{

		return '{{trackingnotifications}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('tracker_userid, tile_id, notification_action, updateby, updateddate, createdby, createddate', 'required'),

			array('tracker_userid, tile_id, finao_id, journal_id, notification_action, updateby, createdby', 'numerical', 'integerOnly'=>true),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('trackingnotification_id, tracker_userid, tile_id, finao_id, journal_id, notification_action, updateby, updateddate, createdby, createddate', 'safe', 'on'=>'search'),

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

			'trackerUser' => array(self::BELONGS_TO, 'User', 'tracker_userid'),

			'tile' => array(self::BELONGS_TO, 'UserFinaoTile', 'tile_id'),

			'updateby0' => array(self::BELONGS_TO, 'User', 'updateby'),

			'createdby0' => array(self::BELONGS_TO, 'User', 'createdby'),

			'notificationAction' => array(self::BELONGS_TO, 'Lookups', 'notification_action'),

		);

	}



	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'trackingnotification_id' => 'Trackingnotification',

			'tracker_userid' => 'Tracker Userid',

			'tile_id' => 'Tile',

			'finao_id' => 'Finao',

			'journal_id' => 'Journal',

			'notification_action' => 'Notification Action',

			'updateby' => 'Updateby',

			'updateddate' => 'Updateddate',

			'createdby' => 'Createdby',

			'createddate' => 'Createddate',

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



		$criteria->compare('trackingnotification_id',$this->trackingnotification_id);

		$criteria->compare('tracker_userid',$this->tracker_userid);

		$criteria->compare('tile_id',$this->tile_id);

		$criteria->compare('finao_id',$this->finao_id);

		$criteria->compare('journal_id',$this->journal_id);

		$criteria->compare('notification_action',$this->notification_action);

		$criteria->compare('updateby',$this->updateby);

		$criteria->compare('updateddate',$this->updateddate,true);

		$criteria->compare('createdby',$this->createdby);

		$criteria->compare('createddate',$this->createddate,true);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

		));

	}

}