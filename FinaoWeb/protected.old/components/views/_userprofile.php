<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/javascript/organizationActivities.js"></script>
<script type="text/javascript" >
function changeImageClick()
{
	//$("#profileFileupload").show();
	$('#profileFile').trigger('click');
}

function editdata(disctr,editctr,Isedit)
{
	if(Isedit)
	{
		$("#"+disctr).hide();
		$("#"+editctr).show();	
	}
	else
	{
		$("#"+disctr).show();
		$("#"+editctr).hide();	
	}
	
	
}

function uploadDetails(trgaction,userid)
{
	var url= "<?php echo Yii::app()->createUrl('site/uploadDetail'); ?>";
	switch(trgaction)
	{
		case 'changeImage':
				var ext = $('#profileFile').val().split('.').pop().toLowerCase();
				if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
				    $("#profileFileupload").hide();
					alert('invalid extension!');
				}
				else
					$("#upload-form").submit();
				
				break;
		case 'changeName':
				var fname = $.trim($("#editfName").val());
				var lname = $.trim($("#editlName").val());
				if(fname != "" || lname != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,fname:fname,lname:lname},
					function(data) { 
							if(data == "success")
							{
								$("#displayName").html(fname + " " + lname);
								editdata('disName','editName',false);
							}
					});
				}else{
					alert("Empty values are not allowed");
				}
				break;
		case 'changeDescription':
				
				var description = $.trim($("#editdescription").val());
				if(description != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,description:description},
					function(data) { 
							if(data == "success")
							{
								$("#disdescription").html(description);
								//$("#editdescription").html(description);
								editdata('disdesc','editdesc',false);
								$('#aeditdesc').hide(); 
								$('#adisdesc').show(); 
							}
					});
				}else{
					alert("Empty value are not allowed");
				}
				break;
		case 'changeInterest':
		
				var selectInt = $("#dpselectInt").val()
				
				var countArray = new Array();
				countArray.push($("#dpselectInt").val());
				
				if(countArray != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,selectInt:selectInt},
					function(data) { 
					});
				}
				break;								
	}
	
}
$(document).ready(function() {  
	$('textarea[maxlength]').keyup(function(){  
		//get the limit from maxlength attribute  
		var limit = parseInt($(this).attr('maxlength'));  
		//get the current text inside the textarea  
		var text = $(this).val();  
		//count the number of characters in the text  
		var chars = text.length;  
		//check if there are more characters then allowed  
		if(chars > limit){  
			//and if there are use substr to get the text before the limit  
			var new_text = text.substr(0, limit);  
			//and change the current text with the new text  
			$(this).val(new_text);  
		}  
	});  
  
});  
</script>

<?php 
	$form = $this->beginWidget(
    	'CActiveForm',
				    array(
				        'id' => 'upload-form',
						'enableAjaxValidation' => false,
				        'htmlOptions' => array('enctype' => 'multipart/form-data'),
				    ));
					
?>

         
<?php echo CHtml::activeHiddenField($editprof, 'userid',array('value'=>isset($myprofile[0]) ? $myprofile[0]->userid : $myprofile->userid)); ?>
<?php
if($page == 'myprofile'){
?>	 
<div class="profile-widget">
        	<div class="profile-widget-left">
            	<p class="run-text"><img src="<?php echo ($myprofile[0]->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$myprofile[0]->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="113px" height="122px;"/></p>
				<?php if(isset($userid)){ if($userid == Yii::app()->session['login']['id']){?>
                <p class="center"><a href="#" class="orange-link" id="atagImage" onclick="js: changeImageClick(); return false;" >Upload Photo</a><div id="profileFileupload" style="display:none">
				<?php echo CHtml::activeFileField($editprof, 'image', array('id'=>'profileFile'
													,'size'=>'10'
													,"onchange"=>"js: uploadDetails('changeImage',". $myprofile[0]->userid .")"																
														)); ?>
					<?php	echo $form->error($editprof, 'image'); ?>
																
				<!-- <input type="file" id="profileFile" name="profileFile" size="10" onchange="js: uploadDetails('changeImage',<?php echo $myprofile[0]->userid ?>);"/>-->  </div> 
				</p>
				<?php } }?>
            </div>
            <div class="profile-widget-middle">
            	<div class="orange-font18"><div id="disName"><span id="displayName"><?php echo ($myprofile[0]->fname != "") ? $myprofile[0]->fname . " " .$myprofile[0]->lname : "Not Available"; ?></span>&nbsp;
				<?php if(isset($userid)){if($userid==Yii::app()->session['login']['id']){?>
				<a href="#" class="blue-link" id="adisName" onclick="js: editdata('disName','editName',true); return false;" >Edit</a>
				<?php } }?>
				</div>
				<div id="editName" style="display:none">
				<input type="text" id="editfName" name="editfName" class="textbox-med" value="<?php echo $myprofile[0]->fname;?>"/><input type="text" id="editlName" name="editlName" class="textbox-med" value="<?php echo $myprofile[0]->lname;?>"/>
				<a href="#" class="blue-link" id="aeditName" onclick="js: uploadDetails('changeName',<?php echo $myprofile[0]->userid; ?>); return false;" >Save</a>
				<a href="#" class="blue-link" id="aeditCName" onclick="js: editdata('disName','editName',false); return false;" >Cancel</a>
				</div>
				 </div>
                <!--<p>Email</p>-->
        		<p class="run-text"><?php echo $myprofile[0]->email; ?></p>
				<?php if($myaddress != ""){ ?>
				<?php foreach($myaddress as $address) {?>
					<p><?php echo $homework[$address->address_tag].":"	?></p>
					<p><?php echo $address->city . ", " . $address->state ." ". $address->zipcode ; ?></p>
				<?php } ?>
				<?php } ?>
            </div>
			<div class="profile-widget-right">
					<div class="orange-font18">Summary 
					<?php if(isset($userid)){if($userid==Yii::app()->session['login']['id']){?>
					<span id="adisdesc"><a href="#" class="blue-link" onclick="js: editdata('disdesc','editdesc',true); $('#aeditdesc').show(); $('#adisdesc').hide(); return false;">Edit</a></span>
			<span id="aeditdesc" style="display:none;"><a href="#" class="blue-link" onclick="js: uploadDetails('changeDescription',<?php echo $myprofile[0]->userid; ?>); return false;" >Save</a>
				<a href="#" class="blue-link" onclick="js: editdata('disdesc','editdesc',false); $('#aeditdesc').hide(); $('#adisdesc').show(); return false;" >Cancel</a></span>
				<?php } }?>
			</div>
			<div id="disdesc" >
            <p class="run-text"><span id="disdescription" >
						<?php 
							if($myprofile[0]->description != "")
								echo $myprofile[0]->description;
							else
								echo "Insert a summary of your interests, passions, and talents that will help your friends know how you might support their child’s learning."	;
					?></span></p>
			</div>
			<div id="editdesc" style="display:none">
				<textarea id="editdescription" name="editdescription" maxlength="250" >
					<?php 
						if($myprofile[0]->description != "")
							echo $myprofile[0]->description;
						else
							echo "Insert a summary of your interests, passions, and talents that will help your friends know how you might support their child’s learning."	;
					?>
				</textarea>
				
			</div>
			
			</div>
        </div>
	
<?php	

}elseif($page == 'manageactivity'){
?>
<div class="parent-widget">
                <div class="profile-widget-left">
		<?php if(isset($myaddress['name']) && $myaddress['name']!="") {
$orgnaizationnames=$myaddress['name'];
}else{
$orgnaizationnames="Organization Not Available";

}
if(isset($myaddress['address_line1']) && $myaddress['address_line1']!=""){
	$address1=$myaddress['address_line1'];
}else{
	$address1="Address One Not Available";
}
if(isset($myaddress['address_line2']) && $myaddress['address_line2']!=""){
	$address2=$myaddress['address_line2'];
}else{
	$address2="Address Two Not Available";
}
/* 
Added on 09012013
getting login id 
*/
if(isset(Yii::app()->session['login']))
{
	$logUserId = Yii::app()->session['login']['id'];
}else{
	$logUserId = '';
}
/*
Ended on 09012013
getting login id ends
*/
?>
                    <p class="run-text"><img src="<?php echo ($myprofile->profile_image != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$myprofile->profile_image : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="113px" height="122px;"/></p>
					<?php if($logUserId==$myprofile->userid){ ?>
					                <p class="center"><a href="#" class="orange-link" id="atagImage" onclick="js: changeImageClick(); return false;" >Upload Photo</a>
					<?php } ?>				
									<div id="profileFileupload" style="display:none">
				<?php echo CHtml::activeFileField($editprof, 'image', array('id'=>'profileFile'
													,'size'=>'10'
													,"onchange"=>"js: uploadDetails('changeImage',". $myprofile->userid .")"																
														)); ?>
					<?php	echo $form->error($editprof, 'image'); ?>
																
				<!-- <input type="file" id="profileFile" name="profileFile" size="10" onchange="js: uploadDetails('changeImage',<?php echo $myprofile->userid ?>);"/>-->  </div> 
				</p>
				
                </div>
                <div class="profile-widget-middle">
                    <div class="parent-headline"><span id="orgnizationNameSpn"><?php echo $orgnaizationnames;?></span>
                    	</div>
                    <p><span id="orgEmailSpan"><span id="orgnizationEmailSpn"><?php echo $myprofile->email;?></span></span>
                    </p>
					<p><span id="orgUserNameSpan"><span id="orgnizationFnameSpn"><?php echo ($myprofile->fname) ? $myprofile->fname . " " .$myprofile->lname : "Not Available"; ?>
                    </span></span>
                    <!-- 
						Added on 10012013 
						if login id exist then only show edit option
					-->
					<?php if($logUserId==$myprofile->userid){?>
						<span><a href="#" class="blue-link" onclick="editOrgUserName()" id="editButtonName">Edit</a></span>
					<?php } ?>
					<!--Ended on 10012013-->
					<div id="editOrgUserNameDiv" style="display:none">
                   	 <span><input type="text" id="editOrgUserFName" name="editOrgUserFName" class="strengths-new" value="<?php echo $myprofile->fname;?>" style="float:none;"/>
                    		<input type="text" id="editOrgUserLName" name="editOrgUserLName" class="strengths-new" value="<?php echo $myprofile->lname;?>" style="float:none;"/>
</span>
                    	<span><a href="#" class="blue-link" onclick="saveOrgUserName()" id="saveButtonName" >Save</a></span>
                    	<span><a href="#" class="blue-link" onclick="hideEditOrgUserName()" id="cancelButtonName" >Cancel</a></span>	
                    </div>
                    </p>
                     <p><span id="totalAddSpanAddrOne"><span id="orgnizationSpnAddrOne"><?php echo $address1;?></span></span>
                    	<span><input type="text" class="strengths-new" id="editTexBoxAddrOne" style="display:none;" value="<?php echo $address1;?>"/></span>
                    <!-- 
						Added on 10012013 
						if login id exist then only show edit option
					-->
					<?php if($logUserId==$myprofile->userid){?>
						<span><a href="#" class="blue-link" onclick="editAndUpdateOrgAddress('AddrOne')" id="editButtonAddrOne">Edit</a></span>
                    <?php }?>
					<!--Ended on 10012013-->
						<span><a href="#" class="blue-link" onclick="saveEditOrgAddress('AddrOne')" id="saveButtonAddrOne" style="display:none;">Save</a></span>
                    	<span><a href="#" class="blue-link" onclick="cancelOrgAddress('AddrOne')" id="cancelButtonAddrOne" style="display:none;">Cancel</a></span>
                    </p>
                    <p><span id="totalAddSpanAddrTwo"><span id="orgnizationSpnAddrTwo"><?php echo $address2;?></span></span>
                    	<span><input type="text" class="strengths-new" id="editTexBoxAddrTwo" style="display:none;" value="<?php echo $address2;?>"/></span>
						<!-- 
							Added on 10012013 
							if login id exist then only show edit option
						-->
					<?php if($logUserId==$myprofile->userid){?>
					       	<span><a href="#" class="blue-link" onclick="editAndUpdateOrgAddress('AddrTwo')" id="editButtonAddrTwo">Edit</a></span>
					<?php } ?>	
					<!--Ended on 10012013-->
                    	<span><a href="#" class="blue-link" onclick="saveEditOrgAddress('AddrTwo')" id="saveButtonAddrTwo" style="display:none;">Save</a></span>
                    	<span><a href="#" class="blue-link" onclick="cancelOrgAddress('AddrTwo')" id="cancelButtonAddrTwo" style="display:none;">Cancel</a></span>
                    </p>
                </div>
				<div class="profile-widget-right">
					<div class="orange-font18">Summary 
					<!-- 
						Added on 10012013 
						if login id exist then only show edit option
					-->
					<?php if($logUserId==$myprofile->userid){?>
					
					<span id="adisdesc"><a href="#" class="blue-link" onclick="js: editdata('disdesc','editdesc',true); $('#aeditdesc').show(); $('#adisdesc').hide(); return false;">Edit</a></span>
					<?php } ?>
					<!--Ended on 10012013-->
			<span id="aeditdesc" style="display:none;"><a href="#" class="blue-link" onclick="js: uploadDetails('changeDescription',<?php echo $myprofile->userid; ?>); return false;" >Save</a>
				<a href="#" class="blue-link" onclick="js: editdata('disdesc','editdesc',false); $('#aeditdesc').hide(); $('#adisdesc').show(); return false;" >Cancel</a></span>
				
			</div>
			<div id="disdesc" >
            <p class="run-text"><span id="disdescription" >
						<?php 
							if($myprofile->description != "")
								echo $myprofile->description;
							else
								echo "Insert a summary of your interests, passions, and talents that will help your friends know how you might support their child’s learning."	;
					?></span></p>
			</div>
			<div id="editdesc" style="display:none">
				<textarea id="editdescription" name="editdescription" maxlength="250" >
					<?php 
						if($myprofile->description != "")
							echo $myprofile->description;
						else
							echo "Insert a summary of your interests, passions, and talents that will help your friends know how you might support their child’s learning."	;
					?>
				</textarea>
				<input type="hidden" id="organizationGlobalUrl" value="<?php echo Yii::app()->baseUrl; ?>"/>
			</div>
			
			</div>
            </div>
<?php			
}
$this->endWidget(); 
?>		