<?php //echo $groupid; ?>
<input type="hidden" name="groupid" id="groupid" value="<?php echo $groupid; ?>"  />
 
<script type="text/javascript"> 
$(document).ready(function($){
$(".fancybox-share").fancybox({

});
});

function change_va(event,id)
{
	var url = '<?php echo Yii::app()->createUrl("finao/badWords"); ?>';
	if(event.keyCode == 32 || event.keyCode==9 || event.keyCode== 13) 
	{
		var valu=$('#'+id).val();
		var mySplitResult = valu.split(" ");
		var lastWord =  mySplitResult[mySplitResult.length-2];
		$.post(url, { word : lastWord}, function (data){if(data=='yes'){
			if(valu.length-lastWord.length<=1){$('#'+id).val('');}
			else {$('#'+id).val($('#'+id).val().slice(0,valu.length-lastWord.length-2)); }
				$('#badword').html('Bad word');
		}});
		$('#badword').html('');	   
	}	

}
</script>
<script language="javascript"> 
	$(document).ready(function() {
			$('#fancybox-media').fancybox({width: 620,height: 420,type: "iframe",iframe : {preload: false}});
	});		
</script>



 <a id="changetile-link" href="#change_tile_form" style="display:none;">change tile</a>

<div style="display:none;">







<div id="change_tile_form"  class="login-popupbox">







<div style="font-size:14px;float:left;">



<span class="padding-10pixels font-14px" id="selecttile" >Select a tile you want to change (or)</span>



<a class="orange" onclick="showtileform(<?php echo $allfinaos[0]["user_finao_id"];?>,<?php echo $userid;?>,'')">Create Your Own Tile ?</a>







</div>







<input type="hidden" id="newtileid" value="" />



<input type="hidden" id="newtileimage" value="" />



<input type="hidden" id="newtilename" value=""/>















<div class="clear-left"></div>







<div id="newtile" style="float:left;margin-top:10px;"></div>







<div id="oldtiles">







<div id="tiles" class="tiles-div" style="width:99%; height:400px!important; margin-bottom:20px;">







<table id="newtiledisplay" width="100%" cellpadding="3" cellspacing="10">







	<?php $j = 0;?>







	<?php foreach($alltiles as $i => $eachtile ){



		//print_r($eachtile);



			if($j==0){







			?>







	<tr>







		<?php







			}







		?>







        <td>







	    	<a href="javascript:void(0);">







	        	<div class="holder smooth" id="divtile-<?php echo $eachtile["tilename"];?>-<?php echo $eachtile["tile_id"];?>-<?php echo $eachtile["tileimg"];?>" onclick="clicktile(this.id)">







				<img src="<?php echo $this->cdnurl;?>/images/tiles/<?php echo str_replace(" ","",$eachtile["tileimg"]);?>" width="80" />







	            <div class="text-position"><?php echo $eachtile["tilename"];?></div>







				</div>







	        </a>







        </td>







		<?php







			$j=$j+1;







			if($j > 5){







			$j=0;	







		?>







	</tr>







	<?php







			}	







	} ?>







</table>







</div>







<!--<div class="clear left"></div>-->







<br />



<input type="hidden" value="<?php echo $tileinfo_id;?>" id="tileinfo_id" />



<input type="button" value="Move" class="orange-button" onclick="changetotile(<?php echo $allfinaos[0]["user_finao_id"];?>,<?php echo $userid;?>)"/>







</div>







</div>











</div> 

<script>$(".fancybox_group").fancybox();</script>
<input type="hidden" id="dispfinaotileid" value="<?php echo $tileid;?>"/>
<input type="hidden" id="totImgcount" value="<?php echo (isset($totImgCount)) ? $totImgCount : 0 ; ?>"/>
<input type="hidden" id="totVidcount" value="<?php echo (isset($totVidCount)) ? $totVidCount : 0 ; ?>"/>
<input type="hidden" id="totImgurl" value="<?php echo (isset($latestImgUrl)) ? $latestImgUrl : "" ; ?>"/>
<input type="hidden" id="totVidurl" value="<?php echo (isset($latestVidUrl)) ? $latestVidUrl : "" ; ?>"/>
<input type="hidden" id="finaopageid" value="<?php echo $page;?>"/>
<?php 

foreach($allfinaos as $eachfinao)
{//echo $v[$s]; $s++;?>


<div class="finao-canvas">
<?php 
if(isset($heroupdate) && $heroupdate != "")
{
$url = "";
}
else if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed"){
$url = Yii::app()->createUrl('finao/motivationmesg');
}else{
$url = Yii::app()->createUrl('finao/motivationmesg/frndid/'.$userid);
}?>


<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>



           <!-- <a class="btn-close" href="#"><img width="40" src="<?php echo $this->cdnurl; ?>/images/close.png"></a>-->



        	<div class="finao-canvas-left">



            	



<div id="imgvidmngt" style="display:none;"></div>



<div id="finaoprev">



   <div class="my-tile-hdline orange"><?php echo $tileinfo[0]->tilename;?></div>



               



			<?php  if($completed != "completed" )   {?>



			    <div class="tile-meter">					 



                    <?php $this->widget('ProgressBar',array('userid'=>$userid,'finao'=>'finao','tileid'=>$tileinfo[0]->tile_id,'share'=>(isset($share)) ? $share : "",'groupid'=>$groupid));?>



                </div>



				<?php }?>



				



                <div class="finao-display-area">



                    <!--<div class="slider-navigation">



                        <a class="slider-navigation-left" href="#">&nbsp;</a>									



                        <a class="slider-navigation-right" href="#">&nbsp;</a>



                    </div>-->



                    



                    <div style="position:relative;" class="fixed-imagea-area">



                    	 <div class="finao-image-area" >







			<?php $getimagesrc = $this->cdnurl."/images/logo-n.png";







					$imageflag = "false";



					$resizeWidth = $resizeHeight = 0;



					$Isvideo = 0;



					$videocode = "";	



					//print_r($getimages);



					$i =0;



				if(isset($getimages) && !empty($getimages))



					foreach($getimages as $allimages)



					{$i++;  



					/*	if($allimages["upload_sourceid"] == $eachfinao->user_finao_id)



						{*/



							if($allimages['uploadfile_name'] != "")



							{



								$imageflag = "true";



								$Isvideo = 0;



								if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/medium/".$allimages["uploadfile_name"]))



								{



									$getimagesrc = $this->cdnurl.$allimages["uploadfile_path"]."/medium/".$allimages['uploadfile_name'];



									if(isset($getimagesdetails) && count($getimagesdetails) >=1)



									{



										foreach($getimagesdetails as $imgvalues)



										{



											if($imgvalues["uploadfile_id"] == $allimages["uploaddetail_id"])



											{



												$resizeWidth = $imgvalues["resizeWidth"];



												$resizeHeight = $imgvalues["resizeHeight"];



											}



										}



									}	



								



								}else



								{



									



									$getimagesrc = $this->cdnurl.$allimages["uploadfile_path"]."/".$allimages['uploadfile_name'];



									if(isset($getimagesdetails) && count($getimagesdetails) >=1)



									{



										foreach($getimagesdetails as $imgvalues)



										{



											if($imgvalues["uploadfile_id"] == $allimages["uploaddetail_id"])



											{



												$resizeWidth = $imgvalues["resizeWidth"];



												$resizeHeight = $imgvalues["resizeHeight"];



											}



										}



									}	



								



								



								}



							}



							else



							{



							 



								



								if($allimages["videoid"] != "")



								{



									if($allimages->videostatus != 'ready')

									{ 

									$videoimage = Yii::app()->baseUrl."/images/video-encoding.jpg";

									$src = '#';

									}else

									{

									$videoimage = $allimages["video_img"];

									$src = "//www.viddler.com/embed/".$allimages["videoid"]."/?f=1&amp;player=simple&amp;secret=".$allimages["videoid"]."";

									}



									$Isvideo = 1;



									//$videoimage = $allimages["video_img"];



									//532, 305



									//$videocode = FinaoController::getviddlembedCode($allimages["videoid"],560,360);



								



								}



								elseif($allimages["video_embedurl"] != "")



								{



									$Isvideo = 1;



								/*	$videocode = $allimages["video_embedurl"];*/



									$videoimage=$allimages["video_img"];



								}



							}



						}



					/*}*/







				



				if($resizeWidth != 0 && $resizeHeight != 0)



					$style = 'width="'.$resizeWidth.'" height="'.$resizeHeight.'"';



				else



					$style = "";		



			?>



			



			<?php



					$noofpagImgVid = 0;



					$prevImg = 0;



					$nextImg = 0;



					



					if(isset($imgVidPrevNext) && $imgVidPrevNext != "")



					{



						$noofpagImgVid = $imgVidPrevNext['noofpagImgVid'];



						$prevImg = $imgVidPrevNext['prevImg'];



						$nextImg = $imgVidPrevNext['nextImg'];



					}



				



				?>



			



			<div id="finaoimages">



					



			<div class="slider-navigation">



				<?php //print_r($noofpagImgVid);?>



				<?php if($noofpagImgVid>1){



				



				if($prevImg <= $noofpagImgVid)



				



				{?>



				



					<a onclick="getprevImgVid(<?php echo $prevImg;?>,'<?php echo $groupid;?>',<?php echo $userid;?>,'prev',<?php echo $tileid;?>,'','finaopage',<?php echo $eachfinao->user_finao_id; ?>,0)" class="slider-navigation-left" href="javascript:void(0)">&nbsp;</a>



				



				<?php 



				



				}?>



								



				<?php if($nextImg<=$noofpagImgVid){?>



								



					<a onclick="getprevImgVid(<?php echo $nextImg;?>,'<?php echo $groupid;?>',<?php echo $userid;?>,'next',<?php echo $tileid;?>,'','finaopage',<?php echo $eachfinao->user_finao_id; ?>,0)" class="slider-navigation-right" href="javascript:void(0)">&nbsp;



						



					</a>



				



				



				



				<?php }?>



								



				



				<?php  }?>



				



				</div>



			



			<?php if(isset($getimages) && !empty($getimages)) { ?>

			<?php 

			 if($allimages->videoid=='' and $allimages->video_embedurl!='' )

				 {

				 	$s=explode('src=',$allimages->video_embedurl);

					$ss=explode('"',$s[1]);

					$src=$ss[1];

				 }

				 else if($allimages->video_img!='')

				 {

					 

					  

					

					 

				 	/*$src="//www.viddler.com/embed/".$allimages->videoid."/?f=1&amp;player=simple&amp;secret=".$allimages->videoid;*/

				 }

					if($Isvideo == 1){

					?> 

					<?php //if($allimages->videostatus === 'ready'){?>

                     <a id="fancybox-media" rel="" href="<?php echo $src;?>" title="<?php echo $eachImgVid["caption"]  ?>"> 

					 

					 <?php //} ?>



 <!--<div  style=" overflow:hidden;background:url('<?php echo $videoimage; ?>') center center no-repeat;height:240px;"  >       



</div>--> 

                        <img src="<?php echo $videoimage; ?>" style="width:300px; height:240px;" <?php //echo $style ; ?> />

					<?php if($allimages->videostatus === 'ready'){?> 

					 <span class="video-link-span1"></span>

					<?php }?>

									 

                   

                   <?php //if($allimages->videostatus === 'ready'){?> </a><?php //}?>

				   

				   <?php }else { ?> 

                     <a href="<?php echo  $this->cdnurl.$allimages["uploadfile_path"]."/".$allimages['uploadfile_name']; ?>" data-fancybox-group="gallery" class="fancybox_group"> 

                 <!-- <div  style=" overflow:hidden;background:url('<?php echo $getimagesrc ; ?>') center center no-repeat;height:240px;"  >       

</div>-->

						<img src="<?php echo $getimagesrc ; ?>" <?php echo $style ; ?> />

                        </a>		

			<?php	} ?>	

			<?php } else {

				

				if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"])  and $userinfo["profile_image"]!='')

				

				$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];

				

				else

				

				$src = $this->cdnurl."/images/no-image.jpg";

				?> 

            

            

					<img src="<?php echo $src ; ?>" />

			<?php } ?>





		   <div class="image-caption">

			<?php echo $allimages["caption"]; ?>

			 <?php 

 //if ($allimages["caption"] == 'Add Caption' || $allimages["caption"] == 'Enter Caption' ) {} else { echo $allimages["caption"];}?> 

			</div>







			</div>



			







       	</div>



                    </div>



                </div>











</div>



                



            <div  style="position:absolute; bottom:10px; width:350px;" <?php if($userid != Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){?>style="margin-top:40px;"<?php }?>>



			



			<?php if($noofpages>1 && $heroupdate==""){







					if($prev<=$noofpages)







					{?>







						<span class="left">







						<?php if($completed == "completed"){?>







							







							<a href="javascript:void(0)" onclick="view_single_finao(<?php echo $userid;?>,<?php echo '0';?>);getprevfinao(<?php echo $prev;?>,<?php echo $userid;?>,'prev',0,'completed','<?php echo $groupid;?>');" class="orange-link font-16px bolder">







							Prev FINAO







							</a>



						<?php }elseif($completed == "all"){?>



							<a href="javascript:void(0)" onclick="view_single_finao(<?php echo $userid;?>,<?php echo '0';?>);getprevfinao(<?php echo $prev;?>,<?php echo $userid;?>,'prev',0,'all','<?php echo $groupid;?>');" class="orange-link font-16px bolder">







							Prev FINAO







							</a>







						<?php }else{?>







							<a href="javascript:void(0)" onclick="view_single_finao(<?php echo $userid;?>,<?php echo '0';?>);getprevfinao(<?php echo $prev;?>,<?php echo $userid;?>,'prev',<?php echo $tileid;?>,0,'<?php echo $groupid;?>');" class="orange-link font-16px bolder">Prev FINAO</a>







						<?php }?>







						</span>







					<?php 







					}else{?>







					<?php }?>







					<?php if($next<=$noofpages){?>







						<span class="right">				







						<?php if($completed == "completed"){?>







							<a onclick="view_single_finao(<?php echo $userid;?>,<?php echo '1';?>);getprevfinao(<?php echo $next;?>,<?php echo $userid;?>,'next',0,'completed','<?php echo $groupid;?>');" class="orange-link font-16px bolder">







							Next FINAO







							</a>



						<?php }elseif($completed == "all"){?>



							<a href="javascript:void(0)" onclick="view_single_finao(<?php echo $userid;?>,<?php echo '1';?>);getprevfinao(<?php echo $next;?>,<?php echo $userid;?>,'prev',0,'all','<?php echo $groupid;?>');" class="orange-link font-16px bolder">







							Next FINAO







							</a>







						<?php }else{?>







							<a onclick="view_single_finao(<?php echo $userid;?>,<?php echo '1';?>);getprevfinao(<?php echo $next;?>,<?php echo $userid;?>,'next',<?php echo $tileid;?>,0,'<?php echo $groupid;?>');" class="orange-link font-16px bolder">







								Next FINAO







							</a>







						<?php }?>







						</span>







					<?php }else{?>







			<?php } }?>







        </div>     



            </div>



            



             <?php if(!($userid != Yii::app()->session['login']['id'])) {
				 
				 
				 
				  ?>



            <div class="finao-canvas-right">



           <p class="finao-def-msg" id="editfinaomesg-<?php echo $eachfinao->user_finao_id;?>" style="display:none;">







				<textarea id="newmesg-<?php echo $eachfinao->user_finao_id;?>" class="finaos-area" style="width:98%; resize:none; margin-bottom:10px;" onkeyup="change_va(event,this.id);" onkeydown=" if(closefunction(this,event,'finao',<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>) == 'false'){ return false; }" onblur="change_va(event,this.id);" ><?php echo ucfirst($eachfinao->finao_msg);?></textarea>



				



				<input type="button" class="orange-button" value="Save" id="savefinao-<?php echo $eachfinao->user_finao_id;?>" onclick="savefinaomesg(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>)" style="margin-bottom:10px;" />



				



<input type="button" class="orange-button" value="Cancel" id="closefinao-<?php echo $eachfinao->user_finao_id;?>" onclick="closefinao(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>)" />



				 



			</p>



			



          <div class="finao-message" id="finaomesg-<?php echo $eachfinao->user_finao_id;?>">			                <?php echo ucfirst($eachfinao->finao_msg);?> 



                </div>



             <?php /*?><div class="edit-share-container">



                <?php



                



                if($userid==Yii::app()->session['login']['id'] && $completed != "completed" )



                



                { if(isset($share) && $share!="share"){?>



                



            <span class="left" style="margin-top:10px;">    <a id="editlink<?php //-echo $eachfinao->user_finao_id;ondblclick?>" href="javascript:void(0)" class="orange-link font-12px" onclick="showeditfinaomesg(<?php echo $eachfinao->user_finao_id;?>)">Edit FINAO</a> |



                <a id="delfinao<?php // -echo $eachfinao->user_finao_id;?>" class="orange-link font-12px" onclick="deletefj('finao',<?php echo $userid;?>,0,<?php echo $eachfinao->user_finao_id;?>)" >Delete FINAO</a> |



                <a onclick="edittile(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>)" class="orange-link font-12px">Move FINAO</a></span>



                <?php } } ?>



          <!-- FINAO SHARING STARTS -->  



<!-- facebook sharing starts -->				



<?php 







//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES



//DATA FOR SHARING ON FACEBOOK







 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);



 $getimagesrc1=$this->cdnurl.$allimages["uploadfile_path"]."/medium/".$allimages['uploadfile_name'];



 $imgsrcenc = urlencode($getimagesrc1);



 $summary = Yii::app()->session['login']['username'].'+shared+a+FINAO+in+finaonation.com';



 



?>  







<span class="sharing-container right"><span class="left bolder" style="margin-right:3px; margin-top:3px;">SHARE</span>



 <a href="http://finaonation.com/profile/share/finaoid/<?php echo $eachfinao->user_finao_id;?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=http%3A%2F%2Ffinaonation.com%2Fprofile%2Fshare%2Ffinaoid%2F<?php echo $eachfinao->user_finao_id;?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id'];?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 



      'facebook-share-dialog', 



      'width=626,height=436'); 



    return false;">



	<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="18" height="18" /></a> 



 <a href="https://twitter.com/share?url=http%3A%2F%2Ffinaonation.com%2Fprofile%2Fshare%2Ffinaoid%2F<?php echo $eachfinao->user_finao_id;?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id']; ?>" class="twitter-share-button" data-url="http://finaonation.com/profile/share/finaoid/<?php echo $eachfinao->user_finao_id;?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="18" height="18" /></a>



 



 </span>			  



			  



	



			    </div><?php */?> 



                



                <div class="edit-share-container">



                <?php



                



                if($userid==Yii::app()->session['login']['id'] && $completed != "completed" )



                



                { if(isset($share) && $share!="share"){?>



                



            <span class="left" style="margin-top:10px;">    <a id="editlink<?php //-echo $eachfinao->user_finao_id;ondblclick?>" href="javascript:void(0)" class="orange-link font-12px" onclick="showeditfinaomesg(<?php echo $eachfinao->user_finao_id;?>)">Edit FINAO</a> |



                <a id="delfinao<?php // -echo $eachfinao->user_finao_id;?>" class="orange-link font-12px" onclick="deletefj('finao',<?php echo $userid;?>,0,<?php echo $eachfinao->user_finao_id;?>,<?php echo $tileid;?>)" >Delete FINAO</a> 
<?php if($groupid==''){?>				
				| <?php }?>
                <a onclick="edittile(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>)" class="orange-link font-12px"><?php if($groupid==''){?>Move FINAO<?php }?></a></span>



                <?php } } ?>



          <!-- FINAO SHARING STARTS -->  



<!-- facebook sharing starts -->				



<?php 







//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES



//DATA FOR SHARING ON FACEBOOK







 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);



 	if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/medium/".$allimages["uploadfile_name"]))



								{



									$getimagesrc1= $this->cdnurl.$allimages["uploadfile_path"]."/medium/".$allimages['uploadfile_name'];



									}



										else if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/".$allimages["uploadfile_name"]))



									{



									



						 $getimagesrc1=$this->cdnurl.$allimages["uploadfile_path"]."/".$allimages['uploadfile_name'];			



									}



									else



									{



				 $getimagesrc1=$this->cdnurl."/images/logo-n.png";		



									



									}







 $imgsrcenc = urlencode($getimagesrc1);



 $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/finaoid/".$eachfinao->user_finao_id."/userid/".Yii::app()->session['login']['id']; 



 $urlpath1 = urlencode($urlpath);



 //echo $urlpath1;



 $summary = Yii::app()->session['login']['username'].'+shared+a+'.ucfirst($eachfinao->finao_msg).'+in+finaonation.com';



 



?>  







<span class="sharing-container right"><span class="left bolder" style="margin-right:3px; margin-top:3px;">SHARE</span>



 <a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 



      'facebook-share-dialog', 



      'width=626,height=436'); 



    return false;">



	<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="18" height="18" /></a> 



 <a href="https://twitter.com/share?url=<?php echo $urlpath1;?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/share/finaoid/<?php echo $eachfinao->user_finao_id;?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="18" height="18" /></a>



 



 </span>			  



			  



	



			    </div>     



                



                 



				 	



						



						<div class="left">



                   



                   <!-- <img width="67" src="images/dashboard/ahead.png">-->



				<?php if($eachfinao->Iscompleted==1){?>



                <img width="70" src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png">



                <?php }  if($userid==Yii::app()->session['login']['id'] && $completed != "completed" )



                



                { if(isset($share) && $share!="share"){?> 



				  <div class="update-finao-box" id="hideimgvideo">



                <div class="update-finao-area">



                    	<textarea class="update-finao-textarea" placeholder="Update this FINAO" name="journalmsg" id="journalmsg" onkeyup="change_va(event,this.id);" onblur="change_va(event,this.id);if(this.value=='')this.value=this.defaultValue;"



        onfocus="if(this.value==this.defaultValue)this.value='';"></textarea>



                    </div>



                    



                    <div class="upload-finao-media">



                



							<span style="margin-right:5px; margin-top:0px;" class="left font-14px">



							



							<span class="left" style="margin-right:5px;">Add Media:</span> <ul class="status-buttons left">



                            <a title="upload images" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,'<?php echo $groupid;?>',<?php echo $eachfinao->user_finao_id;?>,'finao','Image')"><li class="finao-upload-image"></li></a>



                            <a title="upload videos" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,'<?php echo $groupid;?>',<?php echo $eachfinao->user_finao_id;?>,'finao','Video');"><li class="finao-upload-video"></li></a>



                        </ul></span>



						



                        	 <div class="right" style="margin-right:3px; margin-top:5px;" >



						               <span id="addjournal">



                                       <a class="orange-square" onclick="addjournal(<?php echo $userid; ?>,<?php echo $eachfinao->user_finao_id; ?>)" href="javascript:void(0);">Update FINAO</a> 



                        <a class="orange-square" id="canceljournal" href="javascript:void(0);">Cancel</a>



                        </span>



						</div> 



							</div> 



							<?php } }?>



							



						</div>



						<div style="position:absolute; bottom:0; width:100%; left:0;">



                   



<?php if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed" )



{?>



                    <span class="left font-15px">



                    <input type="radio" id="ispublic-<?php echo $eachfinao->user_finao_id;?>" <?php if($eachfinao->Isdefault != 1) { ?> onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'public',<?php echo $tileid;?>)" <?php } ?> name="finao_pub" /> Make FINAO Public



					<input type="radio" <?php if($eachfinao->Isdefault != 1) { ?> onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'public',<?php echo $tileid;?>)"  checked="checked"<?php } ?> name="finao_pub"  /> Make FINAO Private



                    </span>



                    <span class="right">



                         <span style="float:left;">



                           <!-- <img width="67" src="images/dashboard/onTrack.png"> 



                            <img width="67" src="images/dashboard/ahead.png">



                            <img width="67" src="images/dashboard/behind.png"> 



                            <img width="67" src="images/dashboard/complete.png"> -->



                  







                	<ul class="status-buttons">







                        <?php



						



						foreach($status as $finaostatus)



									



						{?>







							<a href="javascript:void(0)" onclick="updatefinao(<?php echo $eachfinao->user_finao_id;?>,<?php echo $finaostatus->lookup_id;?>,<?php echo $userid;?>,'allfinaos',<?php echo $tileid;?>)">







								<li <?php if($finaostatus->lookup_name=="Behind" )







								{







									if($finaostatus->lookup_id==$eachfinao->finao_status)







									{?>







										class="finao-behind finao-behind-active" 







									<?php }else{?>







										 class="finao-behind"







								 <?php }







								 }elseif($finaostatus->lookup_name=="Ahead") 







								 {







								 	if($finaostatus->lookup_id==$eachfinao->finao_status)







									{?>







									 class="finao-ahead finao-ahead-active" 







									 <?php }else{?> 







									 class="finao-ahead" 







								<?php }}elseif($finaostatus->lookup_name=="On Track" )







									{







										if($finaostatus->lookup_id==$eachfinao->finao_status){?>







										class="finao-ontrack finao-ontrack-active"







										<?php }else{?>







										 class="finao-ontrack" 







								<?php }}?>>







						</li>



                        </a>







		            	<?php }?>







						<?php if($eachfinao->Iscompleted==1){?>







						<a href="javascript:void(0)" id="complete-<?php echo $eachfinao->user_finao_id;?>" ><li class="finao-complete finao-complete-active"></li></a>







						<?php }else{?>







		                <a href="javascript:void(0)" id="complete-<?php echo $eachfinao->user_finao_id;?>" onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'complete',<?php echo $tileid;?>)"><li class="finao-complete"></li></a>







						<?php }?>







                    </ul>







				<?php 	}else if($userid!=Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){







			?>







			<ul class="status-buttons">







				<?php if($eachfinao->Iscompleted != 1) foreach($status as $finaostatus)







				    {







				     if($finaostatus->lookup_name=="Behind")







				     {







				      if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				       $class="finao-behind finao-behind-active"; 







				      }







				     }elseif($finaostatus->lookup_name=="Ahead") 







				      {







				       if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				        $class="finao-ahead finao-ahead-active" ;







				       }







				     }elseif($finaostatus->lookup_name=="On Track" )







				     {







				      if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				       $class="finao-ontrack finao-ontrack-active";







				      }







				     }?>







				   <?php }?>



			</ul>







			







			<?php







			}







			?>



 



                       </span>



                    </span>



					



					</div>



						



					



						



                        



                   



                    <!--<span style="position:absolute; right:5px; bottom:70px;"><a href="#" class="orange-square font-16px">Update</a></span>-->



                



                <?php 
				
				
				}else{?> 



				
                  <?php if($ismember === '1' ){ 
				  
                      ?>



            <div class="finao-canvas-right">



           <p class="finao-def-msg" id="editfinaomesg-<?php echo $eachfinao->user_finao_id;?>" style="display:none;">







				<textarea id="newmesg-<?php echo $eachfinao->user_finao_id;?>" class="finaos-area" style="width:98%; resize:none; margin-bottom:10px;" onkeyup="change_va(event,this.id);" onkeydown=" if(closefunction(this,event,'finao',<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>) == 'false'){ return false; }" onblur="change_va(event,this.id);" ><?php echo ucfirst($eachfinao->finao_msg);?></textarea>



				



				<input type="button" class="orange-button" value="Save" id="savefinao-<?php echo $eachfinao->user_finao_id;?>" onclick="savefinaomesg(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>)" style="margin-bottom:10px;" />



				



<input type="button" class="orange-button" value="Cancel" id="closefinao-<?php echo $eachfinao->user_finao_id;?>" onclick="closefinao(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>)" />



				 



			</p>



			



          <div class="finao-message" id="finaomesg-<?php echo $eachfinao->user_finao_id;?>">			                <?php echo ucfirst($eachfinao->finao_msg);?> 



                </div>



              



                



                <div class="edit-share-container">



                <?php



                



               /* if($userid==Yii::app()->session['login']['id'] && $completed != "completed" )



                



                { if(isset($share) && $share!="share"){*/?>



                



            <span class="left" style="margin-top:10px;">    
            
            
            <a id="editlink<?php //-echo $eachfinao->user_finao_id;ondblclick?>" href="javascript:void(0)" class="orange-link font-12px" >Edit FINAO</a> |



                <a id="delfinao<?php // -echo $eachfinao->user_finao_id;?>" class="orange-link font-12px"  >Delete FINAO</a> |



                <a class="orange-link font-12px">Move FINAO</a></span>

<!--
            <a id="editlink<?php //-echo $eachfinao->user_finao_id;ondblclick?>" href="javascript:void(0)" class="orange-link font-12px" onclick="showeditfinaomesg(<?php echo $eachfinao->user_finao_id;?>)">Edit FINAO</a> |



                <a id="delfinao<?php // -echo $eachfinao->user_finao_id;?>" class="orange-link font-12px" onclick="deletefj('finao',<?php echo $userid;?>,0,<?php echo $eachfinao->user_finao_id;?>,<?php echo $tileid;?>)" >Delete FINAO</a> |



                <a onclick="edittile(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>)" class="orange-link font-12px">Move FINAO</a></span>

-->

                <?php //} } ?>



          <!-- FINAO SHARING STARTS -->  



<!-- facebook sharing starts -->				



<?php 







//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES



//DATA FOR SHARING ON FACEBOOK







 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);



 	if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/medium/".$allimages["uploadfile_name"]))



								{



									$getimagesrc1= $this->cdnurl.$allimages["uploadfile_path"]."/medium/".$allimages['uploadfile_name'];



									}



										else if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/".$allimages["uploadfile_name"]))



									{



									



						 $getimagesrc1=$this->cdnurl.$allimages["uploadfile_path"]."/".$allimages['uploadfile_name'];			



									}



									else



									{



				 $getimagesrc1=$this->cdnurl."/images/logo-n.png";		



									



									}







 $imgsrcenc = urlencode($getimagesrc1);



 $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/finaoid/".$eachfinao->user_finao_id."/userid/".Yii::app()->session['login']['id']; 



 $urlpath1 = urlencode($urlpath);



 //echo $urlpath1;



 $summary = Yii::app()->session['login']['username'].'+shared+a+'.ucfirst($eachfinao->finao_msg).'+in+finaonation.com';



 



?>  







<span class="sharing-container right"><span class="left bolder" style="margin-right:3px; margin-top:3px;">SHARE</span>



 <a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 



      'facebook-share-dialog', 



      'width=626,height=436'); 



    return false;">



	<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="18" height="18" /></a> 



 <a href="https://twitter.com/share?url=<?php echo $urlpath1;?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/share/finaoid/<?php echo $eachfinao->user_finao_id;?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="18" height="18" /></a>



 



 </span>			  



			  



	



			    </div>     



                



                 



				 	



						



						<div class="left">



                   



                   <!-- <img width="67" src="images/dashboard/ahead.png">-->



				<?php if($eachfinao->Iscompleted==1){?>



                <img width="70" src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png">



                <?php }  /*if($userid==Yii::app()->session['login']['id'] && $completed != "completed" )



                



                { if(isset($share) && $share!="share"){*/?> 



				  <div class="update-finao-box" id="hideimgvideo">



                <div class="update-finao-area">



                    	<textarea class="update-finao-textarea" placeholder="Update this FINAO" name="journalmsg" id="journalmsg" onkeyup="change_va(event,this.id);" onblur="change_va(event,this.id);if(this.value=='')this.value=this.defaultValue;"



        onfocus="if(this.value==this.defaultValue)this.value='';"></textarea>



                    </div>



                    



                    <div class="upload-finao-media">



                



							<span style="margin-right:5px; margin-top:0px;" class="left font-14px">



							



							<span class="left" style="margin-right:5px;">Add Media:</span> <ul class="status-buttons left">



                            <a title="upload images" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,'<?php echo $groupid;?>',<?php echo $eachfinao->user_finao_id;?>,'finao','Image')"><li class="finao-upload-image"></li></a>



                            <a title="upload videos" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,'<?php echo $groupid;?>',<?php echo $eachfinao->user_finao_id;?>,'finao','Video');"><li class="finao-upload-video"></li></a>



                        </ul></span>



						



                        	 <div class="right" style="margin-right:3px; margin-top:5px;" >



						               <span id="addjournal">



                                       <a class="orange-square" onclick="addjournal(<?php echo $userid; ?>,<?php echo $eachfinao->user_finao_id; ?>)" href="javascript:void(0);">Update FINAO</a> 



                        <a class="orange-square" id="canceljournal" href="javascript:void(0);">Cancel</a>



                        </span>



						</div> 



							</div> 



							<?php //} }?>



							



						</div>



						<div style="position:absolute; bottom:0; width:100%; left:0;">



                   



<?php if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed" )



{?>



                    <span class="left font-15px">



                    <input type="radio" id="ispublic-<?php echo $eachfinao->user_finao_id;?>" <?php if($eachfinao->Isdefault != 1) { ?> onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'public',<?php echo $tileid;?>)" <?php } ?> name="finao_pub" /> Make FINAO Public



					<input type="radio" <?php if($eachfinao->Isdefault != 1) { ?> onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'public',<?php echo $tileid;?>)"  checked="checked"<?php } ?> name="finao_pub"  /> Make FINAO Private



                    </span>



                    <span class="right">



                         <span style="float:left;">



                           <!-- <img width="67" src="images/dashboard/onTrack.png"> 



                            <img width="67" src="images/dashboard/ahead.png">



                            <img width="67" src="images/dashboard/behind.png"> 



                            <img width="67" src="images/dashboard/complete.png"> -->



                  







                	<ul class="status-buttons">







                        <?php



						



						foreach($status as $finaostatus)



									



						{?>







							<a href="javascript:void(0)" onclick="updatefinao(<?php echo $eachfinao->user_finao_id;?>,<?php echo $finaostatus->lookup_id;?>,<?php echo $userid;?>,'allfinaos',<?php echo $tileid;?>)">







								<li <?php if($finaostatus->lookup_name=="Behind" )







								{







									if($finaostatus->lookup_id==$eachfinao->finao_status)







									{?>







										class="finao-behind finao-behind-active" 







									<?php }else{?>







										 class="finao-behind"







								 <?php }







								 }elseif($finaostatus->lookup_name=="Ahead") 







								 {







								 	if($finaostatus->lookup_id==$eachfinao->finao_status)







									{?>







									 class="finao-ahead finao-ahead-active" 







									 <?php }else{?> 







									 class="finao-ahead" 







								<?php }}elseif($finaostatus->lookup_name=="On Track" )







									{







										if($finaostatus->lookup_id==$eachfinao->finao_status){?>







										class="finao-ontrack finao-ontrack-active"







										<?php }else{?>







										 class="finao-ontrack" 







								<?php }}?>>







						</li>



                        </a>







		            	<?php }?>







						<?php if($eachfinao->Iscompleted==1){?>







						<a href="javascript:void(0)" id="complete-<?php echo $eachfinao->user_finao_id;?>" ><li class="finao-complete finao-complete-active"></li></a>







						<?php }else{?>







		                <a href="javascript:void(0)" id="complete-<?php echo $eachfinao->user_finao_id;?>" onclick="updatefinaopublic(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'complete',<?php echo $tileid;?>)"><li class="finao-complete"></li></a>







						<?php }?>







                    </ul>







				<?php 	}else if($userid!=Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){







			?>







			<ul class="status-buttons">







				<?php if($eachfinao->Iscompleted != 1) foreach($status as $finaostatus)







				    {







				     if($finaostatus->lookup_name=="Behind")







				     {







				      if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				       $class="finao-behind finao-behind-active"; 







				      }







				     }elseif($finaostatus->lookup_name=="Ahead") 







				      {







				       if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				        $class="finao-ahead finao-ahead-active" ;







				       }







				     }elseif($finaostatus->lookup_name=="On Track" )







				     {







				      if($finaostatus->lookup_id==$eachfinao->finao_status)







				      {







				       $class="finao-ontrack finao-ontrack-active";







				      }







				     }?>







				   <?php }?>



			</ul>







			







			<?php







			}







			?>



 



                       </span>



                    </span>



					



					</div>



						



					



						



                        



                   



                    <!--<span style="position:absolute; right:5px; bottom:70px;"><a href="#" class="orange-square font-16px">Update</a></span>-->



                



                <?php 
                  
				  }else{?> 
				  
				         <div class="finao-canvas-right">



            	<div class="edit-share-container">



                	



                    <span style="margin-left:10px; margin-top:3px;" class="right">



                        <input type="hidden" id="frndtileid" value=""/>



                        <input type="hidden" value="" id="userfrndid"/>



                        <div id="trackingstatus" style="float:right;">



                        </div>



                    </span>



                



			 



				<?php 







//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES



//DATA FOR SHARING ON FACEBOOK







 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);



 if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/medium/".$allimages["uploadfile_name"]))



								{



									$getimagesrc1= $this->cdnurl.$allimages["uploadfile_path"]."/medium/".$allimages['uploadfile_name'];



									}



										else if(file_exists(Yii::app()->basePath."/../".$allimages["uploadfile_path"]."/".$allimages["uploadfile_name"]))



									{



									



						 $getimagesrc1=$this->cdnurl.$allimages["uploadfile_path"]."/".$allimages['uploadfile_name'];			



									}



									else



									{



				 $getimagesrc1=$this->cdnurl."/images/logo-n.png";		



									



									}



 $imgsrcenc = urlencode($getimagesrc1);



 



   $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/finaoid/".$eachfinao->user_finao_id."/userid/".Yii::app()->session['login']['id']."/frendid/".$userid; 



 $urlpath1 = urlencode($urlpath);



 



 $summary = Yii::app()->session['login']['username'].'+shared+a+FINAO+in+finaonation.com';



 



?>     



    <span class="sharing-container right">



	<span class="left" style="margin-top: 2px;margin-right: 2px;" ><img src="<?php echo $this->cdnurl;?>/images/icon-flag.png" width="18" height="18" id="flag" alt="FLAG" href="#infomail"  class="fancybox-share" style="cursor:pointer; float: left;margin-right: 3px;"/>



<b>Flag inappropriate |</b></span>



<span class="left bolder" style="margin-right:3px; margin-top:3px;">SHARE</span>



	



	



    <a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 



    'facebook-share-dialog', 



    'width=626,height=436'); 



    return false;">



    <img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="18" height="18" /></a> 



    <a href="https://twitter.com/share?url=p[url]=<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="http://finaonation.com/profile/share/finaoid/<?php echo $eachfinao->user_finao_id;?>/userid/<?php echo Yii::app()->session['login']['id']; ?>/frendid/<?php echo $userid; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="18" height="18" /></a>



	<span id="infomail" style=" display:none;">You have marked this FINAO as inappropriate.A mail has been sent to the Admin successfully</span>  







<script type="text/javascript">



$("#flag").click(function(){



<?php $finaoid=$eachfinao->user_finao_id;



      $frendid=$userid;



	  $userid=Yii::app()->session['login']['id'];  



?>



	var url='<?php echo Yii::app()->createUrl("/finao/mail"); ?>';



	$.post(url, { finaoid : <?php echo $finaoid;?>, frendid :<?php echo $frendid; ?>,userid:<?php echo $userid; ?>});



   $('#infomail').html('You have marked this FINAOas inappropriate.A mail has been sent to the Admin successfully');



});







</script>







	</span>



                    



                    



                </div>



                <div style="font-size:20px; line-height:36px;" class="finao-message left">



                 <?php echo ucfirst($eachfinao->finao_msg);?> 



                </div>



                



                <div class="left">



                    <span style="float:left; margin-top:8px;">



                   <!-- <img width="67" src="images/dashboard/ahead.png">-->



				<?php if($eachfinao->Iscompleted==1){?>



                <img width="70" src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png">



                <?php } else{?>



                <img width="70" src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($eachfinao->finaoStatus->lookup_name);?>.png">



                <?php }?>



                    



                    </span>



                </div>



            </div>
				  
				  <?php } ?>


				



				



				<?php }?>	



				



				



                



                </div>



                



                



                   <div id="imgvidupload"></div>



            



           



             



                </div>



               <?php } ?> 



            </div>



        </div>



		 



<?php /*?><input type="hidden" id="next_finao" name="text" value="<?php echo $arrayfinao[$next]["user_finao_id"];?>" />



<input type="hidden" id="prev_finao"  value="<?php echo $arrayfinao[$prev]["user_finao_id"];?>" />



<?php */?>



<input type="hidden" id="next_finao" name="text" value="<?php echo $eachfinao->user_finao_id;?>" />



<input type="hidden" id="prev_finao"  value="<?php echo $arrayfinao[$prev]["user_finao_id"];?>" />







        



<script type="text/javascript">



$( document ).ready( function() {



	var isfrommenu = document.getElementById('isfrommenu');



	if(typeof(isfrommenu) != 'undefined' && isfrommenu != null)



	{



		var data = '<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>';



		$("#closefinaodiv").html(data);



	}



 var userid = document.getElementById('userid').value;







 <?php if($tileinfo[0]->tilename!= ""){?>



	$("#newtiledisplay .holder-active").addClass("holder smooth").removeClass("holder-active");



	var div = document.getElementById("divtile-<?php echo $tileinfo[0]->tilename;?>-<?php echo $tileinfo[0]->tile_id;?>");



	if(typeof(div) != 'undefined' && div != null)



		document.getElementById("divtile-<?php echo $tileinfo[0]->tilename;?>-<?php echo $tileinfo[0]->tile_id;?>").className = "holder-active";



//alert("hii");



 <?php }?>



 



 	<?php  



			if($allfinaos != "") {?>







			<?php		



				if(!empty($allfinaos)){?>



			<?php 		



				foreach($allfinaos as $finaovalue)



				{ 



				?>



				<?php if(isset($getimages) && !empty($getimages)){ ?>



						//	getDetails("Image",'<?php echo $finaovalue->userid;?>','<?php echo $finaovalue->user_finao_id;?>',"finaopage");



				<?php } ?>



        		 <?php



				if($finaovalue->finao_status_Ispublic==1){?>



					var element =  document.getElementById('ispublic-<?php echo $finaovalue->user_finao_id;?>');



						if (typeof(element) != 'undefined' && element != null)



						{



						  document.getElementById('ispublic-<?php echo $finaovalue->user_finao_id;?>').checked = true;



						}



					<?php } if($finaovalue->Iscompleted==1){?>



					var element =  document.getElementById('complete-<?php echo $finaovalue->user_finao_id;?>');



						if (typeof(element) != 'undefined' && element != null)



						{



						  // exists.



						  document.getElementById('complete-<?php echo $finaovalue->user_finao_id;?>').checked = true;



						}



			<?php }?>



			document.getElementById('statusid').value = "<?php echo $finaovalue->finaoStatus->lookup_name;?>";



			<?php }?>







			statusborder();







			<?php }?>







			<?php	







			}







		?>







 







 <?php if(isset($completed) && $completed == "completed"){?>







	var completed = document.getElementById('iscompleted');







	if(completed!=null)







		completed.value = "completed";







 <?php }?>







  $("#changetile-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onClosed'		: function() {



	    	}



	});	



  });







function edittile(finaoid,userid)



{



	var r=confirm("Do you really want to move this FINAO to another tile? ")



	if (r==true)



	{



	 	flag = "true";



		$("#changetile-link").trigger("click");



	}



	else



	{



		flag = "false";



	}



}







function clicktile(id)
{
	var checkboxid = id.split("-");
	if($("#newtileid").length)
		$("#newtileid").val(checkboxid[2]);
	if($("#newtilename").length)
		$("#newtilename").val(checkboxid[1]);
	if($("#newtileimage").length)
		$("#newtileimage").val(checkboxid[3]);
	$("#newtiledisplay .holder-active").addClass("holder smooth").removeClass("holder-active");
	document.getElementById(id).className = "holder-active";
}







function changetotile(finaoid,userid)



 {



 	var tileid = document.getElementById('newtileid').value;



 	var tilename = document.getElementById('newtilename').value;



	var tileinfo_id = document.getElementById('tileinfo_id').value;



	var newtileimage = document.getElementById('newtileimage').value;



	//alert(newtileimage); return false;



	



 	if(tilename.length >= 1 && tileid.length >= 1)



 	{



 		var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';



 		$.post(url, { userid :  userid , finaoid : finaoid ,tileid : tileid , tilename : tilename,tileinfo_id:tileinfo_id,newtileimage:newtileimage},



 	   		function(data){



	   			if(data)



				{



					parent.$.fancybox.close();



					getfinaos(userid, data);



					//	refreshwidget(userid);



					//alert("Your FINAO has been successfully moved");



     			}



	     });



	}



	else



	{



		document.getElementById('tiles').className = "tiles-div-error";



	}



 }







 



 







function showvideodiv()



{



  //alert("Clicked");



  $('#hdnuploadtype').attr('value',35);



  $('#videopreview').show();



}







function readURL(input) {







//$('#hdnuploadtype').attr('value',34);	



/*document.getElementById('loading').innerHTML = '<div><img src="<?php echo Yii::app()->basePath;?>/images/progressbar.gif" border="0" /></div>';	*/



if (input.files && input.files[0]) {



var reader = new FileReader();



reader.onload = function (e) {







$('#test').show().attr('src', e.target.result);



}



reader.readAsDataURL(input.files[0]);



}



}







  



/* Adding Journal */







$('#journalmsg').focus(function()



{



  $('#journalmsg').removeClass('update-finao-textarea-error');



});



function addjournal(userid,finaoid)
{
	
	var groupid = "";
	var userid = document.getElementById('userid').value;
	var ismember = document.getElementById('ismember').value;
	var groupid = document.getElementById('groupid').value;
	var journalmsg = $('#journalmsg').val();
    //alert(ismember);
	if(journalmsg == '')
	{
		$('#journalmsg').addClass('update-finao-textarea-error');
		return false;
	}
	var url = '<?php echo Yii::app()->createUrl("/finao/AddNewJournal")?>';
	$.post(url, { userid:userid, finaoid:finaoid , userid : userid ,journalmsg:journalmsg,groupid:groupid,ismember:ismember},
	   		function(data){
			if(data)
			{    
			refreshwidget(userid);  
			$('#journalmsg').attr('value','');
			view_single_finao(userid,data);
			//getthatfinao(data);
			//getfinaos(<?php echo Yii::app()->session['login']['id'] ?>,data);
			} 
	     }); 
}







$('#canceljournal').click(function(){



								   $('#journalmsg').attr('value','');



								   });







//$('#journalmessage').change(function(){alert(this.value)}).keyup(function(){alert(this.value)});



//$('#journalmessage').change(funtion(){alert("Helllo")}).keyup(funtion(){(this).val()}); 



</script>		