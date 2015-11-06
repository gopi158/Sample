<?php


class UserImportForm extends CFormModel
{
    public $file;
	public $title;
	public $keyword;
	public $description;
	
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(  
             array('file', 'file', 
                                            'types'=>'flv ,mov ,dat, mp3, mp4',
                                            //'maxSize'=>1024 * 1024 * 10, // 10MB
                                            //'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
                                            'allowEmpty' => false
                              ),
                   );
			 //array('state,school,schoolorscore','length', 'max'=>2);
			 	   
				   
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'file' => 'Select file to Upload',
			'keyword' => 'Keyword',
			'description'=>'Description',
			'title' => 'Title',
        );
    }
 
}

