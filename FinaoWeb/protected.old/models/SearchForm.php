<?php


class SearchForm extends CFormModel
{
    public $state;
	public $city;	
	public $schoolname;
	public $zipcode;
	public $distancefrom;
	public $schooltype;
	public $schoolgrade;
	public $schooldistrict;
	public $pagenumber;
	public $datadisplay;
	public $diversity;
	public $stdTeacherRatio;
	/*
		Added on 18122012
		Start:For declaring the activity finder related variables
	*/
	public $minage;
	public $maxage;
	public $days;
	public $seasons;
	public $orgactivites;
	public $interests;
	public $hdnflag;
	//End:For declaring the activity finder related variables
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(  
             //array('state','length', 'max'=>3);
			//array('pagenumber','safe'),
			);
			 	   
				   
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'state' => 'State',
			'city' => 'City',	
			'schoolname' => 'School Name',
			'zipcode' => 'Zip Code',
			'distancefrom' => 'Distance Form',
			'schooltype' => 'School Type',
			'schoolgrade' => 'School Grade',
			'schooldistrict' => 'School District',
        );
    }
 
}

