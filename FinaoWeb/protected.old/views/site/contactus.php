<!--
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />-->
<script type="text/javascript">
    $(document).ready(function() {
       
    $("#form-page").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
		$("#msg span").html("");
		$("#txtname").val("");
		$("#txtcomp").val("");
		$("#txtphone").val("");
		$("#txtemail").val("");
		$("#txtarea").val("");
	} });

	$("#btnsub").click(function(){
	
		mesg="";
	    flag=true;
	
		if($("#txtcomp").val().length < 1 && $("#txtname").val().length < 1)
		{
			mesg = "Please enter your name OR  school/organization name<br>";
			$("#txtcomp").removeClass("textbox-med");
			$("#txtcomp").addClass("textbox-med-error");
			$("#txtname").removeClass("textbox-med");
			$("#txtname").addClass("textbox-med-error");
			flag=false;
		}
		
		if($("#txtphone").val().length > 1)
		{
			
           phone_regex = /^[0-9-()]{10,14}$/;
			if(!phone_regex.test($("#txtphone").val()))
			{
			
			$("#txtphone").removeClass("textbox-med");
			$("#txtphone").addClass("textbox-med-error");
			}
		}
		if($("#txtemail").val().length < 1 && $("#txtphone").val().length < 1)
		{
			mesg += "Please enter phone or email<br>";
			$("#txtphone").removeClass("textbox-med");
			$("#txtphone").addClass("textbox-med-error");
			$("#txtemail").removeClass("textbox-med");
			$("#txtemail").addClass("textbox-med-error");
			flag=false;
		}
		if($("#txtemail").val().length > 0){   
		    $("#txtemail").val();
            email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			if(!email_regex.test($("#txtemail").val()))
			{
			mesg += "Please enter a valid email address<br>";
			$("#txtemail").removeClass("textbox-med");
			$("#txtemail").addClass("textbox-med-error");
			flag=false;
			}
		}
		if($("#txtarea").val().length < 1)
		{
			mesg += "Please enter how can we help";
			$("#txtarea").removeClass("textbox-med");
			$("#txtarea").addClass("textbox-med-error");
			flag=false;
		}
		if(flag == false)
		{
		  $("#msg span").html(mesg);
		  return false;
		 }
	});
	
});

</script>

           	<div class="middle-content">
            	<div class="contactus-wrapper">
                <!--	<div><img src="<?php //echo Yii::app()->baseUrl?>/images/contact.jpg" /></div>-->
                	<div class="contactus-headline">Contact Us</div>
                    
                    <div class="contact-middle-wrapper">
                    	<div class="contact-middle-left" style="border-right:1px dotted #343434;">
                        	<!--<div class="contact-heading-left">GENERAL</div>-->
                            
                           <!-- <p class="run-text"><strong>Fax:</strong> 877.212.4747</p>-->
                          <!--  <p class="run-text"><strong>Email:</strong>info@twelvecoaches.com</p>-->
						  
						  <!--<div style="display:none">-->
						  
						  
						  
						  
	<form id="login_form" method="post" action="">
	   <div id="login_form" >
				
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login_form',
	'enableAjaxValidation'=>true,
)); ?>
		<!--<h2>Information Request</h2>-->
		<!--<div class="contact-heading-left">REQUEST INFORMATION</div>-->
		<?php //echo $form->errorSummary($model); ?>
		<div id="msg">
		<span style="color:red"></span></div>
		<br><b>Please fill in all the mandatory details (*)</b>
            <table class="" cellpadding="5" >
            	
            	<tr>
                	<td width="50%">Name *</td>
                    <td width="50%"><?php echo $form->textField($model,'contact_name',array('size'=>50,'maxlength'=>50,'class'=>"textbox-med",'id'=>'txtname')); ?></td>
                </tr>
                
                <tr>
                	<td  valign="top">Organization *</td>
                    <td  valign="top"><?php echo $form->textField($model,'contact_company',array('size'=>50,'maxlength'=>50,'class'=>"textbox-med",'id'=>'txtcomp')); ?></td>
                </tr>
                <tr>
					<td >Phone </td>
                    <td ><?php echo $form->textField($model,'contact_phone',array('size'=>20,'maxlength'=>20,'class'=>"textbox-med",'id'=>'txtphone','onkeypress'=>'return numbersonly(event)')); ?></td>
				</tr>
                <tr>
                	<td >Email *</td>
                    <td ><?php echo $form->textField($model,'contact_email',array('size'=>50,'maxlength'=>50,'class'=>"textbox-med",'id'=>'txtemail')); ?></td>
                	 </tr>
				<tr>
                	<td  >How can we help? *</td>
                    <td  ><?php echo $form->textArea($model,'contact_help',array('cols'=>45,'rows'=>3,'maxlength'=>4000,'class'=>"contact-desc",'id'=>'txtarea')); ?></td>
                </tr>
                <tr>
                	<td></td>
					<td>
				
                <?php echo $form->error($model,'verifyCode',array('class'=>'txtbox','style'=>'color:red')); ?>
				<?php //$this->widget("CCaptcha",array('buttonLabel'=>'Refresh Captcha','buttonOptions'=>array('type'=>'image','style'=>'margin-bottom:20px;','src'=>'http://biziindia.com/images/refresh_captcha.gif'))); ?>
				<?php
                $this->widget('CCaptcha',	
                          array('showRefreshButton'=>true,
                                'buttonType'=>'button',
                                'buttonOptions'=>array('type'=>'image',
                                                       'src'=>Yii::app()->baseUrl.'/images/refresh-icon.png',),   
                                                                         'buttonLabel'=>'Refresh Captcha',),
                          false); 
            ?>
				</td>
								<?php //$this->widget("CCaptcha", array('buttonLabel'=>'Refresh captcha', 'buttonOptions'=>array('style'=>'margin-bottom:20px;'))); ?>
					
                </tr>
                <tr>
				    <td>Enter the text* </td>
                	<td><?php echo $form->textField($model,'verifyCode',array('size'=>50,'maxlength'=>50,'class'=>"textbox-captcha",'id'=>'txtemail',)); ?></td>
                </tr>
				<tr>
				<td colspan="2" align="center"></td>
				</tr>
                <tr>
                	<td colspan="2" style="text-align:center;">
					<!--<a href="#" class="request-info">-->
					
					<input class="blue-button" type="submit" value="Submit" id="btnsub">
					<?php //echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save',array('style'=>'background:none;color:#FFF;cursor:pointer','id'=>'btnsub')); ?>
					
					<!--</a>-->
					</td>
                </tr>
            
            </table>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
		</form>	
<!--</div>-->	
                        </div>
                        <div class="contact-middle-right" >
							<div><img src="<?php echo Yii::app()->baseUrl;?>/images/contactus.jpg" width="480" /></div>
						
							<br /><br />
							
							<!--<h2><u>Address:<br /></u></h2>
							<p class="run-text">PO Box 2411 - Issaquah, WA 98027</p>
                            <p class="run-text"><strong>Phone:</strong> 877.212.4747</p>
					        <br /><br />-->
								<div style="color:#3D97DE;font-size:18px">
									<strong><i><?php if(Yii::app()->user->hasFlash('contactus'))
									{
									$msg=Yii::app()->user->getFlash('contactus');
									echo $msg;
									} ?></i>
									</strong>
							</div> 
                        </div>
                    </div>
                    
                    
                </div>
            </div>