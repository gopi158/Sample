<?php



/**

 * This is the model class for table "{{users}}".

 *

 * The followings are the available columns in table '{{users}}':

 * @property integer $userid

 * @property string $password

 * @property string $email

 * @property string $activkey

 * @property integer $lastvisit

 * @property integer $superuser

 * @property string $profile_image

 * @property string $fname

 * @property string $lname

 * @property integer $gender

 * @property string $location

 * @property string $age

 * @property string $mageid
 
 * @property string $socialnetwork

 * @property string $socialnetworkid

 * @property integer $usertypeid

 * @property integer $status

 * @property integer $zipcode

 * @property string $createtime

 * @property integer $createdby

 * @property integer $updatedby

 * @property string $updatedate

 *

 * The followings are the available model relations:

 * @property Address[] $addresses

 * @property Address[] $addresses1

 * @property EduPlanLongterm[] $eduPlanLongterms

 * @property EduPlanTasks[] $eduPlanTasks

 * @property LoginHistory[] $loginHistories

 * @property UserChild[] $userChildren

 * @property UserChild[] $userChildren1

 * @property UserChildInterests[] $userChildInterests

 * @property UserChildInterests[] $userChildInterests1

 * @property Lookups $gender0

 * @property Lookups $usertype

 */

class User extends CActiveRecord

{

	/**

	 * Returns the static model of the specified AR class.

	 * @param string $className active record class name.

	 * @return User the static model class

	 */

	public $verifyCode;

	public $sbstr;

	public $image;

	public $datadisplay;

	public $usrid;

	public $selectedInterest;

	/*

		Added on 21122012

		for getting the organization namespace

	*/

	public $name;
	public $gptilename;
	//Ended on 21122012

	public static function model($className=__CLASS__)

	{

		return parent::model($className);

	}



	/**

	 * @return string the associated database table name

	 */

	public function tableName()

	{

		return '{{users}}';

	}



	/**

	 * @return array validation rules for model attributes.

	 */

	public function rules()

	{

		// NOTE: you should only define rules for those attributes that

		// will receive user inputs.

		return array(

			array('password, email, createtime, createdby', 'required'),

			array('lastvisit, superuser, gender, usertypeid, status, zipcode, createdby, updatedby, mageid', 'numerical', 'integerOnly'=>true),

			array('password, uname, email, activkey, secondary_email', 'length', 'max'=>128),//Changed by varma on 28022013

			array('profile_image', 'length', 'max'=>750),

			array('description', 'length', 'max'=>500),

			array('fname, lname, location', 'length', 'max'=>100),

			array('age', 'length', 'max'=>20),

			array('socialnetwork, socialnetworkid', 'length', 'max'=>45),

			array('updatedate,dob', 'safe'),//Changed by varma on 28022013

			array('image', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'),

			// The following rule is used by search().

			// Please remove those attributes that should not be searched.

			array('userid, password, email, secondary_email, activkey, lastvisit, superuser, profile_image, fname, lname, gender, location, description, age, socialnetwork, socialnetworkid, usertypeid, status, zipcode, createtime, createdby, updatedby, updatedate, mageid', 'safe', 'on'=>'search'),

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

			'addresses' => array(self::HAS_MANY, 'Address', 'createdby'),

			'addresses1' => array(self::HAS_MANY, 'Address', 'userid'),

			'eduPlanLongterms' => array(self::HAS_MANY, 'EduPlanLongterm', 'userid'),

			'eduPlanTasks' => array(self::HAS_MANY, 'EduPlanTasks', 'createdby'),

			'loginHistories' => array(self::HAS_MANY, 'LoginHistory', 'userid'),

			'userChildren' => array(self::HAS_MANY, 'UserChild', 'createdby'),

			'userChildren1' => array(self::HAS_MANY, 'UserChild', 'userid'),

			'userChildInterests' => array(self::HAS_MANY, 'UserChildInterests', 'userid'),

			'userChildInterests1' => array(self::HAS_MANY, 'UserChildInterests', 'createdby'),

			'gender0' => array(self::BELONGS_TO, 'Lookups', 'gender'),

			/*'usertype' => array(self::BELONGS_TO, 'Lookups', 'usertypeid'),*/
			
			'tags'=>array(self::HAS_MANY,'FinaoTagnote','user_id'),

		);

	}



	/**

	 * @return array customized attribute labels (name=>label)

	 */

	public function attributeLabels()

	{

		return array(

			'userid' => 'Userid',

			'password' => 'Password',

			'email' => 'Email',

			'secondary_email' => 'Secondary Email',

			'activkey' => 'Activkey',

			'lastvisit' => 'Lastvisit',

			'superuser' => 'Superuser',

			'profile_image' => 'Profile Image',

			'fname' => 'Fname',

			'lname' => 'Lname',

			'gender' => 'Gender',

			'location' => 'Location',

			'age' => 'Age',
			
			'mageid' => 'Magento Id',

			'socialnetwork' => 'Socialnetwork',

			'socialnetworkid' => 'Socialnetworkid',

			'usertypeid' => 'Usertypeid',

			'status' => 'Status',

			'zipcode' => 'Zipcode',

			'createtime' => 'Createtime',

			'createdby' => 'Createdby',

			'updatedby' => 'Updatedby',

			'updatedate' => 'Updatedate',

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



		$criteria->compare('userid',$this->userid);

		$criteria->compare('password',$this->password,true);

		$criteria->compare('uname',$this->uname,true);//Added by varma on 27022013

		$criteria->compare('email',$this->email,true);

		$criteria->compare('secondary_email',$this->secondary_email,true);

		$criteria->compare('activkey',$this->activkey,true);

		$criteria->compare('lastvisit',$this->lastvisit);

		$criteria->compare('superuser',$this->superuser);

		$criteria->compare('profile_image',$this->profile_image,true);

		$criteria->compare('fname',$this->fname,true);

		$criteria->compare('lname',$this->lname,true);

		$criteria->compare('gender',$this->gender);

		$criteria->compare('location',$this->location,true);

		$criteria->compare('dob',$this->dob,true);//Added by varma on 27032013

		$criteria->compare('age',$this->age,true);
		
		$criteria->compare('mageid',$this->mageid,true);

		$criteria->compare('socialnetwork',$this->socialnetwork,true);

		$criteria->compare('socialnetworkid',$this->socialnetworkid,true);

		$criteria->compare('usertypeid',$this->usertypeid);

		$criteria->compare('status',$this->status);

		$criteria->compare('zipcode',$this->zipcode);

		$criteria->compare('createtime',$this->createtime,true);

		$criteria->compare('createdby',$this->createdby);

		$criteria->compare('updatedby',$this->updatedby);

		$criteria->compare('updatedate',$this->updatedate,true);



		return new CActiveDataProvider($this, array(

			'criteria'=>$criteria,

		));

	}

}