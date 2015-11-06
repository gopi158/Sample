<?php
echo $groupid;  



$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-finao-form',
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
		)); ?>
<fieldset>
	<?php echo $form->labelEx($newtile,'tile_name');?>
	<span id="erromsg" class="red"></span>
    <div>
	<?php echo $form->textField($newtile,'tile_name',array('class'=>'txtbox','style'=>'margin-bottom:5px;width:220px;','maxlength'=>15,'id'=>'usertilename','onblur'=>'if(this.value != "") validatetilename('.$userid.');','onclick'=>'$("#erromsg").html(""); if($("#usertilename").hasClass("txtbox-error")) $("#usertilename").addClass("txtbox").removeClass("txtbox-error");','onkeyup'=>'if(this.value == "") $("#newtileimage").hide();')); ?>
	<?php echo $form->hiddenField($newtile,'finao_id',array('value'=>$finaoid));?>
	<?php echo $form->hiddenField($newtile,'finaomessage',array('id'=>'hdnfinaomessage'));?>
    <?php echo $form->hiddenField($newtile,'groupid',array('value'=>$groupid));?>
    <input type="hidden" id="hdnduplicate" name="hdnduplicate" value="" />
    </div>
</fieldset>
 
 <fieldset>
<?php echo $form->labelEx($newtile,'Upload Tile Image',array('style'=>'color:#343434!important;')); ?>
  <div>
<?php $this->widget('CMultiFileUpload', array(
                'name' => 'tileimage',
				'accept' => 'jpeg|jpg', // useful for verifying files jpeg|jpg|gif|png
                'duplicate' => 'Duplicate file!', // useful, i think
                'denied' => 'Invalid file type', // useful, i think
    			'remove' => Yii::t('ui', '<div><img  title="Delete" style="float:right;padding-right:5px;padding-left:5px;" src="' . Yii::app()->request->baseUrl . '/images/delete.png" /></div>'),
                       )); ?>
 </div>					   

</fieldset>
<input type="hidden" value="" name="ispublic" id="ispublic_custom" />
 


<fieldset>

<label>&nbsp;</label>

<div>

<?php echo CHtml::submitButton('',array('id'=>'newtileimage','value'=>'Submit', 'class'=>'orange-button','style'=>'display:none;margin-right:3px','onclick'=>'if(validateform() == "false" ) return false;')); ?>

<?php echo CHtml::submitButton('',array('id'=>'newtileimages','value'=>'Submit', 'class'=>'orange-button','style'=>'display:none;margin-right:3px','onclick'=>'if(validateform() == "false" ) return false;')); ?><input type="button" onclick="cancelnewtile()" value="Cancel" class="orange-button"/>



</div>



</fieldset>





<?php $this->endWidget(); ?>



<script type="text/javascript">



function validateform()
{
	if(document.getElementById('ispublic').checked) $('#ispublic_custom').val('1');
	else $('#ispublic_custom').val('0');
	validatetilename(userid);
//	alert($('#ispublic').val());	flag = false;
	if($("#hdnduplicate").val() != "")
		flag = false;
	if($("#tileimage").val() == "")
	{
		flag = false;

	}

	var fileExtension = ['jpeg', 'jpg', 'png'];//

	if ($.inArray($("#tileimage").val().split('.').pop().toLowerCase(), fileExtension) == -1)

	{

	   alert("Only '.jpeg','.jpg', '.png' formats are allowed.");

	   flag = false;

	}	

	else

		flag = true;



	if($("#usertilename").val() == "" || $("#usertilename").hasClass("txtbox-error"))

	{

		if($("#usertilename").hasClass("txtbox"))

			$("#usertilename").addClass("txtbox-error").removeClass("txtbox");

		

		flag = false;

	}

	

	if($("#finaomesg").length)

		if($("#finaomesg").val() == "")

		{

			$("#finaomesg").addClass("txtbox-error").removeClass("txtbox");

			flag = false;

		}

		else

		{

			$("#hdnfinaomessage").val($("#finaomesg").val());	

		}

		

	//alert(flag);



	if(flag == false)



	{



		return 'false';



	}



	else



		return 'true';



}



function validatetilename(userid)

{

	var tilename = document.getElementById('usertilename').value;



	var url='<?php echo Yii::app()->createUrl("/finao/validateTile"); ?>';



	$.post(url, {userid : userid , tilename : tilename},



			function(data){



							//alert(data);



							if(data=="Tile Exists")

							{

								$("#usertilename").addClass("txtbox-error").removeClass("txtbox");

								document.getElementById('usertilename').focus();

								$("#erromsg").html("Tile name cannot be duplicate!!");

								$("#hdnduplicate").val("duplicate");

								$("#newtileimage").hide();

								return false;

							}

							else

							{//alert(data);

								//$("#newtileimage").show();

								if($("#newtileimages").css('display')=='none') $("#newtileimages").show();

								

								$("#usertilename").addClass("txtbox").removeClass("txtbox-error");

								$("#erromsg").html("");	$("#erromsg").hide();

								$("#hdnduplicate").val("");

								

							}

								



						 });

						 



}



$(document).ready(function(){

	$('#tileimage').bind('change', function() {



    //this.files[0].size gets the size of your file.

  	//alert(this.files[0].type);

	filetype = this.files[0].type; 

  	var ext = filetype.split('/').pop().toLowerCase();

	//'png',

	if($.inArray(ext, ['jpg','jpeg','png']) == -1) {

		  alert("Invalid extension! Only '.jpeg' and '.png' allowed");

		}

		else{

				/*var chosen = this.files[0];

				var image = new Image();

				imgwidth = "";

				imgheight = "";

				

				image.onload = function() {

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

        		};

				image.onerror = function() {

            		alert('Not a valid file type: '+ chosen.type);

        		};

        		image.src = url.createObjectURL(chosen);*/



		}	





	});



	





});







</script>