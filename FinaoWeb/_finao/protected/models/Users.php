<?php

/**
 * This is the model class for table "fn_users".
 *
 * The followings are the available columns in table 'fn_users':
 * @property integer $userid
 * @property string $password
 * @property string $username
 * @property string $email
 * @property string $secondary_email
 * @property string $activkey
 * @property integer $lastvisit
 * @property integer $superuser
 * @property string $profile_image
 * @property string $fname
 * @property string $lname
 * @property integer $gender
 * @property string $location
 * @property string $description
 * @property string $dob
 * @property string $age
 * @property integer $mageid
 * @property string $socialnetwork
 * @property string $socialnetworkid
 * @property integer $usertypeid
 * @property integer $status
 * @property integer $zipcode
 * @property string $createtime
 * @property integer $createdby
 * @property integer $updatedby
 * @property string $updatedate
 * @property integer $trackid
 *
 * The followings are the available model relations:
 * @property Blogs[] $blogs
 * @property Comments[] $comments
 * @property InviteFriend[] $inviteFriends
 * @property Like[] $likes
 * @property Logactivities[] $logactivities
 * @property Profileview[] $profileviews
 * @property Profileview[] $profileviews1
 * @property Tracking[] $trackings
 * @property Tracking[] $trackings1
 * @property Trackingnotifications[] $trackingnotifications
 * @property Trackingnotifications[] $trackingnotifications1
 * @property Trackingnotifications[] $trackingnotifications2
 * @property UserFinao[] $userFinaos
 * @property UserFinao[] $userFinaos1
 * @property UserFinaoJournal[] $userFinaoJournals
 * @property UserFinaoJournal[] $userFinaoJournals1
 * @property UserFinaoTile[] $userFinaoTiles
 * @property UserFinaoTile[] $userFinaoTiles1
 * @property UserFinaoTile[] $userFinaoTiles2
 * @property UserProfile[] $userProfiles
 * @property UserProfile[] $userProfiles1
 * @property Lookups $gender0
 * @property Lookups $usertype
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fn_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, username, email, dob, mageid, zipcode, createtime, createdby', 'required'),
			array('lastvisit, superuser, gender, mageid, usertypeid, status, zipcode, createdby, updatedby, trackid', 'numerical', 'integerOnly'=>true),
			array('password, email, secondary_email, activkey', 'length', 'max'=>128),
			array('username', 'length', 'max'=>55),
			array('profile_image', 'length', 'max'=>750),
			array('fname, lname, location', 'length', 'max'=>100),
			array('description', 'length', 'max'=>500),
			array('age', 'length', 'max'=>20),
			array('socialnetwork', 'length', 'max'=>45),
			array('socialnetworkid', 'length', 'max'=>150),
			array('updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, password, username, email, secondary_email, activkey, lastvisit, superuser, profile_image, fname, lname, gender, location, description, dob, age, mageid, socialnetwork, socialnetworkid, usertypeid, status, zipcode, createtime, createdby, updatedby, updatedate, trackid', 'safe', 'on'=>'search'),
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
			'blogs' => array(self::HAS_MANY, 'Blogs', 'createdby'),
			'comments' => array(self::HAS_MANY, 'Comments', 'comment_author_id'),
			'inviteFriends' => array(self::HAS_MANY, 'InviteFriend', 'invited_by_user_id'),
			'likes' => array(self::HAS_MANY, 'Like', 'user_id'),
			'logactivities' => array(self::HAS_MANY, 'Logactivities', 'userid'),
			'profileviews' => array(self::HAS_MANY, 'Profileview', 'viewed_userid'),
			'profileviews1' => array(self::HAS_MANY, 'Profileview', 'viewer_userid'),
			'trackings' => array(self::HAS_MANY, 'Tracking', 'tracked_userid'),
			'trackings1' => array(self::HAS_MANY, 'Tracking', 'tracker_userid'),
			'trackingnotifications' => array(self::HAS_MANY, 'Trackingnotifications', 'createdby'),
			'trackingnotifications1' => array(self::HAS_MANY, 'Trackingnotifications', 'tracker_userid'),
			'trackingnotifications2' => array(self::HAS_MANY, 'Trackingnotifications', 'updateby'),
			'userFinaos' => array(self::HAS_MANY, 'UserFinao', 'updatedby'),
			'userFinaos1' => array(self::HAS_MANY, 'UserFinao', 'userid'),
			'userFinaoJournals' => array(self::HAS_MANY, 'UserFinaoJournal', 'createdby'),
			'userFinaoJournals1' => array(self::HAS_MANY, 'UserFinaoJournal', 'updatedby'),
			'userFinaoTiles' => array(self::HAS_MANY, 'UserFinaoTile', 'createdby'),
			'userFinaoTiles1' => array(self::HAS_MANY, 'UserFinaoTile', 'updatedby'),
			'userFinaoTiles2' => array(self::HAS_MANY, 'UserFinaoTile', 'userid'),
			'userProfiles' => array(self::HAS_MANY, 'UserProfile', 'createdby'),
			'userProfiles1' => array(self::HAS_MANY, 'UserProfile', 'updatedby'),
			'gender0' => array(self::BELONGS_TO, 'Lookups', 'gender'),
			'usertype' => array(self::BELONGS_TO, 'Lookups', 'usertypeid'),
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
			'username' => 'username',
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
			'description' => 'Description',
			'dob' => 'Dob',
			'age' => 'Age',
			'mageid' => 'Mageid',
			'socialnetwork' => 'Socialnetwork',
			'socialnetworkid' => 'Socialnetworkid',
			'usertypeid' => 'Usertypeid',
			'status' => 'Status',
			'zipcode' => 'Zipcode',
			'createtime' => 'Createtime',
			'createdby' => 'Createdby',
			'updatedby' => 'Updatedby',
			'updatedate' => 'Updatedate',
			'trackid' => 'Trackid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('userid',$this->userid);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('username',$this->username,true);
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('mageid',$this->mageid);
		$criteria->compare('socialnetwork',$this->socialnetwork,true);
		$criteria->compare('socialnetworkid',$this->socialnetworkid,true);
		$criteria->compare('usertypeid',$this->usertypeid);
		$criteria->compare('status',$this->status);
		$criteria->compare('zipcode',$this->zipcode);
		$criteria->compare('createtime',$this->createtime,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('trackid',$this->trackid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
