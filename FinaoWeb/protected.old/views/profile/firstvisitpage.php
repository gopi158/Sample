   
    <div class="main-container">
    	<div class="finao-canvas">
        	<div class="step-details">
            	<span class="my-finao-hdline orange"><?php echo ucfirst($findusername->fname); ?>, welcome to FINAO</span>
                <span class="right step-area">Step 1</span>
            </div>
             <div class="clear-right"></div>
            <div class="welcome-run-text">We've put some things together to help you get started, but feel free to skip and dive right in when you're ready.</div>
            <div class="welcome-run-text">First, find your Facebook friends already on FINAO. You can start following them on FINAO now, and invite any who aren't on FINAO to try it today.</div>
            <div class="center"><!--<input type="button" onclick="navigate('skip')" value="skip this step" class="btn-next-step">--> <input type="button" onclick="navigate('next')" class="btn-next-step" value="next" /></div>
        </div>
    </div>
	
<script type="text/javascript">
function navigate(type)
{
	if(type == "skip"){
		var url = "<?php echo Yii::app()->createUrl('/profile/finalstep');?>";
   		window.location = url;
	}else if(type == "next")
	{
		var url = "<?php echo Yii::app()->createUrl('/profile/profilelanding');?>";
   		window.location = url;
	}
	
}
</script>	