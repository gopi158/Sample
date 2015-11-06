<?php



/**

 * This is the model class for table "{{uploaddetails}}".

 *

 * The followings are the available columns in table '{{uploaddetails}}':

 * @property integer $uploaddetail_id

 * @property integer $uploadtype

 * @property string $uploadfile_name

 * @property string $uploadfile_path

 * @property integer $upload_sourcetype

 * @property integer $upload_sourceid

 * @property integer $uploadedby

 * @property string $uploadeddate

 * @property integer $status

 * @property integer $updatedby

 * @property string $updateddate

 * @property string $caption

 *

 * The followings are the available model relations:

 * @property Lookups $uploadSourcetype

 * @property Lookups $uploadtype0

 */

class Uploaddetails extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return Uploaddetails the static model class

	 */

	public $cntValue;

	public $uploadsourcetype;

	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}



	/**

	 * @return string the associated database table name

	 */

	public function tableName()

	{

		return '{{uploaddetails}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('uploadtype, uploadfile_name, uploadfile_path, upload_sourcetype, upload_sourceid, uploadedby, uploadeddate, updatedby, updateddate', 'required'),

			array('uploadtype, upload_sourcetype, upload_sourceid, uploadedby, status, updatedby', 'numerical', 'integerOnly'=>true),

			array('uploadfile_name, uploadfile_path', 'length', 'max'=>150),

			array('caption', 'length', 'max'=>100),
			
			array('video_embedurl', 'length', 'max'=>4000),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('uploaddetail_id, uploadtype, uploadfile_name, uploadfile_path, upload_sourcetype, upload_sourceid, uploadedby, uploadeddate, status, updatedby, updateddate, caption', 'safe', 'on'=>'search'),

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

			'uploadSourcetype' => array(self::BELONGS_TO, 'Lookups', 'upload_sourcetype'),

			'uploadtype0' => array(self::BELONGS_TO, 'Lookups', 'uploadtype'),

		);

	}


 
	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'uploaddetail_id' => 'Uploaddetail',

			'uploadtype' => 'Uploadtype',

			'uploadfile_name' => 'Uploadfile Name',

			'uploadfile_path' => 'Uploadfile Path',

			'upload_sourcetype' => 'Upload Sourcetype',

			'upload_sourceid' => 'Upload Sourceid',

			'uploadedby' => 'Uploadedby',

			'uploadeddate' => 'Uploadeddate',

			'status' => 'Status',

			'updatedby' => 'Updatedby',

			'updateddate' => 'Updateddate',

			'caption' => 'Caption',

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



		$criteria->compare('uploaddetail_id',$this->uploaddetail_id);

		$criteria->compare('uploadtype',$this->uploadtype);

		$criteria->compare('uploadfile_name',$this->uploadfile_name,true);

		$criteria->compare('uploadfile_path',$this->uploadfile_path,true);

		$criteria->compare('upload_sourcetype',$this->upload_sourcetype);

		$criteria->compare('upload_sourceid',$this->upload_sourceid);

		$criteria->compare('uploadedby',$this->uploadedby);

		$criteria->compare('uploadeddate',$this->uploadeddate,true);

		$criteria->compare('status',$this->status);

		$criteria->compare('updatedby',$this->updatedby);

		$criteria->compare('updateddate',$this->updateddate,true);

		$criteria->compare('caption',$this->caption,true);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

		));

	}

}