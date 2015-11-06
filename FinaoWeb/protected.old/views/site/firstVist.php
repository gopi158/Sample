<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Parent Valet - Mark</title>
<script src="http://use.edgefonts.net/istok-web.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/javascript/jquery.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36897271-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#txtsearchzipcode").keydown(keydownfun);
	$("#txtsearchzipcode").attr('maxlength','5');

});


	
</script>
<script type="text/javascript">
	function checkEmailIn(){
	var email=$("#accessEmailName").val();
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(email==''){
		$("#emptyAccEmail").show();
		$("#inccorectAccEmail").hide();
		$("#showErrMessage").hide();
			return false;
	}
	if(email.length>0){
	    if(emailExp.test(email)==false){ 
	    	$("#inccorectAccEmail").show();
	    	$("#emptyAccEmail").hide();
	    	$("#showErrMessage").hide();
			return false;
	    }
    }
 	
}
function splashLogin()
{
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
if($("#splashUserEmail").val()=='' && $("#splashUserPassword").val()==''){

$("#userEmailPassErr").show();
$("#userPassErr").hide();
$("#userPassErr").hide();
$("#inccorectEmail").hide();
$("#showErrMessage").hide();

return false;
}
if($("#splashUserEmail").val()==''){

$("#userNameErr").show();
$("#userPassErr").hide();
$("#userEmailPassErr").hide();
$("#inccorectEmail").hide();
$("#showErrMessage").hide();

return false;
}
if($("#splashUserPassword").val()==''){

$("#userPassErr").show();
$("#userNameErr").hide();
$("#userEmailPassErr").hide();
$("#inccorectEmail").hide();
$("#showErrMessage").hide();
return false;

}	
if($("#splashUserEmail").val().length>0){
	    if(emailExp.test($("#splashUserEmail").val())==false){ 
		    	$("#inccorectEmail").show();
		    	$("#showErrMessage").hide();
			$("#userEmailPassErr").hide();
		    	document.getElementById('userPassErr').style.display='none';
		    	document.getElementById('userNameErr').style.display='none';
				
				return false;
	    	}
    	}		
}
</script>
<style>
body{margin:0px; padding:0px; width:100%; height:100%;}
input,p{border:0px; margin:0; padding:0; outline:none;}
.container{height:800px; margin:0px auto; background:url(<?php echo Yii::app()->baseUrl; ?>/images/background.jpg) center center no-repeat;}
.inner-container{width:980px; margin:0px auto; position:relative; top:190px;}
.inner-container-left{width:330px; float:left; min-height:230px; height:auto; background-color:#3f3f3f; margin:0 35px; border-radius:8px; -moz-border-radius:8px; padding:20px 10px; text-align:center; margin-right:70px;}
.headline{color:#e9a751; font-size:20px; font-family: istok-web, serif; line-height:30px; padding-bottom:20px;}
input.textbox{padding:5px; width:200px; font-size:11px;}
input.blue-button{padding:8px 20px; text-align:center; margin:0px; display:inline-block; text-decoration:none; overflow:hidden; border-radius:4px; -moz-border-radius:4px; width:auto; color:#FFF; cursor:pointer; font-weight:bold;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0693cc), to(#1ca5de));
background: -webkit-linear-gradient(top, #0693cc, #1ca5de);
background: -moz-linear-gradient(top, #0693cc, #1ca5de); 
background: -ms-linear-gradient(top, #0693cc, #1ca5de);
background: -o-linear-gradient(top, #0693cc, #1ca5de);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0693cc', endColorstr='#1ca5de');}
input.blue-button:hover{
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0577a5), to(#1ca5de));
background: -webkit-linear-gradient(top, #0577a5, #1ca5de);
background: -moz-linear-gradient(top, #0577a5, #1ca5de); 
background: -ms-linear-gradient(top, #0577a5, #1ca5de);
background: -o-linear-gradient(top, #0577a5, #1ca5de);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0577a5', endColorstr='#1ca5de');
box-shadow: 0px 0px 5px #666;}
.inner-container-right{width:330px; float:right; min-height:230px; height:auto; background-color:#3f3f3f; margin:0 35px; border-radius:8px; -moz-border-radius:8px; padding:20px 10px; text-align:center;}
</style>
</head>

<body>
    <div class="container">
    	<div class="inner-container">
    		
        	<div class="inner-container-left">
        		<?php $accessLeftForm=$this->beginWidget('CActiveForm', array(
										'id'=>'innerAccessLeftForm','action'=>Yii::app()->baseUrl.'/index.php',
										'enableClientValidation'=>true,
										'enableAjaxValidation'=>false,
										'htmlOptions' => array('autocomplete'=>'off'),
										'clientOptions'=>array(
											'validateOnSubmit'=>true)
									)); ?>
            	<div class="headline">Invited Guests, enter your email for complete access to parent valet</div>
       	
<div>
            		 <p id="emptyAccEmail" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please Enter Your Email Address</p>	
            		<p id="inccorectAccEmail" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please enter valid email</p>
 <?php if(isset($notFindMessage)){?>   			
<span style="color:red;font-size:14px; padding-bottom: 10px;" id="showErrMessage"><?php echo $notFindMessage;?></span>
<?php } ?>
    		</div>
                <div style="padding-bottom:20px;">
                	
                	<?php echo $accessLeftForm->textField($model,'email',array('id'=>'accessEmailName','class'=>'textbox','placeholder'=>'Enter your Email Address')); ?>
                </div>
                <div>
                	<?php echo CHtml::submitButton($model->isNewRecord ? 'ACCESS NOW' : 'Save',array('class'=>'blue-button',
                                "onclick"=>"javascript:return checkEmailIn();")); ?>
                	</div>
					
            </div>
            <?php $this->endWidget(); ?>
            <div class="inner-container-right">
            	<?php $accessRightForm=$this->beginWidget('CActiveForm', array(
										'id'=>'innerAccessRightForm','action'=>Yii::app()->baseUrl.'/index.php/site/login',
										'enableClientValidation'=>true,
										'enableAjaxValidation'=>false,
										'htmlOptions' => array('autocomplete'=>'off'),
										'clientOptions'=>array(
											'validateOnSubmit'=>true)
									)); ?>
            	<div class="headline">Registered User/Returning Users Login with your credentials</div>
                <div style="padding-bottom:20px;">
	                <p id="inccorectEmail" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please enter valid email</p>
	                <p id="inccorectLogin" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Invalid Username/Password</p>		
	                <?php if(isset($notFindMessageSecond)){?>   			
<span style="color:red;font-size:14px; padding-bottom: 10px;" id="showErrMessage"><?php echo $notFindMessageSecond;?></span>
<script type="text/javascript"">
	$("#userNameErr").hide();
$("#userPassErr").hide();
$("#inccorectEmail").hide();
$("#userEmailPassErr").hide();
</script>
<?php } ?>
	                <p id="userNameErr" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please Enter Your Email Address</p>
<p id="userPassErr" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please Enter Your Password</p>
<p id="userEmailPassErr" style="display:none;color:red; font-size:14px; padding-bottom: 10px;" >Please Enter Your Email And Password</p>	
	                <?php echo $accessLeftForm->textField($model,'email',array('id'=>'splashUserEmail','class'=>'textbox','placeholder'=>'Enter Your Email Address')); ?>
	      			<br /><br /> 
	      			
	     			
	     			<?php echo $accessLeftForm->passwordField($model,'password',array('id'=>'splashUserPassword','class'=>'textbox','placeholder'=>'Enter Your Password')); ?>
	     			
     			</div>
                <div>
                	<?php echo CHtml::submitButton($model->isNewRecord ? 'LOGIN' : 'Save',array('class'=>'blue-button',
                                "onclick"=>"javascript:return splashLogin();")); ?>
                	
                </div>
                <?php $this->endWidget(); ?>
				<?php if(isset($this->newuser)){if($this->newuser=='fbinvite'){?>
					<span style="color:#FFF;display: none;" class="left  create-account">Sign in using your Facebook account <?php $this->widget('LoginWidget',array('fbinvite'=>'fbinvite'));?></span>
					<?php }}else{?>
					<span style="color:#FFF;" class="left  create-account">Facebook Users? Login using your </span>   <?php $this->widget('LoginWidget');?>
					<?php }?>
            </div>
        </div>
    </div>
</body>
</html>
