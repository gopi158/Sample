<script type="text/javascript">

/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){//alert('f');
	//global vars
$('#customForm').bind("keyup keypress", function(e) {
  var code = e.keyCode || e.which; 
  if (code  == 13) {               
    e.preventDefault();
    return false; 
  }
});

	
	var form = $("#customForm");
	var name = $("#gname");
	var nameInfo = $("#nameInfo");
	 
	var message = $("#gdesc");
	 
	//On blur
	name.blur(validateName);
	 
	//On key press
	name.keyup(validateName);
	message.keyup(validateMessage);

	//On Submitting
	form.submit(function(){ //alert('f');return false;
		if(validateName() && validateMessage())
			return true 
		else
			return false;
	});
	
	//validation functions
	 
	function validateName(){
		//if it's NOT valid
		if(name.val()== ''){
			name.addClass("txtbox-error");name.focus();
			/*nameInfo.text("Please Enter Group Name");
			nameInfo.addClass("txtbox-error");*/
			return false;
		}
		else if(name.val().length < 4){
			name.addClass("txtbox-error");name.focus();
			/*nameInfo.text("We want names with more than 3 letters!");
			nameInfo.addClass("txtbox-error");*/
			return false;
		}
		//if it's valid
		else{
			name.removeClass("txtbox-error");
			/*nameInfo.text("What's your name?");
			nameInfo.removeClass("txtbox-error");*/
			return true;
		}
	}
	 
	function validateMessage(){
		//it's NOT valid
		
		if(message.val() == ''){
			message.attr("class","update-finao-textarea-error");message.focus();
			return false;
		}
		if(message.val().length < 10){
			message.addClass("update-finao-textarea-error");
			message.attr("class","update-finao-textarea-error");
			return false;
		}
		//it's valid
		else{			
			message.removeClass("update-finao-textarea-error");
			message.addClass("add-story");
			return true;
		}
	}
});
</script>
 
 <?php if(!empty($groupinfo->profile_image)){ 
   $src = $this->cdnurl."/images/uploads/groupimages/profile/".$groupinfo->profile_image; 
	 }
	 else
	 {
	$src = $this->cdnurl."/images/no-image.jpg";  
	 } 
?>
<div class="tiles-container" style="background:rgba(255,255,255,1)">
                <div class="create-group-wrapper" style="margin-left: 150px; width:70%;">
                    
                   <form id="customForm" method="post" action="<?php echo Yii::app()->createUrl('group/createGroup'); ?>" enctype="multipart/form-data"> 
				    <input type="hidden" style="visibility:hidden" name="group_id" value="<?php echo $groupinfo->group_id;?>" >
                    <!--<div class="group-wrapper-left">
                        <div class="padding-15pixels">
                        
                        <img id="init" width="180" src="<?php echo $src; ?>">
                        <img id="test" width="180" height="180" style="display:none;" >
                        </div>
                        <div class="padding-5pixels center">
                       
                      
                        <input id="file_group" type="file" style="cursor:pointer; visibility:hidden" name="gimage" onchange="readURL(this);" >
                       <a class="orange-button" href="javascript:void(0);" title="Minimum size 240 x 240 pixels" onclick="js:$('#file_group').trigger('click');">Add/Edit Picture
            </a>
                        
                        
                        
                        </div>
                    </div>-->
                    <div class=""><!--group-wrapper-right-->
                    	<div class="padding-15pixels orange font-20px">
                        	Create Group
                        </div>
                        <div class="padding-15pixels">
                        <input id="gname" value="<?php echo $groupinfo->group_name;?>" name="gname" type="text" style="width:97%;" placeholder="Group Name" maxlength="25" class="txtbox">
                        <div id="nameInfo"></div>
                        </div>
                       
                        <div class="padding-15pixels">
                  <textarea id="gdesc" name="gdesc" style="resize:none; width:97%; height:100px;" placeholder="Group Story" class="add-story"><?php echo $groupinfo->group_description;?></textarea>
                        </div>
                        <div class="padding-15pixels">
                        	<table width="100%" cellspacing="0" cellpadding="3">
                            	<tbody><tr>
                                	<td width="50%" class="bolder">Type of Group <a title="" class="addspeech" href="#"><img src="<?php echo $this->cdnurl; ?>/images/icon-help.png"></a></td>
                                    <td width="20%" class="bolder"><input type="radio" name="gtype" <?php if($groupinfo->group_status_ispublic=='0') echo 'checked'; if($groupinfo->group_status_ispublic=='') echo 'checked';?> value="0" id="gtype_0" onchange="showmedia(this.value)" />
      Private</td>
                                    <td width="20%" class="bolder"><input type="radio" name="gtype" <?php if($groupinfo->group_status_ispublic=='1') echo 'checked';?> value="1" id="gtype_1" onchange="showmedia(this.value)" />
      Public</td>
                                </tr>
                              <!--  <tr>
                                	<td class="bolder">"Home" link on Group Member <a title="" class="addspeech" href="#"><img src="<?php //echo $this->cdnurl; ?>/images/icon-help.png"></a></td>
                                    <td class="bolder"> <input type="radio" name="homelink" value="1" id="homelink_0" />
      On</td>
                                    <td class="bolder"><input type="radio" checked name="homelink" value="0" id="homelink_1" />
      Off</td>
                                </tr>-->
                                
                                <tr id="medialink" style="display:none;">
                                	<td class="bolder">Allow Group Members to upload Image/Video <a title="" class="addspeech" href="#"><img src="<?php echo $this->cdnurl; ?>/images/icon-help.png"></a></td>
                                    <td class="bolder"><input type="radio" name="media" value="1" id="media_0" />On</td>
                                    <td class="bolder"> <input type="radio" checked name="media" value="0" id="media_1" />
      Off</td>
                                </tr>
                            </tbody></table>
                        </div>
                        <div class="padding-15pixels center">
            <input type="submit" value="<?php if($groupinfo->group_id) echo 'Update'; else echo 'Create';?>" class="orange-button"> 
            <input onClick="closefrommenu('main')" type="button" value="Cancel" class="orange-button">
                        </div>
                    </div>
                   <input type="hidden" name="userid" value="<?=$userid;?>">
                   
                   </form> 
                    
                    
                </div>
            </div>
            
<script type="text/javascript">
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$('#init').hide();
$('#test').show();	
$('#test').attr('src', e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}
function showmedia(value)
{
	if(value == 1)
	{
		$('#medialink').show();
	}else
	{
		$('#medialink').hide();
	}
}
</script>            