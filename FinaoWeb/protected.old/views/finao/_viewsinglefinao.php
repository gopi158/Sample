<style>.hidden { display:  none; }</style>



<script>



 jQuery(document).ready(function (cash) {



 "use strict";



 $('#Default').perfectScrollbar();



 });







 function views(a)



 {



 	$('#edit'+a).show();



 }



 function closes(a)



 {



 	//setTimeout(function (){$('#edit'+a).hide();},5000)



 }



 function view_set(a)



 {



 //	$('#journal-settings'+a).show();

	if($('#journal-settings'+a).css('display')=='none') $('#journal-settings'+a).show();

	else $('#journal-settings'+a).hide();



 }

 function view_sets(a)



 {

 	$('#set'+a).show();



 }

  function close_sets(a)



 {

 	$('#set'+a).hide();



 }

 



 function close_set(a)



 {



 	//$('#set'+a).hide();

	$('#journal-settings'+a).hide();



 }



 function view_image(a,b)



 {



 	$('#image_'+a).show();$('#journal-settings'+a).hide();
	
	if(b==1) {$('#btn_'+a).show();$('#img'+a).hide();	$('#tests'+a).show(); }
	else { $('#icon-delete'+a).hide();$('#capt'+a).val();}



 }



 //hide add image inserting



 function close_type(a)



 {



 	$('#image_'+a).hide();	$('#video_'+a).hide();
	$('#captv'+a).val($('#dummy'+a).val());
	$('#capt'+a).val($('#dummyimg'+a).val());
	



 }



 



 // delete types image or videos



 function delete_type(type,uploadedid,value,source,tileid,finaoid,userid)



 {



 	if(confirm('Are you sure you want to delete this '+type+'?'))



	{



		var url='<?php echo Yii::app()->createUrl("/finao/deletebytype"); ?>';



		$.post(url, { type:type ,uploadedid:uploadedid ,source:source },



		function(data)



		{



			if(type=='image')



			{



				$('#fancyboximg'+value).hide();$('#img'+value).hide();



			}



			else



			{



				$('#fancybox-media'+uploadedid).hide();$('#vid'+value).hide();



			}



		 });



		// getthatfinao(finaoid);



		 getfinaos(userid,tileid); //view_single_finao(userid,finaoid);



	}	



 } 



 



 // save journal message



 function savejournal_msg(uploadedid)



 {



 var text=$('#newjournalmesg-'+uploadedid).val();



  if(text!='')



  {



 	var url='<?php echo Yii::app()->createUrl("/finao/textdetails"); ?>';



 	$.post(url, { text:text ,uploadedid:uploadedid },function(data){$('#editjournal-'+uploadedid).hide();$('#journalmesg-'+uploadedid).html(text);$('#journalmesg-'+uploadedid).show(); view_single_finao(<?php echo $userid;?>,'111'); });



  }



  else { $('#newjournalmesg-'+uploadedid).css('border','red  solid 1px');}	



 } 



 



  function view_video(finaoid,uploadedid)
  {

	var groupid = document.getElementById('groupid').value;
	$('#journal-settings'+uploadedid).hide();

	var url='<?php echo Yii::app()->createUrl("/finao/getvideodetails"); ?>';



 	$.post(url, { uploadedid:uploadedid ,finaoid:finaoid,groupid:groupid },



   		function(data){



   			 //alert(data);



			if(data)



			{



				 $('#imgvid'+uploadedid).show();



				 $('#imgvid'+uploadedid).html(data);

			}

    });

 }
 

 function edit_video(finaoid,uploadedid)
 { 	
	$('#video_'+uploadedid).show();
	$('#journal-settings'+uploadedid).hide();
 }
function edits_caption(types,uploadedid)
{
	var caption=$('#captv'+uploadedid).val();
	var userid=$('#userid').val();
	var url='<?php echo Yii::app()->createUrl("/finao/updatedetails"); ?>';
	$.post(url, { uploaddetail_id:uploadedid ,caption:caption,userid:userid,type:types });
	view_single_finao(<?php echo Yii::app()->session['login']['id'] ?>,'1');		
}



function edit_text(id)



 {



 	$('#editjournal-'+id).show();$('#journalmesg-'+id).hide();

	$('#journal-settings'+a).hide();



 }







 function path_video(a,b)



 {



 	if(b==1) {$('#path_'+a).show();$('#url_'+a).hide();}



	else{$('#url_'+a).show();$('#path_'+a).hide();}



 }



 



 



 function readURLs(input,a) {

	
var fileExtension = ['jpeg', 'jpg','png','gif'];
	
	if ($.inArray($("#img"+a).val().split('.').pop().toLowerCase(), fileExtension) == -1)

	{

	   alert("Only '.jpeg','.jpg', '.png','.gif' formats are allowed.");
		$("#img"+a).val('');
	   return false;

	}
	
		if (input.files && input.files[0]) {



	var reader = new FileReader();



	reader.onload = function (e) {



	$('#tests'+a).attr('src', e.target.result);
	$('#tests'+a).show();



	}



		reader.readAsDataURL(input.files[0]);$('#btn_'+a).show();



	}



}











function savevideoembUrlactivity(uploadid,finaoid)



{



	 



	var txtVidembedUrl = $('#txtVidembedUrl').val();



	var vdurldescription = $('#vdurldescription').val();



	var url='<?php echo Yii::app()->createUrl("/finao/GetUpdatedvideo"); ?>';



	$.post(url, {uploadid:uploadid,txtVidembedUrl:txtVidembedUrl,vdurldescription:vdurldescription,finaoid:finaoid},



		function(data){



	  		//alert(data);



			if(data)



			{ 



				refreshmenucount(<?php echo Yii::app()->session['login']['id'] ?>);



				document.getElementById("youtubevideoform").reset();



				getheroupdate();



				//getfinaos(userid,tileid);



				view_single_finao(<?php echo Yii::app()->session['login']['id'] ?>,data);



			}



		});	



}



 



</script>



<?php    $userfinding1 = User::model()->findByPk($userid); ?>  	



<div class="font-16px padding-10pixels" id="Activity"><?php if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share") echo 'My FINAO Activity'; else echo ucfirst($userfinding1->fname)."'s       FINAO Activity";?></div>



<?php $i=0;



  $Criteria = new CDbCriteria();



	$Criteria->condition = "uploadedby = '".$userid."' and upload_sourceid='".$finaoid."'";



	$Criteria->order = "updateddate desc";



	$totfinaos = Uploaddetails::model()->findAll($Criteria);




	if(count($totfinaos)=='0'){ echo "<div class='orange font-13px'> No Activity Found In This Finao</div>";}



	else {



?>



<div class="contentHolder ps-container" id="Default">



	<div class="finao-display-container">



			



<?php



	foreach($totfinaos as $finaoalll)



	{$i++;



	 /*if($totfinaos[0]['status']=='0' && $totfinaos[0]['videostatus']=='Encoding in Process')



		{



			 $Criteria = new CDbCriteria();



			$Criteria->condition = "uploadedby = '".$userid."' and status=1 and videostatus='ready' and upload_sourceid='".$finaoid."'";



			$Criteria->order = "updateddate desc";



			$totfinaos = Uploaddetails::model()->findAll($Criteria);



		}*/



		//if($finaoalll->status=='0' and $finaoalll->videostatus=='Encoding in Process') continue;



			?>



	<script language="javascript"> 



	$(document).ready(function() {



			$("#fancyboximg"+<?php echo $i;?>).fancybox({beforeLoad: function() {



            var el, id = $(this.element).data('title-id');



            if (id) {



                el = $('#' + id);            



                if (el.length) {



                    this.title = el.html();



                }



            }}});



			$("#fancyboximgs"+<?php echo $finaoalll->uploaddetail_id;?>).fancybox({});



			$('#fancybox-media'+<?php echo $finaoalll->uploaddetail_id;?>).fancybox({width: 620,height: 420,type: "iframe",iframe : {preload: false}});



	});		



	</script>	



			



		<div id="single_journal<?php echo $finaoalll->uploaddetail_id;?>" onmouseover="view_sets(<?php echo $finaoalll->uploaddetail_id;?>);" onmouseout="close_sets(<?php echo $finaoalll->uploaddetail_id;?>)" class="finao-desc-media" style="position:relative" >



		<div class="finao-content-caption">



		<?php $vv=explode(' ',$finaoalll->updateddate);



			$v=explode('-',$vv[0]); $v1=explode(':',$vv[1]);



			$mon = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");?>



			<?php echo $v['2']."th " . $mon[$v[1]]." ,  " . $v['0']."  -  ". $v1[0].":".$v1[1].'pm';
			
			if($ismember ==1){
				$users = User::model()->findByPk($finaoalll->updatedby); ?>
				<br /><span style="color:#009966">Updated By <a href="<?php Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$users['userid'])) ?>" class="orange"><?php echo $users['fname'].'&nbsp;'.$users['lname'];?></a></span>
			<?php }?>	

			</div>



		



		<?php



		$finaos = UserFinao::model()->findByPK($finaoid);



		$tiles = UserFinaoTile::model()->findAll(array('condition'=>'finao_id ='.$finaoalll->upload_sourceid));



		//print_r($tiles);exit;



		//echo $finaos->Iscompleted;


		 if($userid==Yii::app()->session['login']['id'] && $finaos->Iscompleted!=1 && isset($share) && $share!="share"){//exit;?>
         
         
			<span style="display:none" id="set<?php echo $finaoalll->uploaddetail_id;?>" class="edit-journal-options">

                  
                   
					<div class="journal-setting-options">



						<a title="Edit Tile" href="javascript:void(0)" onclick="view_set(<?php echo $finaoalll->uploaddetail_id;?>);" ><img width="20" src="<?php echo $this->cdnurl;?>/images/icon-settings-grey.png"></a>                         



                <div class="journal-settings" id="journal-settings<?php echo $finaoalll->uploaddetail_id;?>" style="display:none">

                <?php if($finaoalll->uploadtype==34){?>
				 <a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Add Entry</a>
                    <?php if($finaoalll["uploadfile_name"] != ""){ ?>				  

					<a class="black-link font-12px" id="eimg<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'1');">Edit Image</a>
					<?php /*?><a class="black-link font-12px" id="img<?php echo $i;?>" href="javascript:void(0)" onclick="delete_type('image',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');">Delete Image</a><?php */?>
					<?php }else{?> 
					<a class="black-link font-12px" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>);">Add Image</a>
					<?php } ?>


				<?php }else if($finaoalll->uploadtype==35){?> 
				<a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Add Entry</a>
                   <?php if($finaoalll["videoid"] !='' or $finaoalll["video_embedurl"] !=''  ){?>
				 <a class="black-link font-12px" id="evid<?php echo $i;?>" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Edit Video</a>
                  <?php /*?> <a class="black-link font-12px" id="vid<?php echo $i;?>" href="javascript:void(0)" onclick="delete_type('video',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');">Delete Video</a><?php */?>
				   <?php }else{?>
				  <a class="black-link font-12px" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Add Video</a>
				   <?php } ?> 
				   
				   
				<?php }else{?> 
                   <a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Edit Entry</a>
                  <?php if($finaoalll["uploadfile_name"] != ""){ ?> 
				  <?php /*?> 	<a class="black-link font-12px" id="eimg<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>);">Edit Image</a><?php */?>
					 <a class="black-link font-12px" id="img<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'1');">Edit Image</a>
					<?php }else{?> 
					<a class="black-link font-12px" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'0');">Add Image</a>
					<?php } ?>
					<?php if($finaoalll["videoid"] !='' or $finaoalll["video_embedurl"] !=''  ){?>
                    <a class="black-link font-12px" id="vid<?php echo $i;?>" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Edit Video</a>
                    <?php }else{?> 
                    <a class="black-link font-12px" href="javascript:void(0)" onclick="view_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Add Video</a>
                    <?php } ?>
					<a class="black-link font-12px" onclick="hideshow('showjoumsg','hide');delete_posts(<?php echo $finaoalll->uploaddetail_id;?>,<?php echo $finaoid;?>,<?php echo $tiles[0]['tile_id'];?>,<?php echo $userid;?>)" href="javascript:void(0)">Delete Entry</a>  
				<?php } ?>

                </div>
					</div>
			</span>					

 		<?php }else if($finaoalll->updatedby ==Yii::app()->session['login']['id'] && $share!="share"){?> 
		    <span style="display:none" id="set<?php echo $finaoalll->uploaddetail_id;?>" class="edit-journal-options">

                  
                   
					<div class="journal-setting-options">



						<a title="Edit Tile" href="javascript:void(0)" onclick="view_set(<?php echo $finaoalll->uploaddetail_id;?>);" ><img width="20" src="<?php echo $this->cdnurl;?>/images/icon-settings-grey.png"></a>                         



                <div class="journal-settings" id="journal-settings<?php echo $finaoalll->uploaddetail_id;?>" style="display:none">

                <?php if($finaoalll->uploadtype==34){?>
				 <a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Add Entry</a>
                    <?php if($finaoalll["uploadfile_name"] != ""){ ?>				  

					<a class="black-link font-12px" id="eimg<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'1');">Edit Image</a>
					<?php /*?><a class="black-link font-12px" id="img<?php echo $i;?>" href="javascript:void(0)" onclick="delete_type('image',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');">Delete Image</a><?php */?>
					<?php }else{?> 
					<a class="black-link font-12px" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>);">Add Image</a>
					<?php } ?>


				<?php }else if($finaoalll->uploadtype==35){?> 
				<a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Add Entry</a>
                   <?php if($finaoalll["videoid"] !='' or $finaoalll["video_embedurl"] !=''  ){?>
				 <a class="black-link font-12px" id="evid<?php echo $i;?>" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Edit Video</a>
                  <?php /*?> <a class="black-link font-12px" id="vid<?php echo $i;?>" href="javascript:void(0)" onclick="delete_type('video',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');">Delete Video</a><?php */?>
				   <?php }else{?>
				  <a class="black-link font-12px" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Add Video</a>
				   <?php } ?> 
				   
				   
				<?php }else{?> 
                   <a  class="black-link font-12px" onclick="edit_text(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)">Edit Entry</a>
                  <?php if($finaoalll["uploadfile_name"] != ""){ ?> 
				  <?php /*?> 	<a class="black-link font-12px" id="eimg<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>);">Edit Image</a><?php */?>
					 <a class="black-link font-12px" id="img<?php echo $i;?>" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'1');">Edit Image</a>
					<?php }else{?> 
					<a class="black-link font-12px" href="javascript:void(0)" onclick="view_image(<?php echo $finaoalll->uploaddetail_id;?>,'0');">Add Image</a>
					<?php } ?>
					<?php if($finaoalll["videoid"] !='' or $finaoalll["video_embedurl"] !=''  ){?>
                    <a class="black-link font-12px" id="vid<?php echo $i;?>" href="javascript:void(0)" onclick="edit_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Edit Video</a>
                    <?php }else{?> 
                    <a class="black-link font-12px" href="javascript:void(0)" onclick="view_video(<?php echo  $finaoalll->upload_sourceid ?>,<?php echo $finaoalll->uploaddetail_id;?>);">Add Video</a>
                    <?php } ?>
					<a class="black-link font-12px" onclick="hideshow('showjoumsg','hide');delete_posts(<?php echo $finaoalll->uploaddetail_id;?>,<?php echo $finaoid;?>,<?php echo $tiles[0]['tile_id'];?>,<?php echo $userid;?>)" href="javascript:void(0)">Delete Entry</a>  
				<?php } ?>

                </div>
					</div>
			</span>
		<?php }?>


			<div class="finao-hero-content">

			<?php

			if($finaoalll->uploadtype =='34' or $finaoalll->uploadtype =='62')
			{
			 if($finaoalll["uploadfile_name"] != ""){ 

            if(file_exists(Yii::app()->basePath."/../".$finaoalll["uploadfile_path"]."/thumbs/".$finaoalll["uploadfile_name"])){$path = "/thumbs/";}else{$path = "/";} ?>           

             <a id="fancyboximg<?php echo $i;?>" rel="gallery1" data-title-id="title-<?php echo $finaoalll['uploaddetail_id'];?>" href="<?php echo $this->cdnurl.$finaoalll['uploadfile_path'].'/'.$finaoalll['uploadfile_name'];?>" title="<?php echo $finaoalll["caption"]  ?>">
			<img style="margin-right:8px;" class="finao-img-border left" src="<?php echo $this->cdnurl.$finaoalll['uploadfile_path'].$path.$finaoalll['uploadfile_name'];?>" > </a>
			<div id="title-<?php echo $finaoalll['uploaddetail_id'];?>" class="hidden">
			<b style=" margin-left:10px;"><?php echo $finaoalll["caption"]; ?></b> 



<?php 	 if($userid!=Yii::app()->session['login']['id']) {



		             $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);					 



					 



					  if(file_exists(Yii::app()->basePath."/../".$finaoalll["uploadfile_path"]."/medium/".$finaoalll["uploadfile_name"]))



						{



							$imgsrcenc =  $this->cdnurl.$finaoalll["uploadfile_path"]."/medium/".$finaoalll["uploadfile_name"];



						}



						else



						{									



							 $imgsrcenc =  $this->cdnurl.$finaoalll["uploadfile_path"]."/".$finaoalll["uploadfile_name"];



						}



					 



	               // $imgsrcenc =  $this->cdnurl.$finaoalll["uploadfile_path"]."/medium/".$finaoalll["uploadfile_name"];



	                 $imgsrcenc =  urlencode($imgsrcenc);



					 $urlpath=$this->cdnurl."/profile/share/mediaimageid/".$finaoalll['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']; 



 $urlpath1 = urlencode($urlpath);



	 



	                $summary = Yii::app()->session['login']['username'].'+shared+an+Image+in+finaonation.com'; 



	 ?>



			<span class="sharing-container right" style=" margin-right:10px; margin-top:2px;">



	<span id="infomail"></span>  



   <img src="<?php echo $this->cdnurl;?>/images/icon-flag.png" width="18" height="18" alt="FLAG" onclick="mailFunction('<?php echo $finaoalll['uploaddetail_id'];?>','<?php echo $userid;?>','<?php echo Yii::app()->session['login']['id'];?>');" style="cursor:pointer;" />



   <b>Flag inappropriate |</b><span style=" clear:both;"></span>



   <span class="bolder" style="margin-right:3px;">SHARE</span>	



		<a href="<?php echo $this->cdnurl;?>/profile/share/mediaimageid/<?php echo $finaoalll['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>/frendid/<?php echo $userid; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog','width=626,height=436');return false;">



		<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16" />



		</a>		



		<!-- facebook sharing ends -->



		



		<!-- Twitter sharing starts -->				



		<a href="https://twitter.com/share?url=http%3A%2F%2Ffinaonationb.com%2Fprofile%2Fshare%2Fmediaimageid%2F<?php echo $finaoalll['uploaddetail_id'];?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id']; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/myhome/finao/<?php echo $finaoalll['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>



		<!-- Twitter sharing ends -->



	</span>



	</span><?php }else{?>



	<span class="sharing-container right" style=" margin-right:10px; margin-top:2px;">



<span class="left bolder" style="margin-right:3px;">SHARE</span>



	 <?php $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);



  if(file_exists(Yii::app()->basePath."/../".$finaoalll["uploadfile_path"]."/medium/".$finaoalll["uploadfile_name"]))



			{



				$imgsrcenc =  $this->cdnurl.$finaoalll["uploadfile_path"]."/medium/".$finaoalll["uploadfile_name"];



				}



				else



				{



				



	 $imgsrcenc =  $this->cdnurl.$finaoalll["uploadfile_path"]."/".$finaoalll["uploadfile_name"];



				}



	 $imgsrcenc =  urlencode($imgsrcenc);



	 $urlpath=$this->cdnurl."/profile/share/mediaimageid/".$finaoalll['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']; 



 $urlpath1 = urlencode($urlpath);



	 



	 $summary = Yii::app()->session['login']['username'].'+shared+an+Image+in+finaonation.com';?>



		<a href="<?php echo $this->cdnurl;?>/profile/share/mediaimageid/<?php echo $finaoalll['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog','width=626,height=436');return false;">



		<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16"/>



		  </a>		



		  <!--  facebook sharing ends -->



		



		<!-- Twitter sharing starts -->				



		<a href="https://twitter.com/share?url=http%3A%2F%2Ffinaonationb.com%2Fprofile%2Fshare%2Fmediaimageid%2F<?php echo $finaoalll['uploaddetail_id'];?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id']; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/myhome/finao/<?php echo $finaoalll['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>



		<!-- Twitter sharing ends --><?php }?>



		<span style="display:none; cursor:pointer; color:#343434; text-align:right; width:100%;" class="right padding-10pixels font-14px sam<?php echo $finaoalll['uploaddetail_id'];?>" <?php if($finaoalll["upload_sourcetype"]=='37') { ?> onclick="getfinaos(<?php echo $tileid->userid;?>,<?php echo $tileid->tile_id;?>);" <?php } else if($finaoalll["upload_sourcetype"]=='36'){}else {?> onclick="viewjournal(0,<?php echo $finao_id; ?>,<?php echo $tileid->userid;?>,'completed',<?php echo $page;?>);" <?php }?> > <?php echo $finaomsg; ?> </span>



	</div>



			<?php } 



			} 



			if($finaoalll->uploadtype =='35' or $finaoalll->uploadtype =='62'){



			 if($finaoalll->videoid=='' and $finaoalll->video_embedurl!=''  )



				 {



				 $s=explode('src=',$finaoalll->video_embedurl);$ss=explode('"',$s[1]);?>



            

            	<div class="container-border">



					<div style=" background: url('<?php echo $finaoalll->video_img;?>') no-repeat scroll center center transparent;cursor: pointer;float: left;position: relative; background-size:120px 90px;" >



						  <a class="video-a-link" title="<?php echo $finaoalll->video_caption;?>" id="fancybox-media<?php echo $finaoalll->uploaddetail_id;?>"  href="<?php echo $ss[1];?>" ><span class="video-link-span2">&nbsp;</span></a>	



					</div>



				</div>



				<?php } else if($finaoalll->video_img!='' ){?>				



				

                

		<?php if($finaoalll->videostatus != 'ready')

        { 

        $vidimg = Yii::app()->baseUrl."/images/video-encoding.jpg";

        $vidsrc = 'javscript:void(0)';

        }else

        {

        $vidimg = $finaoalll->video_img;

        $vidsrc = "//www.viddler.com/embed/".$finaoalll->videoid."/?f=1&amp;player=simple&amp;secret=".$finaoalll->videoid."";

        } 

        ?>



                <div class="container-border">



					<div style=" background: url('<?php echo $vidimg;?>') no-repeat scroll center center transparent;cursor: pointer;float: left;position: relative; background-size:120px 90px;" >



					



						  <a class="video-a-link" id="fancybox-media<?php echo $finaoalll->uploaddetail_id;?>"  href="<?php echo $vidsrc; ?>" >

        <?php if($finaoalll->videostatus === 'ready'){  ?>

                          <span class="video-link-span2">&nbsp;</span>

             <?php } ?>             

                          </a>



					</div>



				</div>



		<?php } }?>	



			<div id="journalmesg-<?php echo $finaoalll->uploaddetail_id;?>">

			<?php echo $finaoalll->upload_text;?></div>


	<!-- image coding  --> 
		<form runat="server" id="image_<?php echo $finaoalll->uploaddetail_id;?>" style="display:none" method="post" action="<?php echo Yii::app()->createUrl('Finao/updatedetails'); ?>" enctype="multipart/form-data">
		<table cellspacing="1" cellpadding="5" bgcolor="#b3b3b3" style=" float: left;margin-bottom: 10px; width:100%; margin-top:10px;">
		<tbody><tr>	
        <input type="hidden" value="<?php echo $userid;?>" name="userid" id="userid" />
        <input type="hidden" value="<?php echo $groupid ?>" name="groupid"  />
            <th width="20%" class="table-header">Image</th>
			<th width="50%" class="table-header">Caption</th>
			<th width="30%" class="table-header">Action</th>

        </tr>
			<tr>

			<td width="20%" class="image-upload">
			<input id="img<?php echo $finaoalll->uploaddetail_id;?>" onchange="readURLs(this,<?php echo $finaoalll->uploaddetail_id;?>);" name="journalimage" type="file" style="width:120px" />
			<input type="hidden" value="<?php echo $finaoalll->uploaddetail_id;?>" name="uploaddetail_id" />
			<span style="float:left; margin-top:5px">
			<img id="tests<?php echo $finaoalll->uploaddetail_id;?>" style="display:none" width="50" height="50" src="<?php echo $this->cdnurl.$finaoalll['uploadfile_path'].$path.$finaoalll['uploadfile_name'];?>" /></span>
			</td>
			<td width="50%" class="image-upload">
				<span style="display: block;" id="divhideeditcaption-1055">
				<input type="hidden" value="<?php echo $finaoalll->caption;?>" id="dummyimg<?php echo $finaoalll->uploaddetail_id;?>" />
				<input type="text" style="width:90%; float:left;" class="txtbox" value="<?php echo $finaoalll->caption;?>" name="caption" id="capt<?php echo $finaoalll->uploaddetail_id;?>" placeholder="Add Caption" maxlength="60" />
				</span>
			</td> 
			<td width="30%" class="image-upload">
				<div id="">
				<ul class="media-action-btns">
				<input type="submit"  class="save-update" name="inser_image" value="" style="display:none; float:left; margin-right:3px" id="btn_<?php echo $finaoalll->uploaddetail_id;?>" title="Update" />
				<a style="float:left; width:35px;" title="Close" onclick="close_type(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)" id="closefinao-1055"><li class="icon-close"></li></a>
				<a style="float:left; width:35px;" title="Delete" onclick="delete_type('image',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');"><li class="icon-delete" id="icon-delete<?php echo $finaoalll->uploaddetail_id;?>"></li></a>
				
			<!--/*<li class="icon-save"></li>*/-->
			
			

		</span></ul>
				</div>
			</td>
			</tr>	
	</tbody></table>
		</form>
	<!-- image coding end --->
	
	
	<!-- Video caption editing  --> 		
		<table id="video_<?php echo $finaoalll->uploaddetail_id;?>" cellspacing="1" cellpadding="5" bgcolor="#b3b3b3" width="100%" style=" float: left;margin-bottom: 10px;margin-top: 10px; display:none">
		<tbody><tr><input type="hidden" value="<?php echo $userid;?>" name="userid" />
            <th width="20%" class="table-header">Video</th>
			<th width="50%" class="table-header">Caption</th>
			<th width="30%" class="table-header">Action</th>

        </tr>
			<tr> 

			<td width="20%" class="image-upload">			
			<input type="hidden" value="<?php echo $finaoalll->uploaddetail_id;?>" name="uploaddetail_id" /><img id="tests<?php echo $finaoalll->uploaddetail_id;?>" width="50" height="50" src="<?php echo $finaoalll['video_img'];?>" />
			</td>
			<td width="50%" class="image-upload">
				<span style="display: block;" id="divhideeditcaption-1055">
				<input type="hidden" value="<?php echo $finaoalll->video_caption;?>" id="dummy<?php echo $finaoalll->uploaddetail_id;?>" />
				<input type="text" style="width:95%; float:left;" class="txtbox" value="<?php echo $finaoalll->video_caption;?>" name="caption" id="captv<?php echo $finaoalll->uploaddetail_id;?>" placeholder="Add Caption" maxlength="60" />
				</span>
			</td>
			<td width="30%" class="image-upload">
				<div id="">
				<ul class="media-action-btns">
				<input type="submit"  class="save-update" name="edit_video_caption" onclick="edits_caption('video',<?php echo $finaoalll->uploaddetail_id;?>);" value="" style="float:left; margin-right:3px" id="btnv_<?php echo $finaoalll->uploaddetail_id;?>" title="Update" />
				<a style="float:left; width:35px;" title="Close" onclick="close_type(<?php echo $finaoalll->uploaddetail_id;?>);" href="javascript:void(0)" id="closefinao-1055"><li class="icon-close"></li></a>
				<a style="float:left; width:35px;" title="Delete" onclick="delete_type('video',<?php echo $finaoalll->uploaddetail_id;?>,'<?php echo $i;?>','<?php echo $finaoalll->uploadtype;?>','<?php echo $tiles[0]['tile_id'];?>','<?php echo $finaoid;?>','<?php echo $userid;?>');"><li class="icon-delete" id="icon-delete<?php echo $finaoalll->uploaddetail_id;?>"></li></a>
				
	<!--/*<li class="icon-save"></li>*/-->
			
			

		</span></ul>
				</div>
			</td>
			</tr>	
	</tbody></table>
	<!-- video caption end --->
		



		<!-- video  coding  -->
			 <div id="imgvid<?php echo $finaoalll->uploaddetail_id;?>" style="display:none;"></div>
		<!-- video coding end -->	



			</div>	



			



		<!-- edit journal start    -->			



			<div id="editjournal-<?php echo $finaoalll->uploaddetail_id;?>" style="display:none;">



				<p>



					<textarea class="finaos-area" id="newjournalmesg-<?php echo $finaoalll->uploaddetail_id;?>" style="width: 93%; float: left; margin-left:10px; margin-bottom:10px;" onblur="change_va(event,this.id);" onkeyup="change_va(event,this.id);" onkeydown="closefunction(this,event,'journal',<?php echo $userid;?>,<?php echo $finaoalll->uploaddetail_id;?>)"><?php echo ucfirst($finaoalll->upload_text);?></textarea>



				</p>



				<p style=" margin-left:10px; margin-bottom:10px;">



				



				<input type="button" class="orange-button" value="Save" id="savejournal-<?php echo $finaoalll->uploaddetail_id;?>"  onclick=" if(validateSubmitJournal('savejournal-<?php echo $finaoalll->uploaddetail_id;?>') == 'false') return false; savejournal_msg(<?php echo $finaoalll->uploaddetail_id;?>)" />



		



				<input type="button" class="orange-button" value="Cancel" id="closejournal-<?php echo $finaoalll->uploaddetail_id;?>"  onclick="closejournal(<?php echo $userid;?>,<?php echo $finaoalll->uploaddetail_id;?>)" />			



				</p>



				</div>               



		<!-- edit journal end  --->				  



		</div>



		



  <?php }?>	







	</div>



	



</div>



 <?php }?>                       



                   