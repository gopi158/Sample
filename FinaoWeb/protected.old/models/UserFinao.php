<?php



/**

 * This is the model class for table "{{user_finao}}".

 *

 * The followings are the available columns in table '{{user_finao}}':

 * @property integer $user_finao_id

 * @property integer $userid

 * @property string $finao_msg

 * @property integer $finao_status_Ispublic

 * @property string $createddate

 * @property integer $updatedby

 * @property string $updateddate

 * @property integer $finao_status

 *

 * The followings are the available model relations:

 * @property Users $user

 * @property Lookups $finaoStatus

 * @property Users $updatedby0

 */

class UserFinao extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return UserFinao the static model class

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

		return '{{user_finao}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('userid, finao_msg, createddate, updatedby, updateddate', 'required'),

			array('userid, finao_status_Ispublic, updatedby, finao_status, finao_activestatus', 'numerical', 'integerOnly'=>true),

			array('finao_msg', 'length', 'max'=>200),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('user_finao_id, userid, finao_msg, finao_status_Ispublic, createddate, updatedby, updateddate, finao_status, finao_activestatus', 'safe', 'on'=>'search'),

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

			'finaoStatus' => array(self::BELONGS_TO, 'Lookups', 'finao_status'),

			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),

		);

	}



	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'user_finao_id' => 'User Finao',

			'userid' => 'Userid',

			'finao_msg' => 'FINAO',

			'finao_status_Ispublic' => 'Status',

			'createddate' => 'Createddate',

			'updatedby' => 'Updatedby',

			'updateddate' => 'Updateddate',

			'finao_status' => 'Finao Status',

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



		$criteria->compare('user_finao_id',$this->user_finao_id);

		$criteria->compare('userid',$this->userid);

		$criteria->compare('finao_msg',$this->finao_msg,true);

		$criteria->compare('finao_status_Ispublic',$this->finao_status_Ispublic);

		$criteria->compare('createddate',$this->createddate,true);

		$criteria->compare('updatedby',$this->updatedby);

		$criteria->compare('updateddate',$this->updateddate,true);

		$criteria->compare('finao_status',$this->finao_status);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

		));

	}

}