<?php

/**
 * This is the model class for table "fn_uploaddetails".
 *
 * The followings are the available columns in table 'fn_uploaddetails':
 * @property integer $uploaddetail_id
 * @property integer $uploadtype
 * @property string $upload_text
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
 * @property string $video_caption
 * @property string $videoid
 * @property string $videostatus
 * @property string $video_img
 * @property string $video_embedurl
 * @property integer $explore_finao
 * @property integer $trending
 * @property integer $winner
 */
class Uploaddetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Uploaddetails the static model class
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
		return 'fn_uploaddetails';
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
			array('uploadtype, upload_sourcetype, upload_sourceid, uploadedby, status, updatedby, explore_finao, trending, winner', 'numerical', 'integerOnly'=>true),
			array('uploadfile_name, uploadfile_path', 'length', 'max'=>150),
			array('caption, video_caption', 'length', 'max'=>100),
			array('videoid, videostatus', 'length', 'max'=>20),
			array('video_img', 'length', 'max'=>255),
			array('video_embedurl', 'length', 'max'=>4000),
			array('upload_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uploaddetail_id, uploadtype, upload_text, uploadfile_name, uploadfile_path, upload_sourcetype, upload_sourceid, uploadedby, uploadeddate, status, updatedby, updateddate, caption, video_caption, videoid, videostatus, video_img, video_embedurl, explore_finao, trending, winner', 'safe', 'on'=>'search'),
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
			'uploaddetail_id' => 'Uploaddetail',
			'uploadtype' => 'Uploadtype',
			'upload_text' => 'Upload Text',
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
			'video_caption' => 'Video Caption',
			'videoid' => 'Videoid',
			'videostatus' => 'Videostatus',
			'video_img' => 'Video Img',
			'video_embedurl' => 'Video Embedurl',
			'explore_finao' => 'Explore Finao',
			'trending' => 'Trending',
			'winner' => 'Winner',
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
		$criteria->compare('upload_text',$this->upload_text,true);
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
		$criteria->compare('video_caption',$this->video_caption,true);
		$criteria->compare('videoid',$this->videoid,true);
		$criteria->compare('videostatus',$this->videostatus,true);
		$criteria->compare('video_img',$this->video_img,true);
		$criteria->compare('video_embedurl',$this->video_embedurl,true);
		$criteria->compare('explore_finao',$this->explore_finao);
		$criteria->compare('trending',$this->trending);
		$criteria->compare('winner',$this->winner);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}