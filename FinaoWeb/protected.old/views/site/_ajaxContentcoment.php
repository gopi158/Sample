<?php foreach($comments as $eachcmnt){?>
	
	<?php $var =  Yii::app()->session['login']['id']; ?>
	<?php $blogid = Blogs::model()->findAllByAttributes(array('blog_id'=>$eachcmnt->goal_id)); 
	foreach($blogid as $blogtype){?> 
	<!------------------------------ Start of Blog Comments ---------------------->
	 <?php if($blogtype->type == "blogs"){?>
	<div class="comment-tab" style="position:relative;">
    	<div class="comment-tab-left"><img src="<?php echo ($eachcmnt->commentAuthor->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$eachcmnt->commentAuthor->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="25"/></div>
       
	    <div class="comment-tab-right">
        <div class="run-text font-12px"><span  class="blue-font12"><?php $name = $eachcmnt->commentAuthor->fname.' '.$eachcmnt->commentAuthor->lname; echo $name;?>&nbspcommented as:</span></br>
		<span class="blue-font11">
		<?php echo date("M  j,  Y  \a\&#116 g:i a", strtotime($eachcmnt->commented_date));?></span>  
		
		</div>
		
        <div class="left">
			<?php echo $eachcmnt->comment_content;?><br></br>
			<?php if(isset(Yii::app()->session['login'])){?>
			<a class="blue-link" onclick="showreply(<?php echo $eachcmnt->comment_id;?>)">Reply</a> <span id="orone-<?php echo $eachcmnt->comment_id;?>" style="display:none;" > | </span> 
			<a class="blue-link" id="cancelling-<?php echo $eachcmnt->comment_id;?>" onclick="hidereply(<?php echo $eachcmnt->comment_id;?>)" style="display:none;">Cancel</a>
			<?php } ?>
		</div>
        </div>
    </div>
	 <div class="run-text  font-12px">
	 <input type="hidden" id="blogid" value="<?php echo $longid ;?>" />
										<input type="hidden" id="commnttype" value="blog_comment" />
										<input type="hidden" id="parentid" value="<?php echo $eachcmnt->comment_id;?>" />
		 <input type="hidden" id="userid" value="<?php echo Yii::app()->session['login']['id'];?>" />
		 <?php $useridfetch = User::model()->findAllByAttributes(array('userid'=>$var)); ?>
    	 <div id="reply-<?php echo $eachcmnt->comment_id;?>" style="display:none;">
		 <div class="blog-comment-tab">
		 <?php  foreach($useridfetch as $forimage){?>
		 <div class="comment-tab-left" style="width:6%"><img src="<?php echo ($forimage->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$forimage->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="25""/>
		 </div>
		 <?php } ?>
		<div class="comment-tab-right " style="width:94%"><input type="text" class="textbox-comment" id="<?php echo $eachcmnt->comment_id;?>" value="Write a comment and press enter..."  onclick="if((value=='Write a comment and press enter...')) value=''" onblur="if(!value) value='Write a comment and press enter...'" onkeypress="if(value !='Write a comment and press enter...')return submitblogcmntreply(this,event,this.id,1)"/></div>
						 	
	</div>	
	</div>	
	<input type="button" style="display:none;" id="newcmnt-<?php echo  $eachcmnt->comment_id;?>" />
	 <!--<div><a href="#" class="blue-link">Cancel</a></div>-->
	</div>
		<?php $childcomments = Comments::model()->findAllByAttributes(array('goal_id'=>$eachcmnt->goal_id,'goal_type'=>'blog_comment','status'=>1,'comment_parent_id'=>$eachcmnt->comment_id));
	if($childcomments){
		//echo "hiii";
		
	?>
	<div id="data-<?php echo $eachcmnt->comment_id?>" style="padding-left:15px;">
	<?php 
	echo $this->renderPartial('_ajaxContentcoment',array('comments'=>$childcomments,'longid'=>$eachcmnt->goal_id)) ; ?>
	</div>
	
	<?php } ?>
	<?php } ?>
	<!------------------------------ End of Blog Comments ---------------------->
	 <!------------------------------ Start Discussion Comments ---------------------->
	<?php if($blogtype->type == "discussion"){?>
	
	<div class="discussion-comment-tab" style="position:relative;">
    	<div class="discussion-comment-left" style="width:17%; text-align:center;">
			<p class="run-text"><img src="<?php echo ($eachcmnt->commentAuthor->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$eachcmnt->commentAuthor->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="60"/></p>
			<p class="blue-font12"><?php $name = $eachcmnt->commentAuthor->fname.' '.$eachcmnt->commentAuthor->lname; echo $name;?></p>
			</div>
       
	    <div class="discussion-comment-right" style="width:83%">
        <div class="blue-font11">
		<span class="right"><?php echo 
			date("M  j,  Y  \a\&#116 g:i a", strtotime($eachcmnt->commented_date));
			?></span>
		
		</div>
		
        <div style="min-height:55px; ">
			<p class="run-text"><?php echo $eachcmnt->comment_content;?></p>
			
		</div>
		<p class="run-text"><?php if(isset(Yii::app()->session['login'])){?>
			<a class="blue-link" onclick="showreply(<?php echo $eachcmnt->comment_id;?>)">Reply</a> <span id="orone-<?php echo $eachcmnt->comment_id;?>" style="display:none;" > | </span> 
			<a class="blue-link" id="cancelling-<?php echo $eachcmnt->comment_id;?>" onclick="hidereply(<?php echo $eachcmnt->comment_id;?>)" style="display:none;">Cancel</a>
			<?php } ?></p>
        </div>
		
		
    </div>

	 <div class="run-text  font-12px">
	 <input type="hidden" id="blogid" value="<?php echo $longid ;?>" />
										<input type="hidden" id="commnttype" value="blog_comment" />
										<input type="hidden" id="parentid" value="<?php echo $eachcmnt->comment_id;?>" />
		 <input type="hidden" id="userid" value="<?php echo Yii::app()->session['login']['id'];?>" />
		 <?php $useridfetch = User::model()->findAllByAttributes(array('userid'=>$var)); ?>
    	 <div id="reply-<?php echo $eachcmnt->comment_id;?>" style="display:none;">
		 <div class="blog-comment-tab">
		 <?php  foreach($useridfetch as $forimage){?>
		 <div class="comment-tab-left" style="width:6%"><img src="<?php echo ($forimage->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$forimage->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="25""/>
		 </div>
		 <?php } ?>
		<div class="comment-tab-right " style="width:94%"><input type="text" class="textbox-comment" id="<?php echo $eachcmnt->comment_id;?>" value="Write a comment and press enter..."  onclick="if((value=='Write a comment and press enter...')) value=''" onblur="if(!value) value='Write a comment and press enter...'" onkeypress="if(value !='Write a comment and press enter...')return submitblogcmntreply(this,event,this.id,1)"/></div>
						 	
	</div>	
	</div>	
	<input type="button" style="display:none;" id="newcmnt-<?php echo  $eachcmnt->comment_id;?>" />
	 <!--<div><a href="#" class="blue-link">Cancel</a></div>-->
	</div>
	<?php $childcomments = Comments::model()->findAllByAttributes(array('goal_id'=>$eachcmnt->goal_id,'goal_type'=>'blog_comment','status'=>1,'comment_parent_id'=>$eachcmnt->comment_id));
	if($childcomments){
		//echo "hiii";
		
	?>
	<div id="data-<?php echo $eachcmnt->comment_id?>" style="padding-left:15px;">
	<?php 
	echo $this->renderPartial('_ajaxContentcoment',array('comments'=>$childcomments,'longid'=>$eachcmnt->goal_id)) ; ?>
	</div>
	
	<?php } ?>
	<?php } ?>
	 <!------------------------- End Discussion Comments --------------------------->
	
	
	<?php /*
									echo CHtml::ajaxSubmitButton('submit',          
									array('/site/allComments/longid/'.$eachcmnt->comment_id),
									array(
											
											'type'=>'POST',
											'error'=>'js:function(){
											//alert("error");
											}',
											'beforeSend'=>'js:function(){
											//alert("beforeSend"); 
											           
											}',
											'complete'=>'js:function(){
											//alert("submitted successfully");
											}',
											'success'=>'js:function(data){
											//alert("success, data from server: "+data);    
											$("#data-'.$eachcmnt->comment_id.'").html(data);
											location.reload();
											}',
       
											'update'=>'#data-'.$eachcmnt->comment_id, 
											),array('id'=>'updatecomments-'.$eachcmnt->comment_id.'','style'=>'display:none'));
						*/					
							?>	
							<?php } ?>		  
<?php }?>

<script type="text/javascript">
function submitblogcmntreply(myfield,e,id,parentid)
{
 var keycode;
 if (window.event) keycode = window.event.keyCode;
 else if (e) keycode = e.which;
 else return true;
 if (keycode == 13)
 {
 // alert(id);
  $("#newcmnt-"+id).trigger('click');
  submitnewcmnt(id,parentid);
     return false;
	
 }
 else
     return true;
 
}
function showreply(id)
{
	//alert(id);
	//$("#reply-"+id).show();
	document.getElementById('reply-'+id).style.display = 'block';
	document.getElementById('cancelling-'+id).style.display = '';
	document.getElementById('orone-'+id).style.display = '';
	//var content = document.getElementById('replytext-'+id).value;
	//alert(content);
}
function hidereply(id)
{
	//alert(id);
	//$("#reply-"+id).show();
	document.getElementById('reply-'+id).style.display = 'none';
	document.getElementById('cancelling-'+id).style.display = 'none';
	document.getElementById('orone-'+id).style.display = 'none';
	//var content = document.getElementById('replytext-'+id).value;
	//alert(content);
}
/*function submitreply(id)
{

	var parentid = id;
	var cmnt = document.getElementById(id).value;
	 var goalid = document.getElementById('blogid').value;
	 var goaltype = document.getElementById('commnttype').value;
	//var parentid = document.getElementById('parentid').value;
 	 var userid = document.getElementById('userid').value;
	 jQuery(function($)
	 {
	  var url='<?php echo Yii::app()->createUrl("/educationalPlan/replyComment"); ?>';
	  $.post(url, { cmnt:cmnt, goaltype:goaltype, goalid:goalid, userid:userid, parentid:parentid},
	   function(data){
	   //alert(data);
	     if(data == "commented successfully")
	     {
		 //alert(id);
	      document.getElementById(id).value='Write a comment and press enter...';
	      $("#updatecomments-"+id).trigger('click');
	     }
	     });
	    
	 });
	
}*/
</script>