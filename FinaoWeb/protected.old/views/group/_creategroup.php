<?php  
					if($groupeditinfo->profile_image!=""){
					$filename = Yii::app()->basePath."/../images/uploads/groups/profile/".$groupeditinfo->profile_image;
					if(file_exists($filename))
					{
						list($sourceWidth,$sourceHeight) = getimagesize($filename);
						if($sourceWidth <= 140 && $sourceHeight <= 140)
							$src=$this->cdnurl."/images/uploads/groups/profile/".$groupeditinfo->profile_image;
						else
						{
							$src=$this->cdnurl."/images/uploads/groups/profile/".$groupeditinfo->profile_image;
							 
						}	
					}
					else
						$src=$this->cdnurl."/images/no-image.jpg";			
			        } else	{
			         	$src=$this->cdnurl."/images/no-image.jpg";
			   }?>
 

<div class="tiles-container">
                <div class="create-group-wrapper">
                    <div class="group-wrapper-left">
                        <div class="padding-15pixels">
                        <!--<img src="images/no-image.jpg" width="180" />-->
                        <img src="<?php echo $src;?>" id="profileImg" width="180" />
                        </div>
                        <div class="padding-5pixels center">
      <!--<input type="button" class="orange-button" value="Add/Edit Picture" />-->
      
<form name="ProfileimageForm" <?php if(isset($_POST['action']) && $_POST['action']=="edit"){?> action="<?php echo Yii::app()->createUrl('group/changePic/edit/1'); ?>" <?php }else{?> action="<?php echo Yii::app()->createUrl('group/changePic'); ?>" <?php }?> method="post" enctype="multipart/form-data">
<div style="position:absolute; top:-100px; visibility:hidden"><input style="cursor:pointer;" type="file" class="file" name="file" id="file" /></div>
<a title="Minimum size 140 x 140 pixels" href="javascript:void(0);" onclick="$('#file').trigger('click');" class="font-12px  orange-button"> Change Profile Picture</a>
<input type="submit" id="btnProfileimageForm" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none"  />
<input type="hidden" name="groupid" value="<?php echo $groupeditinfo->group_id; ?>" />
</form>
                        </div>
                    </div>
                    
                    <div class="group-wrapper-right">
                        <div class="padding-15pixels"><input id="groupname" name="groupname" type="text" style="width:97%;" value="<?php if($groupeditinfo->group_name){echo $groupeditinfo->group_name;}else{echo 'Group Name';}?>" class="txtbox" onblur="if(this.value=='')this.value='Group Name';" onfocus="if(this.value=='Group Name')this.value='';"></div>
                        <!--<div class="padding-15pixels"><input type="text" class="txtbox" value="+ Add people to this group" style="width:97%;" /></div>-->
                        <div class="padding-15pixels">
           <textarea id="groupstory"  style="resize:none; width:96%; height:100px;" class="add-story " <?php if(isset($_POST['action']) != 'edit'){?> onblur="if(this.value=='')this.value=this.defaultValue;"
onfocus="if(this.value==this.defaultValue)this.value='';"<?php } ?> ><?php if($groupeditinfo->group_description){echo $groupeditinfo->group_description;}else{echo 'Group Story';}?></textarea></div>
                        <div class="padding-15pixels">
                        	<table width="80%" cellpadding="3" cellspacing="0">
                            	<tbody>
                                
                                <tr>
                                	<td class="bolder" width="60%">Type of Group <a title="" class="addspeech" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-help.png"></a></td>
   <td class="bolder" width="20%"> <input type="radio" <?php if($_POST['action'] = 'edit'){ if($groupeditinfo->group_status_ispublic == 0)?> checked="checked" <?php  } ?> name="grouptype" value="0" id="grouptype_0" />
      Monitored </td>
  
  
   
    
      
  <td class="bolder" width="20%"><input type="radio" <?php  if($_POST['action'] = 'edit'){ if($groupeditinfo->group_status_ispublic == 1)?> checked="checked" <?php  } ?> name="grouptype" value="1" id="grouptype_1" />
      Public </td>
                                </tr>
                                <tr>
                                	<td class="bolder">"Home" link on Group Member <a title="" class="addspeech" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-help.png"></a></td>
                                    <td class="bolder"><input type="radio" <?php if($groupeditinfo->group_activestatus == 1 && $_POST['action'] = 'edit'){?> checked="checked" <?php  } ?> name="GroupMember" value="1" id="GroupMember_0" />
      On </td>
                                    <td class="bolder"> <input type="radio" <?php if($groupeditinfo->group_activestatus == 0 && $_POST['action'] = 'edit'){?> checked="checked" <?php  } ?> name="GroupMember" value="0" id="GroupMember_1" />
     Off </td>
                                </tr>
                                <tr>
                                	<td class="bolder">Allow Group Members to upload Image/Video <a title="" class="addspeech" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-help.png"></a></td>
                                    <td class="bolder"> <input type="radio" <?php  if($_POST['action'] = 'edit'){ if($groupeditinfo->upload_status == 1)?> checked="checked" <?php  } ?> name="allowupload" value="1" id="allowupload_0" />
      Yes </td>
                                    <td class="bolder"> <input type="radio" <?php if($_POST['action'] = 'edit'){ if($groupeditinfo->upload_status == 0)?> checked="checked" <?php  } ?> name="allowupload" value="0" id="allowupload_1" />
     No </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="padding-15pixels center">
                        <input type="button" value="<?php if(!empty($_POST['action'])){?>Save <?php }else{?>Create<?php } ?>" class="orange-button" onClick="creategroup(<?php echo Yii::app()->session['login']['id']?>,0,'Add');"> <input onclick="closefrommenu('main');" type="button" value="Cancel" class="orange-button"></div>                   <input type="hidden" id="hdngrpid" name="groupid" value="<?php echo $groupeditinfo->group_id?>" />
                    </div>
                </div>
            </div>
            
 
<script type="text/javascript" >

var url = window.URL || window.webkitURL;
$(document).ready(function(){
	$('#file').bind('change', function() {

  //this.files[0].size gets the size of your file.
  	
	filetype = this.files[0].type; 
	
  	var ext = filetype.split('/').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		  alert('Invalid extension!');
		}
		else{
				
				//alert(this.files)
				var chosen = this.files[0];
				var image = new Image();
				imgwidth = "";
				imgheight = "";
				
				/*image.onload = function() { //alert(this.files[0].type);
            		imgwidth = this.width;
					imgheight = this.height;
					
					if(!(imgwidth >= 140 && imgheight >= 140))
					{
						alert('Please upload the images of width and height greater than 140px!');
						return false;
					}
					else
					{
						$("#ProfileimageForm").submit();
					}	
					//alert('Width:'+this.width +' Height:'+ this.height+' '+ Math.round(chosen.size/1024)+'KB');
        		};*/
				/*$(image).one('load', function() {
  						
					imgwidth = this.width;
					imgheight = this.height;
					
					if(!(imgwidth >= 140 && imgheight >= 140))
					{
						alert('Please upload the images of width and height greater than 140px!');
						return false;
					}
					else
					{
						alert('hi');
						//$("#ProfileimageForm").submit();
						//ProfileimageForm.submit();
						$("#btnProfileimageForm").show();
					}	
				});
				image.onerror = function() {
            		alert('Not a valid file type: '+ chosen.type);
        		};
        		image.src = url.createObjectURL(chosen);*/
				
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					$("#btnProfileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your profile image!!!")
					//$("#uploadimag").trigger('click');
				}
				else
					document.ProfileimageForm.submit();
		}	


	});

	/*if(navigator.appName == 'Microsoft Internet Explorer')
	{
		$("#btnProfileimageForm").show();
	}*/


});

function checkwidth()
{
	if(imgwidtharea)
	alert('WIdth is '+ imgwidtharea);
}

/*$(document).ready(function(){
	$("#loadingimg").hide();
	
	$("#file").change(function(){
		
		$("#ProfileimageForm").ajaxForm(function(data){
		
		$("#profile-image").html(data);
  
		}).submit();
	});
	$("#bgfile").change(function(){
		$("#loadingimg").show();
		
		$("#BgimageForm").ajaxForm(function(data){
			setTimeout(function(){ $("#loadingimg").hide(); }, 100);
			$("#bgimagediv").css({'background-image':'url('+data+')'});
  		}).submit();
		
	});
});*/
function changepic(id)
{
	var ext = $('#'+id).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		  alert('Invalid extension!');
		}
		else{
			if(id=="file")
			{
				$("#ProfileimageForm").submit();
			}
			else if	(id=="bgfile")
			{
				$("#BgimageForm").submit();
			}
			}
}




</script>



<script type="text/javascript" >

function chkalphanum(){

  var location = $('#UserProfile_user_location').val();

  letters =/^[a-zA-Z0-9]+$/; 

  if(!letters.test(location)){   

     $('#location-msg').show();

  }else{

     $('#location-msg').hide();

  }

}

</script>

<?php if(isset($Imgupload) && $Imgupload != 0) { ?>

<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/css/imgareaselect-default.css" />

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.imgareaselect.pack.js"></script>

<?php } ?>

<script type="text/javascript">
// Get Image Crop size.
function getSizes(im,obj)
	{
		
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		
		var urlvalue = "<?php echo Yii::app()->createUrl('Profile/cropImage');?>";
		var imgurl = '<?php echo "Yii::app()-baseurl"."/images/uploads/profileimages/"; ?>';
		
		if(thumb_width != thumb_height)
		{
			alert("Width and Height of the selected portion must be equal");
			return false;
		}
		
		if(thumb_width > 0)
			{
				if(confirm("Press OK to SAVE image or CANCEL to CONTINUE EDITING!"))
					{
						fileext = ($("#image_name").val()).substr(($("#image_name").val()).lastIndexOf('.')+1);
						$.ajax({
							type:"GET",
							//url:"ajax_image.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
							url: urlvalue+"?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext,
							cache:false,
							success:function(rsponse)
								{
									<?php if(isset($edit) && $edit=="edit"){?>
									location.href = "<?php echo Yii::app()->createUrl('profile/profilelanding/edit/1'); ?>";
									<?php }else{?>
								 	location.href = "<?php echo Yii::app()->createUrl('profile/profilelanding'); ?>";
									<?php }?>
									/*$("#divimag").hide();
									$("#divform").show();
								    $("#profileImg").attr("src",imgurl+$("#image_name").val());*/
								}
						});
					}
			}
		else
			alert("Please select portion..!");
	}
	
function getsizeSave()
{
	
}

var IsimgUpload = "<?php echo $Imgupload; ?>";

$(document).ready(function () {
    
	if($('img#imageid').length)
	{
		$('img#imageid').imgAreaSelect({
        x1: 10, y1: 10, x2: 150, y2: 150,
		/*maxWidth: 420, 
		maxHeight: 420, */
		aspectRatio: '1:1',
        onSelectEnd: getSizes
    	});	
	}
	
	if(IsimgUpload != 0)
	{
		$("#divform").hide();
	}

});

$(document).ready(function() {
    $("#zpcode").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
		
});


</script>           