<?php
class ProfileController extends Controller
{
    public function actionProfilelanding()
    {
        //$this->allowjs = "allowminjs";
        if (isset(Yii::app()->session['login'])) {
            $userid = Yii::app()->session['login']['id'];
        } else {
            $this->redirect(array(
                '/'
            ));
        }
		$tileid = '';
		if(isset($_REQUEST['tileid']))
		{
			$tileid = $_REQUEST['tileid'];
		}
		
        $newprofile = UserProfile::model()->findByAttributes(array(
            'user_id' => $userid
        ));
        if (isset($newprofile)) {
            $newprofile->updatedby   = $userid;
            $newprofile->updateddate = date('Y-m-d G:i:s');
        } else {
            $newprofile              = new UserProfile;
            $newprofile->createdby   = $userid;
            $newprofile->createddate = date('Y-m-d G:i:s');
            $newprofile->updatedby   = $userid;
            $newprofile->updateddate = date('Y-m-d G:i:s');
        }
        if (isset($_POST['UserProfile'])) {
            // print_r($_POST);exit;
            $newprofile = UserProfile::model()->findByAttributes(array(
                'user_id' => $_POST['UserProfile']['user_id']
            ));
            if (isset($newprofile)) {
                $newprofile->updatedby   = $_POST['UserProfile']['user_id'];
                $newprofile->updateddate = date('Y-m-d G:i:s');
                if($tileid == 77)
				{
					$redirect = "tile";
				}
				else
				{
					$redirect = "profile";
				}
				                
            } else {
                $newprofile              = new UserProfile;
                $newprofile->createdby   = $_POST['UserProfile']['user_id'];
                $newprofile->createddate = date('Y-m-d G:i:s');
                $newprofile->updatedby   = $_POST['UserProfile']['user_id'];
                $newprofile->updateddate = date('Y-m-d G:i:s');
                $redirect                = "newfinao";
            }
            $newprofile->user_id     = $_POST['UserProfile']['user_id'];
            $newprofile->attributes  = $_POST['UserProfile'];
            $newprofile->IsCompleted = "saved";
            $newprofile->save(false);
            $dateOB = "";
            if ($_POST['UserProfile']['dob'] != '0000-00-00') {
                //	$datevalue = (stripos($_POST['UserProfile']['dob'],"-") > 0) ? explode("-",$_POST['UserProfile']['dob']) : "";
                //echo $datevalue[1];exit;
                //if($datevalue != "")
                //{
                $dateOB = date('Y-m-d H:i:s', strtotime($_POST['date_dat'] . "-" . $_POST['date_mon'] . "-" . $_POST['date_year'])); //echo $dateOB;exit;
                //}
            } else {
                $dateOB = date('Y-m-d H:i:s', strtotime($_POST['date_dat'] . "-" . $_POST['date_mon'] . "-" . $_POST['date_year']));
            }
            $user             = User::model()->findByPk($_POST['UserProfile']['user_id']);
            $user->dob        = $dateOB;
            //echo $dateOB;exit;
            $user->fname      = $_POST['UserProfile']['fname'];
            $user->lname      = $_POST['UserProfile']['lname'];
            $user->zipcode    = $_POST['UserProfile']['zpcode'];
            $user->updatedby  = $_POST['UserProfile']['user_id'];
            $user->updatedate = new CDbExpression('NOW()'); //date('Y-m-d G:i:s');
            $user->save(false);
           //echo $redirect;exit;
		   if ($redirect == "newfinao")
                $this->redirect(array(
                    'profile/newfinao'
                ));
            elseif ($redirect == "profile")
                $this->redirect(array(
                    'finao/motivationmesg'
                ));
			elseif ($redirect == "tile")
			$result = GroupTracking::model()->findByAttributes(array('tracker_userid'=>Yii::app()->session['login']['id'],'tracked_groupid'=>5,'tracked_userid'=>255)); 
			 if(!$result)
			 {
				$track = new GroupTracking;
				$track->tracker_userid = Yii::app()->session['login']['id'];
				$track->tracked_groupid = 5;
				$track->tracked_userid = 255;
				$track->createddate = new CDbExpression('NOW()');
				$track->status = 1;
				$track->save(false);
				 
			 }
                $this->redirect(array(
                    'group/Dashboard?groupid=5&frndid=255&share=no&share_value=0'
                ));
				
        }
        $logeduser = User::model()->findByPk(Yii::app()->session['login']['id']);
        if (isset($_REQUEST['url']) && $_REQUEST['url'] == 'logedfbreg') {
            $userinfo = Yii::app()->facebook->api('/me');
            if (isset($_REQUEST['error_reason']) && ($_REQUEST['error_reason'] == 'user_denied')) {
                Yii::app()->user->setFlash('fbusererror', 'You are NOT LOGGED IN.You must allow basic permission access to Login from facebook');
                $this->redirect(array(
                    '/'
                ));
            }
            $logeduser->socialnetworkid = $userinfo['id'];
            $logeduser->socialnetwork   = "facebook";
            $logeduser->save(false);
            $track         = "track";
            $invitefriends = "invitefriends";
        } else {
            $invitefriends = "";
        }
        if (isset($_REQUEST['edit'])) {
            $edit = $_REQUEST['edit'];
        } else {
            $edit = "";
        }
        $this->render('profilelanding', array(
            'userprofile' => $newprofile,
            'userid' => $userid,
            'invitefriends' => $invitefriends,
            'logeduser' => $logeduser,
            'edit' => $edit,
			'tileid'=>$tileid,
            'Imgupload' => (isset($_REQUEST['Imagupload']) ? $_REQUEST['Imagupload'] : 0),
            'errormsg' => ((isset($_REQUEST['errormsg']) && $_REQUEST['errormsg'] == 1) ? "1" : "")
        ));
    }
    public function actionShare()
    {
        $finao_id      = $_REQUEST['finaoid'];
        $user_id       = $_REQUEST['userid'];
        $frend_id      = $_REQUEST['frendid'];
        $media_id      = $_REQUEST['mediaid'];
        $mediaimage_id = $_REQUEST['mediaimageid'];
        $share_id      = $_REQUEST['shareid'];
        //echo $mediaimage_id;die();
        if ($_REQUEST['frendid']) {
            $getfrenddtls = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id', array(
                ':id' => $frend_id
            ))->queryRow();
        }
        if (isset($_REQUEST['mediaid'])) {
            $displayvideo      = Yii::app()->db->createCommand()->select('*')->from('fn_uploaddetails')->where('uploaddetail_id=:id', array(
                ':id' => $media_id
            ))->queryRow();
            $finaovideoid      = $displayvideo['upload_sourceid'];
            $finaovideoprofile = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finaovideoid
            ))->queryRow();
            $displayvideo1     = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $displayvideo2     = Yii::app()->db->createCommand()->select('*')->from('fn_user_profile')->where('user_id=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $displayvideo3     = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finao_id
            ))->queryRow();
            $this->renderPartial('_share', array(
                'displayvideo' => $displayvideo,
                'displayvideo1' => $displayvideo1,
                'displayvideo2' => $displayvideo2,
                'displayvideo3' => $displayvideo3,
                'finaovideoprofile' => $finaovideoprofile,
                'getfrenddtls' => $getfrenddtls,
                'shareid' => $share_id,
                'view' => 'displayvideo'
            ));
            //print_r($displayvideo);
        } else if (isset($_REQUEST['finaoid'])) {
            $result    = Yii::app()->db->createCommand()->select('*')->from('fn_user_profile')->where('user_id=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $result1   = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finao_id
            ))->queryRow();
            $result3   = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id1', array(
                ':id1' => $user_id
            ))->queryRow();
            $result2   = Yii::app()->db->createCommand()->select('*')->from('fn_uploaddetails')->where('upload_sourceid=:id', array(
                ':id' => $finao_id
            ))->queryRow();
            $frendinfo = Yii::app()->db->createCommand()->select('*')->from('fn_user_profile')->where('user_id=:id1', array(
                ':id1' => $frend_id
            ))->queryRow();
            $this->renderPartial('_share', array(
                'finaosuserprofile' => $result,
                'finaoprofile' => $result1,
                'finaoprofilenames' => $result3,
                'uploaddetails' => $result2,
                'getfrenddtls' => $getfrenddtls,
                'frendinfo' => $frendinfo,
                'shareid' => $share_id,
                'view' => 'displayfinao'
            ));
        } else if (isset($_REQUEST['mediaimageid'])) {
            $displayimage      = Yii::app()->db->createCommand()->select('*')->from('fn_uploaddetails')->where('uploaddetail_id=:id', array(
                ':id' => $mediaimage_id
            ))->queryRow();
            //print_r($displayimage);die();
            $finaoid           = $displayimage['upload_sourceid'];
            //echo $finaoid;die();
            $displayimage1     = Yii::app()->db->createCommand()->select('*')->from('fn_user_profile')->where('user_id=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $displayimage2     = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $finaoimageprofile = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finaoid
            ))->queryRow();
            //print_r($finaoimageprofile);die();
            //print_r($displayimage1);die();
            $this->renderPartial('_share', array(
                'displayimage' => $displayimage,
                'displayimage1' => $displayimage1,
                'displayimage2' => $displayimage2,
                'finaoimageprofile' => $finaoimageprofile,
                'getfrenddtls' => $getfrenddtls,
                'shareid' => $share_id,
                'view' => 'displayimage'
            ));
        }
    }
    public function actionChangePic()
    {
        //print_r($_POST);exit;
        /*echo "hiiiii";
        
        
        
        exit;*/
        $id = Yii::app()->session['login']['id'];
        if (isset($_REQUEST['edit'])) {
            $edit = $_REQUEST['edit'];
        } else {
            $edit = "";
        }
        $model = UserProfile::model()->findByAttributes(array(
            'user_id' => $id
        ));
        if (empty($model)) {
            $model              = new UserProfile;
            $model->createdby   = $id;
            $model->createddate = date('Y-m-d G:i:s');
            $model->updatedby   = $id;
            $model->updateddate = date('Y-m-d G:i:s');
        } else {
            $model->updatedby   = $id;
            $model->updateddate = date('Y-m-d G:i:s');
        }
        $name                      = $_FILES['file']['tmp_name'];
        $b                         = Yii::getPathOfAlias('application');
        $c                         = str_replace('protected', 'images/uploads/temp_profileimages', $b);
        $numb                      = rand();
        //$model->profile_image = $id."-".str_replace(' ','',$_FILES["file"]["name"]);
        $model->temp_profile_image = $id . "-" . $numb . str_replace(' ', '', $_FILES["file"]["name"]);
        $model->user_id            = $id;
        $model->save(false);
        //print_r($model->image_name);
        //exit;
        move_uploaded_file($_FILES["file"]["tmp_name"], $c . "/" . $id . "-" . $numb . str_replace(' ', '', $_FILES["file"]["name"]));
        chmod($c . "/" . $id . "-" . $numb . str_replace(' ', '', $_FILES["file"]["name"]), 0777);
        $dfolder  = str_replace('protected', 'images/uploads/profileimages', $b);
        $filename = Yii::app()->basePath . '/../' . "images/uploads/temp_profileimages/" . $model->temp_profile_image;
        list($sourceWidth, $sourceHeight) = getimagesize($filename);
        if ($sourceWidth >= 140 && $sourceHeight >= 140) {
            if ($sourceWidth == 140 && $sourceHeight == 140) {
                $this->profileimageresizeandcopy($c . "/" . $id . "-" . $numb . str_replace(' ', '', $_FILES["file"]["name"]), $dfolder . "/" . $id . "-" . $numb . str_replace(' ', '', $_FILES["file"]["name"]), $id . "-" . str_replace(' ', '', $_FILES["file"]["name"]));
                if ($edit == 1) {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding/edit/1'));
                } else if ($edit == 2) {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding/edit/2'));
                } else {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding'));
                }
            } else {
                if ($sourceWidth > 480) {
                    $ext = substr(strrchr($model->temp_profile_image, '.'), 1);
                    $ext = strtolower($ext);
                    FinaoController::createImagetofixbodysize(Yii::app()->basePath . "/../images/uploads/temp_profileimages/" . $model->temp_profile_image, 480, $ext);
                }
                if ($edit == 1) {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding/edit/1', array(
                        'Imagupload' => 1
                    )));
                } else if ($edit == 2) {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding/edit/2', array(
                        'Imagupload' => 1
                    )));
                } else {
                    $this->redirect(Yii::app()->createUrl('profile/profilelanding', array(
                        'Imagupload' => 1
                    )));
                }
                //$this->redirect(Yii::app()->createUrl('profile/profilelanding',array('Imagupload'=>1)));
            }
        } else if ($edit == 1) {
            $this->redirect(Yii::app()->createUrl('profile/profilelanding', array(
                'edit' => $edit,
                'errormsg' => '1'
            )));
        } else {
            $this->redirect(Yii::app()->createUrl('finao/motivationmesg', array(
                'edit' => $edit,
                'errormsg' => '2'
            )));
        }
        //}
    }
    public function actionChangeBgPic()
    {
        $id    = Yii::app()->session['login']['id'];
        $model = UserProfile::model()->findByAttributes(array(
            'user_id' => $id
        ));
        if (empty($model)) {
            $model              = new UserProfile;
            $model->createdby   = $id;
            $model->createddate = date('Y-m-d G:i:s');
            $model->updatedby   = $id;
            $model->updateddate = date('Y-m-d G:i:s');
        } else {
            if ($model->profile_bg_image != "") {
                //$images = glob("images/uploads/backgroundimages/'".$model->profile_bg_image."'");
                //echo $images;
                //exit;
                if (file_exists("images/uploads/backgroundimages/" . $model->profile_bg_image))
                    unlink("images/uploads/backgroundimages/" . $model->profile_bg_image);
            }
            $model->updatedby   = $id;
            $model->updateddate = date('Y-m-d G:i:s');
        }
        $name                    = $_FILES['file']['tmp_name'];
        $b                       = Yii::getPathOfAlias('application');
        $c                       = str_replace('protected', 'images/uploads/backgroundimages', $b);
        $model->profile_bg_image = $id . "-" . str_replace(' ', '', $_FILES["file"]["name"]);
        $model->user_id          = $id;
        if ($model->save(false)) {
            $login                       = Yii::app()->session['login'];
            $login["bgImage"]            = $model->profile_bg_image;
            Yii::app()->session['login'] = $login;
        }
        //print_r($model->image_name);
        //exit;
        move_uploaded_file($_FILES["file"]["tmp_name"], $c . "/" . $id . "-" . str_replace(' ', '', $_FILES["file"]["name"]));
        chmod($c . "/" . $id . "-" . str_replace(' ', '', $_FILES["file"]["name"]), 0777);
        $img   = "images/uploads/backgroundimages/" . $model->profile_bg_image;
        $image = Yii::app()->image->load($img);
        //$image->resize(800, 600);
        if ($image->save("images/uploads/backgroundimages/" . $model->profile_bg_image)) {
            //echo Yii::app()->request->baseUrl."/images/uploads/backgroundimages/".$model->profile_bg_image ;
        }
        $this->redirect(array(
            'profile/profilelanding'
        ));
    }
    public function actionIsSkip()
    {
        $userid     = Yii::app()->session['login']['id'];
        $newprofile = UserProfile::model()->findByAttributes(array(
            'user_id' => $userid
        ));
        if (isset($newprofile)) {
            $newprofile->updatedby   = $userid;
            $newprofile->updateddate = date('Y-m-d G:i:s');
        } else {
            $newprofile              = new UserProfile;
            $newprofile->user_id     = $userid;
            $newprofile->createdby   = $userid;
            $newprofile->createddate = date('Y-m-d G:i:s');
            $newprofile->updatedby   = $userid;
            $newprofile->updateddate = date('Y-m-d G:i:s');
        }
        $skip                    = $_POST['skip'];
        $newprofile->IsCompleted = $skip;
        $newprofile->save(false);
        $finaos = UserFinao::model()->findByAttributes(array(
            'userid' => $userid
        ));
        if (isset($finaos))
            echo "motivationmesg";
        else
            echo "newfinao";
    }
    public function actionViewProfile()
    {
        $userid      = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];
        $userinfo    = User::model()->findByPk($userid);
        $profileinfo = UserProfile::model()->findByAttributes(array(
            'user_id' => $userid
        ));
        if (!empty($profileinfo)) {
            if ($profileinfo->profile_image != "") {
                $src = Yii::app()->baseUrl . '/images/uploads/profileimages/' . $profileinfo->profile_image;
                if (!file_exists(Yii::app()->basePath . '/../images/uploads/profileimages/' . $profileinfo->profile_image)) {
                    $src = Yii::app()->baseUrl . '/images/no-image.jpg';
                }
            } else {
                $src = Yii::app()->baseUrl . '/images/no-image.jpg';
            }
        } else {
            $src = Yii::app()->baseUrl . '/images/no-image.jpg';
        }
        echo '<span>







				<img src="' . $src . '" width="50" height="50" class="left" style="margin-right:8px;" />







			  </span>







			  <span class="font-14px" style="line-height:25px;">' . ucfirst($userinfo->fname) . ' <br />' . ucfirst($userinfo->lname) . '</span>';
    }
    public function getUserProfile($userid, $share)
    {
        $userinfo            = User::model()->findByPk($userid);
        $profileinfo         = UserProfile::model()->findByAttributes(array(
            'user_id' => $userid
        ));
        $Criteria            = new CDbCriteria();
        $Criteria->condition = "userid = '" . $userid . "' and finao_activestatus = 1 and IsGroup = 0";
        if ($userid == Yii::app()->session['login']['id'] && $share != "share") {
            $Criteria->addCondition("Iscompleted = 0", "AND");
        }
        if ((isset($share) && $share == "share") || $userid != Yii::app()->session['login']['id']) {
            $Criteria->addCondition("finao_status_Ispublic = 1", "AND");
            //$Criteria->addCondition("Iscompleted = 1","OR");
        }
        $Criteria->order = "updateddate DESC";
        $finaos          = UserFinao::model()->findAll($Criteria);
        $latestfinao     = UserFinao::model()->find(array(
            'condition' => 'userid = ' . $userid . ' AND Iscompleted = 0 order by updateddate DESC'
        ));
        if (!empty($finaos)) {
            $Criteria            = new CDbCriteria();
            $Criteria->group     = 'tile_id';
            $Criteria->condition = "userid = '" . $userid . "'";
            $Criteria->select    = "t1.tilename , t1.tile_imageurl , t1.Is_customtile, t.* ";
            if (!empty($finaos)) {
                foreach ($finaos as $finaoids):
                    $ids[] = $finaoids->user_finao_id;
                endforeach;
            }
            if (!empty($ids))
                $Criteria->addInCondition('finao_id', $ids);
            $Criteria->order = 'createddate DESC';
            $Criteria->join  = " left join fn_tilesinfo t1 on t.tile_id = t1.tile_id and t.userid = t1.createdby ";
            $tilesinfo       = UserFinaoTile::model()->findAll($Criteria);
        } else {
            $tilesinfo = "";
        }
        return array(
            'userid' => $userid,
            'userinfo' => $userinfo,
            'profileinfo' => $profileinfo,
            'finao' => $latestfinao,
            'tilesinfo' => $tilesinfo
        );
    }
    public function actionUserProfile()
    {
        $userid        = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];
        $share         = "";
        $userprofarray = $this->getUserProfile($userid, $share);
        $this->renderPartial('_userprofile', array(
            'userid' => $userprofarray['userid'],
            'userinfo' => $userprofarray['userinfo'],
            'profileinfo' => $userprofarray['profileinfo'],
            'finao' => $userprofarray['finao'],
            'tilesinfo' => $userprofarray['tilesinfo']
        ));
    }
    public function actionCropImage()
    {
        $t_width  = 240; // Maximum thumbnail width
        $t_height = 240; // Maximum thumbnail height
        //$new_name = "small".$session_id.".jpg"; // Thumbnail image name
        $path     = Yii::getPathOfAlias('webroot') . "/images/uploads/temp_profileimages/";
        $path1    = Yii::getPathOfAlias('webroot') . "/images/uploads/temp_profileimages/thumbs/";
        if (isset($_GET['t']) and $_GET['t'] == "ajax") {
            extract($_GET);
            $ratio   = ($t_width / $w);
            $nw      = ceil($w * $ratio);
            $nh      = ceil($h * $ratio);
            $nimg    = imagecreatetruecolor($nw, $nh);
            $fileext = strtolower($fileext);
            /*switch($fileext)
            
            
            
            {
            
            
            
            case 'jpeg':
            
            
            
            case 'jpg':
            
            
            
            $im_src = imagecreatefromjpeg($path.$img);
            
            
            
            break;
            
            
            
            case 'png':
            
            
            
            $im_src = imagecreatefrompng($path.$img);
            
            
            
            break;
            
            
            
            }
            
            
            
            
            
            
            
            //$im_src = imagecreatefromjpeg($path.$img);
            
            
            
            imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
            
            
            
            imagejpeg($nimg,$path.$img,90);*/
            $size    = getimagesize($path . $img);
            switch ($size['mime']) {
                case "image/gif":
                    break;
                case "image/jpeg":
                    $im_src = imagecreatefromjpeg($path . $img);
                    break;
                case "image/png":
                    $im_src = imagecreatefrompng($path . $img);
                    break;
                case "image/bmp":
                    break;
            }
            //mysql_query("UPDATE users SET profile_image_small='$new_name' WHERE uid='$session_id'");
            imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w, $h);
            //imagejpeg($nimg,$path.$img,90);
            /*switch(strtolower($mime_type)) {
            
            case 'image/gif':
            
            imagegif($nimg,$path.$img,90);
            
            break;
            
            case 'image/png':
            
            imagepng($nimg,$path.$img,9);
            
            break;
            
            case 'image/jpeg':
            
            imagejpeg($nimg,$path.$img,90);
            
            break;
            
            }*/
            switch ($size['mime']) {
                case "image/gif":
                    imagegif($nimg, $path . $img, 90);
                    break;
                case "image/jpeg":
                    imagejpeg($nimg, $path . $img, 90);
                    break;
                case "image/png":
                    imagepng($nimg, $path . $img, 9);
                    break;
            }
            $filename = $path . $img;
            list($sourceWidth, $sourceHeight) = getimagesize($filename);
            if ($sourceWidth > 240 && $sourceHeight > 240) {
                $img   = "images/uploads/temp_profileimages/" . $img;
                $image = Yii::app()->image->load($img);
                $image->resize(240, 240);
                $image->save("images/uploads/temp_profileimages/" . $img);
            }
            $this->profileimageresizeandcopy($path . $img, Yii::app() - basePath . "/../images/uploads/profileimages/" . $img, $img);
            //mysql_query("UPDATE users SET profile_image_small='$new_name' WHERE uid='$session_id'");
            echo $new_name . "?" . time();
            exit;
        }
    }
    public function profileimageresizeandcopy($sourcedirec, $destinationdirec, $filename)
    {
        $id    = Yii::app()->session['login']['id'];
        $model = UserProfile::model()->findByAttributes(array(
            'user_id' => $id
        ));
        if (file_exists($sourcedirec)) {
            $destination = Yii::getPathOfAlias('webroot') . '/images/uploads/profileimages/thumbs/' . $filename;
            //$this->generatethumb($sourcedirec,$destination,120,120);
            FinaoController::generatethumb($sourcedirec, $destination, 120, 120);
        }
        if (copy($sourcedirec, $destinationdirec)) {
            if ($model->profile_image != "") {
                if (file_exists(Yii::app()->basePath . "/../images/uploads/profileimages/" . $model->profile_image))
                    unlink(Yii::app()->basePath . "/../images/uploads/profileimages/" . $model->profile_image);
            }
            $model->profile_image = $filename;
            if ($model->save(false)) {
                if (file_exists(Yii::app()->basePath . "/../images/uploads/temp_profileimages/" . $model->temp_profile_image))
                    unlink(Yii::app()->basePath . "/../images/uploads/temp_profileimages/" . $model->temp_profile_image);
            }
            if (isset(Yii::app()->session['login'])) {
                $login                       = Yii::app()->session['login'];
                $login["profImage"]          = $filename;
                Yii::app()->session['login'] = $login;
            }
        }
    }
    public function actionFirstvisitpage()
    {
        $userfinao    = UserFinaoTile::model()->findAllByAttributes(array(
            'userid' => Yii::app()->session['login']['id']
        ));
        $findusername = User::model()->findByPk(Yii::app()->session['login']['id']);
        if (isset(Yii::app()->session['login']['id'])) {
            if (empty($userfinao)) {
                //$this->render('profilelanding',array('findusername'=>$findusername));
                //}else{
                $this->redirect('profilelanding');
            }
        } else {
            $this->redirect(array(
                '/'
            ));
        }
    }
    public function actionFinalstep()
    {
        $this->render('finalstep');
    }
    public function actionPrivacy()
    {
        $this->render('privacy');
    }
    public function actionNewfinao()
    {
        $model  = new UserFinao;
        $tiles  = Lookups::model()->findAll(array(
            'condition' => 'lookup_type = "tiles" AND lookup_status = 1 ',
            'order' => 'lookup_name'
        ));
        $userid = Yii::app()->session['login']['id'];
        if (isset($_REQUEST['dashboard']))
            $skip = "dashboard";
        else
            $skip = "landing";
        $this->render('newfinao', array(
            'userid' => $userid,
            'model' => $model,
            'tiles' => $tiles,
            'skip' => $skip
        ));
    }
    public function actionAboutus()
    {
        $this->render('aboutus');
    }
    public function actionTerms()
    {
        $this->render('terms');
    }
    public function actionFaq()
    {
        $this->render('faq');
    }
    public function actionFinaogives()
    {
        $this->render('finaogives');
    }
    public function actionContactus()
    {
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $phone   = $_POST['phone'];
        $comment = $_POST['comment'];
        if ($name != "" && $email != "" && $phone != "" && $comment != "") {
            $to      = "askus@finaonation.com";
            //$to = "siri502.alla@gmail.com";
            $subject = "Contact";
            $message = '<html>



						<head>



						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



						<title>FINAO Nation</title>						



						</head>						



						<body>



						<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="allborder">



						<style type="text/css">



						<!--



						/*



						*based



						*/



						body,td,th {



							color: #333333;



							font-family: Tahoma, Verdana,sans-serif, Arial, Helvetica;



						}



						.allborder {



							/*border: 10px solid #EEEEEE;*/



							  border: 0px;



						}



						body {



							background-color: #FFFFFF;



							margin-left: 0px;



							margin-top: 0px;



							margin-right: 0px;



							margin-bottom: 0px;



						}



						.pressrelease{



							color:#1A61AF;



							font-size:14px;



							padding-top:5px;



							padding-bottom: 2px;



							padding-right: 5px;



							font-weight: bold;



						}



						



						.con{



							color:#3a3372;



							font-size:12px;



							padding-top: 20px;



							padding-right: 20px;



							padding-bottom: 20px;



							padding-left: 20px;



						}



						.taball {



							padding: 5px;



							border: 1px dashed #CCCCCC;



						}



						.bluetext {color: #000066 font-size: 13px}



						



						-->



						 </style>



						



						  <tr>



							<td width="100%" valign="top" bgcolor="#f3f8fc">



							



							<table width="100%" border="0" cellspacing="0" cellpadding="0">



							  



							</table>



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td bgcolor="#FFFFFF" align="center"><!-- <img src="http://finaonation.com/images/mh.png" width="100%" height ="auto"> --></td>



								</tr>



							  </table>  



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td height="10" bgcolor="#EEEEEE" ></td>



								</tr>



							  </table>



							  <table width="100%" height="1" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td></td>



								</tr>



							  </table> 



							  <table width="100%" height="407" border="0" align="center" cellpadding="0" cellspacing="0">



								<tr>



								  <td height="auto" valign="top" class="con" style="padding-left:7px;"><p><strong>Hello ,</strong></p>



									<p>We received a Contact Request to Finaonation.com from this email address "' . $email . '".</p>



									</td></tr>



									<tr>



									<td>Name : ' . $name . '</td>



									</tr>



									<tr>



									<td>Email : ' . $email . '</td>



									</tr>



									<tr>



									<td>Phone : ' . $phone . '</td>



									</tr>



									



									<tr>



									<td><p>Comment : ' . $comment . '</p></td>



									</tr>								



									<tr><td>



														



									<p style="font-size:18px;">Life is full of options. Failure is not one of them.</p>



									<p align="left">Thanks,</p>



									<p align="left">FINAONation.com</p>



									<p align="justify"></p></td>



								</tr>



								<tr>



								  <td height="26" align="center"><p>



									  <a href="#"><!-- <img src="http://finaonation.com/images/mf.png" width="100%" > --></a></p>



								  </td>



								</tr>



							  </table>



							  </td>



						  </tr>



						</table>



						</body>



						</html>';
            //$message = "Name : $name \n Email : $email\n Phone : $phone\n Quantity : $group\n Comment : $comment";
            $from    = $email;
            //$headers = "From:" . $from;
            // Always set content-type when sending HTML email
            /*
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            
            
            
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            
            
            $headers .= "From: Finao Nation <do-notreply@finaonation.com>";
            
            $headers .= 'Bcc: dev@wincito.com' . "\r\n";*/
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // Additional headers
            //$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
            $headers .= 'From: Finao Nation <do-notreply@finaonation.com>' . "\r\n";
            //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
            $headers .= 'Bcc: dev@wincito.com' . "\r\n";
            //$message = "Name : $name \n Email : $email\n Phone : $phone\n Comment : $comment";
            //$from = $email;
            //$headers = "From:" . $from;
            mail($to, $subject, $message, $headers);
            echo "success";
        }
        $this->render('contactus');
    }
    public function actionGrouppurchase()
    {
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $phone   = $_POST['phone'];
        $group   = $_POST['group'];
        $comment = $_POST['comment'];
        if ($name != "" && $email != "" && $phone != "" && $comment != "" && $group != '') {
            $to      = "askus@finaonation.com";
            $subject = "Group Purchase Request";
            $message = '<html>



						<head>



						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



						<title>FINAO Nation</title>						



						</head>						



						<body>



						<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="allborder">



						<style type="text/css">



						<!--



						/*



						*based



						*/



						body,td,th {



							color: #333333;



							font-family: Tahoma, Verdana,sans-serif, Arial, Helvetica;



						}



						.allborder {



							/*border: 10px solid #EEEEEE;*/



							  border: 0px;



						}



						body {



							background-color: #FFFFFF;



							margin-left: 0px;



							margin-top: 0px;



							margin-right: 0px;



							margin-bottom: 0px;



						}



						.pressrelease{



							color:#1A61AF;



							font-size:14px;



							padding-top:5px;



							padding-bottom: 2px;



							padding-right: 5px;



							font-weight: bold;



						}



						



						.con{



							color:#3a3372;



							font-size:12px;



							padding-top: 20px;



							padding-right: 20px;



							padding-bottom: 20px;



							padding-left: 20px;



						}



						.taball {



							padding: 5px;



							border: 1px dashed #CCCCCC;



						}



						.bluetext {color: #000066 font-size: 13px}



						



						-->



						 </style>



						



						  <tr>



							<td width="100%" valign="top" bgcolor="#f3f8fc">



							



							<table width="100%" border="0" cellspacing="0" cellpadding="0">



							  



							</table>



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td bgcolor="#FFFFFF" align="center"><!-- <img src="http://finaonation.com/images/mh.png" width="100%" height ="auto"> --></td>



								</tr>



							  </table>  



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td height="10" bgcolor="#EEEEEE" ></td>



								</tr>



							  </table>



							  <table width="100%" height="1" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td></td>



								</tr>



							  </table> 



							  <table width="100%" height="407" border="0" align="center" cellpadding="0" cellspacing="0">



								<tr>



								  <td height="auto" valign="top" class="con" style="padding-left:7px;"><p><strong>Hello ,</strong></p>



									<p>We received a Group Purchase Request to Finaonation.com from this email address "' . $email . '".</p>



									</td></tr>



									<tr>



									<td>Name : ' . $name . '</td>



									</tr>



									<tr>



									<td>Email : ' . $email . '</td>



									</tr>



									<tr>



									<td>Phone : ' . $phone . '</td>



									</tr>



									<tr>



									<td>Quantity : ' . $group . '</td>



									</tr>



									<tr>



									<td><p>Comment : ' . $comment . '</p></td>



									</tr>								



									<tr><td>



														



									<p style="font-size:18px;">Life is full of options. Failure is not one of them.</p>



									<p align="left">Thanks,</p>



									<p align="left">FINAONation.com</p>



									<p align="justify"></p></td>



								</tr>



								<tr>



								  <td height="26" align="center"><p>



									  <a href="#"><!-- <img src="http://finaonation.com/images/mf.png" width="100%" > --></a></p>



								  </td>



								</tr>



							  </table>



							  </td>



						  </tr>



						</table>



						</body>



						</html>';
            //$message = "Name : $name \n Email : $email\n Phone : $phone\n Quantity : $group\n Comment : $comment";
            $from    = $email;
            //$headers = "From:" . $from;
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= "From: Finao Nation <do-notreply@finaonation.com>";
            mail($to, $subject, $message, $headers);
            echo "success";
        }
        $this->render('grouppurchase');
    }
    public function actionLanding()
    {
        $this->redirect(array(
            '/myhome'
        ));
        $user                = User::model()->findByPk(Yii::app()->session['login']['id']);
        $imgsourceid         = Lookups::model()->findByAttributes(array(
            'lookup_type' => 'uploadtype',
            'lookup_name' => 'Image'
        ));
        $vidsourceid         = Lookups::model()->findByAttributes(array(
            'lookup_type' => 'uploadtype',
            'lookup_name' => 'Video'
        ));
        $criteria            = new CDbCriteria;
        $criteria->condition = " explore_finao = 1 and uploadtype = " . $imgsourceid->lookup_id;
        //$criteria->limit = 1;
        //$criteria->order = "RAND()";
        $uploadImages        = Uploaddetails::model()->findAll($criteria);
        $upimgdet            = FinaoController::getpagedetails($uploadImages, 1, 1, 1);
        $criteria->limit     = $upimgdet['limittxt'];
        $criteria->order     = "RAND()";
        $uploadImages        = Uploaddetails::model()->findAll($criteria);
        $criteria            = new CDbCriteria;
        $criteria->condition = " explore_finao = 1 and uploadtype = " . $vidsourceid->lookup_id;
        //$criteria->limit = 1;
        //$criteria->order = "RAND()";
        $uploadVideo         = Uploaddetails::model()->findAll($criteria);
        $upviddet            = FinaoController::getpagedetails($uploadVideo, 1, 1, 1);
        $criteria->limit     = $upviddet['limittxt'];
        $criteria->order     = "RAND()";
        $uploadVideo         = Uploaddetails::model()->findAll($criteria);
        $videoembedurl       = '<img src="' . Yii::app()->baseUrl . '/images/dashboard/slide2_image1.jpg" width="560" />';
        $vidcaption          = "";
        $userimg             = "";
        $uservid             = "";
        if (isset($uploadVideo) && $uploadVideo != "" && count($uploadVideo) >= 1) {
            foreach ($uploadVideo as $vidup) {
                if ($vidup->videoid != "" && $vidup->videostatus == 'ready') {
                    $videoembedurl = FinaoController::getviddlembedCode($vidup->videoid, 532, 305);
                } elseif ($vidup->video_embedurl != "") {
                    $videoembedurl = $vidup->video_embedurl;
                }
                $vidcaption = $vidup->caption;
                $uservid    = User::model()->findByPk($vidup->uploadedby);
            }
        }
        if (isset($uploadImages) && $uploadImages != "" && count($uploadImages) >= 1) {
            foreach ($uploadImages as $upimg) {
                $userimg = User::model()->findByPk($upimg->uploadedby);
            }
        }
        $this->render('newlanding', array(
            'user' => $user,
            'uploadImages' => $uploadImages,
            'uploadVideo' => $uploadVideo,
            'videoembedurl' => $videoembedurl,
            'upviddet' => $upviddet,
            'upimgdet' => $upimgdet,
            'vidcaption' => $vidcaption,
            'uservid' => $uservid,
            'userimg' => $userimg
        ));
    }
    public function actionBrowseVideoImage()
    {
        $uploadtype = isset($_REQUEST['imgvid']) ? $_REQUEST['imgvid'] : "";
        if ($uploadtype != "") {
            $page                = isset($_REQUEST['pageid']) ? $_REQUEST['pageid'] : 1;
            $targetdiv           = $_REQUEST['targetdiv'];
            $limit               = 1;
            $uptypeid            = Lookups::model()->findByAttributes(array(
                'lookup_type' => 'uploadtype',
                'lookup_name' => $uploadtype
            ));
            $criteria            = new CDbCriteria;
            $criteria->condition = " explore_finao = 1 and uploadtype = " . $uptypeid->lookup_id;
            $criteria->order     = "updateddate desc";
            $uploadImages        = Uploaddetails::model()->findAll($criteria);
            $upPageNav           = FinaoController::getpagedetails($uploadImages, 1, $page, 1);
            //$criteria->limit = $upPageNav["limittxt"];
            //$lim = FinaoController::getpagecount(count($uploadImages),$limit,$page);
            //print_r($upPageNav);exit;
            $criteria->limit     = $upPageNav['limittxt'];
            $criteria->offset    = $upPageNav['offset'];
            $uploadImages        = Uploaddetails::model()->findAll($criteria);
            $videoembedurl       = "";
            $caption             = "";
            $userimg             = "";
            if (isset($uploadImages) && $uploadImages != "" && count($uploadImages) >= 1) {
                foreach ($uploadImages as $vidup) {
                    if ($uploadtype == 'Video') {
                        if ($vidup->videoid != "" && $vidup->videostatus == 'ready') {
                            $videoembedurl = FinaoController::getviddlembedCode($vidup->videoid);
                        } elseif ($vidup->video_embedurl != "") {
                            $videoembedurl = $vidup->video_embedurl;
                        }
                    } elseif ($uploadtype == 'Image') {
                        $filename = $vidup->uploadfile_path . "/" . $vidup->uploadfile_name;
                        if (file_exists(Yii::app()->basePath . "/../" . $filename)) {
                            $videoembedurl = Yii::app()->baseUrl . $filename;
                        }
                    }
                    $caption = $vidup->caption;
                    $userimg = User::model()->findByPk($vidup->uploadedby);
                }
            }
            $this->renderPartial('_browserImagVideo', array(
                'videoembedurl' => $videoembedurl,
                'uploadtype' => $uploadtype,
                'upPageNav' => $upPageNav,
                'caption' => $caption,
                'targetdiv' => $targetdiv,
                'userinfo' => $userimg
            ));
        }
    }
    public static function generatethumb($src, $dest, $width, $height)
    {
        //orginal source path
        $source       = $src;
        // Set the thumbnail name
        $thumbnail    = $dest;
        $thumb_width  = $width;
        $thumb_height = $height;
        // Get new sizes
        list($width1, $height1) = getimagesize($source);
        //$newwidth = 90; // This can be a set value or a percentage of original size ($width)
        //$newheight = 90; // This can be a set value or a percentage of original size ($height)
        $width           = $width1;
        $height          = $height1;
        $original_aspect = $width / $height;
        $thumb_aspect    = $thumb_width / $thumb_height;
        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $newheight = $thumb_height;
            $newwidth  = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $newwidth  = $thumb_width;
            $newheight = $height / ($width / $thumb_width);
        }
        // Load the images
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $ext   = substr(strrchr($source, '.'), 1);
        $ext   = strtolower($ext);
        //echo $ext;exit;
        if ($ext == "png") {
            $source1 = imagecreatefrompng($source);
        } elseif ($ext == "jpg" || $ext == "jpeg") {
            $source1 = imagecreatefromjpeg($source);
        } elseif ($ext == "gif") {
            $source1 = imagecreatefromgif($source);
        }
        // Resize the $thumb image.
        imagecopyresampled($thumb, $source1, 0, 0, 0, 0, $newwidth, $newheight, $width1, $height1);
        if ($ext == "png") {
            imagepng($thumb, $thumbnail, 100);
        } elseif ($ext == "jpg" || $ext == "jpeg") {
            imagejpeg($thumb, $thumbnail, 100);
        } elseif ($ext == "gif") {
            imagegif($thumb, $thumbnail, 100);
        }
    }
    // tagnote display
    //http://192.237.169.183/profile/tagnote?finao=1
    public function actionTagnote()
    {
        $finaoId         = isset($_REQUEST['finao']) && is_numeric($_REQUEST['finao']) ? $_REQUEST['finao'] : null;
        $requestData     = array(
            'tagnoteId' => $finaoId
        );
        $client          = new SoapClient('http://' . $_SERVER['SERVER_NAME'] . '/shop/api/soap/?wsdl');
        $sessionId       = $client->login('apiintegrator', 'ap11ntegrator');
        $tagnoteResponse = $client->call($sessionId, 'finao.info', array(
            $requestData
        ));
        $user            = User::model()->findAllByAttributes(array(
            'mageid' => $tagnoteResponse['customerId']
        ));
        $userimage       = UserProfile::model()->findAllByAttributes(array(
            'user_id' => $user[0]['userid']
        ));
        $this->renderPartial('_tagnote', array(
            'tagnote' => isset($tagnoteResponse['finao']) ? $tagnoteResponse['finao'] : '',
            'user' => $user,
            'userimage' => $userimage
        ));
    }
    /*============= HBCU VIDEO SHARE ==========*/
    public function actionShareVote()
    {
        $finao_id = $_REQUEST['finaoid'];
        $user_id  = $_REQUEST['userid'];
        $frend_id = $_REQUEST['frendid'];
        $media_id = $_REQUEST['mediaid'];
        $share_id = $_REQUEST['shareid'];
        //echo $mediaimage_id;die();
        if ($_REQUEST['frendid']) {
            $getfrenddtls = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id', array(
                ':id' => $frend_id
            ))->queryRow();
        }
        if (isset($_REQUEST['mediaid'])) {
            $displayvideo      = Yii::app()->db->createCommand()->select('*')->from('fn_uploaddetails')->where('uploaddetail_id=:id', array(
                ':id' => $media_id
            ))->queryRow();
            $finaovideoid      = $displayvideo['upload_sourceid'];
            $finaovideoprofile = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finaovideoid
            ))->queryRow();
            $displayvideo1     = Yii::app()->db->createCommand()->select('*')->from('fn_users')->where('userid=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $displayvideo2     = Yii::app()->db->createCommand()->select('*')->from('fn_user_profile')->where('user_id=:id', array(
                ':id' => $user_id
            ))->queryRow();
            $displayvideo3     = Yii::app()->db->createCommand()->select('*')->from('fn_user_finao')->where('user_finao_id=:id1', array(
                ':id1' => $finao_id
            ))->queryRow();
            if (Yii::app()->session['login']['id']) {
                $sql1       = "select * from fn_video_vote where voter_userid=" . Yii::app()->session['login']['id'] . " and voted_userid=" . $displayvideo['uploadedby'];
                $connection = Yii::app()->db;
                $command    = $connection->createCommand($sql1);
                $votevideo  = $command->queryAll();
            }
            //$this->layout = '/layouts/column4';
            $this->pageTitle = 'hbcu';
            $this->render('_sharevote', array(
                'displayvideo' => $displayvideo,
                'displayvideo1' => $displayvideo1,
                'displayvideo2' => $displayvideo2,
                'displayvideo3' => $displayvideo3,
                'finaovideoprofile' => $finaovideoprofile,
                'getfrenddtls' => $getfrenddtls,
                'shareid' => $share_id,
                'votevideo' => $votevideo,
                'view' => 'displayvideo',
                'sourceid' => $_REQUEST['mediaid'],
                'voted_userid' => $_REQUEST['frndid']
            ));
            //print_r($displayvideo);
        }
        //$this->layout    = '/layouts/column4';
        //$this->render('_sharevote');
    }
    /*============= HBCU VIDEO SHARE ==========*/
}
?>