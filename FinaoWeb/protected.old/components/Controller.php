<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */

	public $layout='//layouts/column1';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */

	public $menu=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */

	public $breadcrumbs=array();
	public $allowjs = '';
	public $cdnurl = '';

    public function init()
    {
        $this->cdnurl = Yii::app()->params->cdnUrl;
    }

	public static function getBgimagepath($userbgimage="")

	{

		$bgImagescr = Yii::app()->baseUrl."/images/uploads/backgroundimages" ;

		if($userbgimage != "")

		{

			$bgImagescr .= "/".$userbgimage;

		}

		else

		{

			$bgImagescr .= (isset(Yii::app()->session["login"]["bgImage"])) ?  

								((Yii::app()->session["login"]["bgImage"] != "") ? 

									"/".Yii::app()->session["login"]["bgImage"] : "/../../lacey.jpg" )				

							 : "/../../lacey.jpg" ;	

		}

		

		return $bgImagescr;

	}
	
	public static function getProfilePic()
	{
		$filename = Yii::app()->baseUrl."/images/no-image.jpg";
		if(isset(Yii::app()->session['login']['profImage']) && Yii::app()->session['login']['profImage']!="" ){
			$filename = Yii::app()->baseUrl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];
			if(!file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".Yii::app()->session['login']['profImage']))
			{
				$userprofile = UserProfile::model()->findByAttributes(array('user_id'=>Yii::app()->session['login']['id']));
				$filename = Yii::app()->baseUrl."/images/uploads/profileimages/".$userprofile->profile_image;
				if(!file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userprofile->profile_image))
				{
					$filename = Yii::app()->baseUrl."/images/no-image.jpg";
				}
			}
		}
		return $filename;
	}

	

	public static function getDateFormate($date)

	{

		return date("d-M-Y", strtotime($date));

	}

	public static function getPassedTime($date)

	{

		$difference = strtotime($date) - strtotime(date("Y-m-d H:i:s"));

		$years = abs(floor($difference / 31536000));

		$days = abs(floor(($difference-($years * 31536000))/86400));

		$hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));

		$mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);

		if(intval($years) >=1)

        {

            return intval($years)." years ago";

        }

		if(intval($days) > 0)

        {

            return intval($days)." days ago";

        }

		if(intval($hours) > 0)

        {

            return intval($hours)." hours ago";

        }

		if(intval($mins) > 0)

        {

            return intval($mins)." minutes ago";

        }

		//return "<p>Time Passed: " . $years . " Years, " . $days . " Days, " . $hours . " Hours, " . $mins . " Minutes.</p>";

	}

}
