<script>

	jQuery(document).ready(function ($) {

	"use strict";

	if($('#Default4').length)
		$('#Default4').perfectScrollbar();

	});

</script>

<div class="finao-canvas">

        	<div id="closefinaodiv" >
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
			 
			<a class="btn-close" <?php if($url != ""){?> href="<?php echo $url; ?>" <?php }else{?> onclick="closeheroupdate()" <?php }?>><img src="<?php echo Yii::app()->baseurl; ?>/images/close.png" width="40" /></a>

			</div>
			
        	<div class="finao-canvas-left">

            	<div class="journal-log">
					<div class="font-16px padding-5pixels orange left">
						Journal Log
					</div>
					<div class="right" style="margin-top:5px;">
					<a href="#" class="journal-link journal-link-active">
					<?php if($userid==Yii::app()->session['login']['id'] && $share!="share"){?>
						<span>Enter New Journal</span> 
					<?php }else{?>
						<span>Summary View</span> 
					<?php }?>
					</a>
					|
					<?php if(count($journals) >= 1) {?>
						<span><a class="journal-link" onclick="viewjournal(0,<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1);" href="javascript:void(0);" >Journal View</a></span> 
					<?php }else { ?> 
						<span>Journal View</span> 
					<?php } ?>
					</div>
				</div>
                <div class="clear-left"></div>
                

				<?php if($userid==Yii::app()->session['login']['id'] && $completed != "completed"){  
						if(isset($share) && $share!="share"){?>

				<div class="upload-image">

					<div id="hidejournal" style="display:block;">

					<input type="hidden" id="finao_id" value="<?php echo $finaoinfo->user_finao_id;?>"/>
					<p>

					<textarea  class="run-textarea left" id="journaltext" style="width:80%; resize:none; ">Enter your Journal</textarea>
					<input type="button" value="Save" class="orange-button" id="savejournal" href="javascript:void(0)"   onclick="if(validateSubmitJournal('journaltext') == 'false') return false; savejournalmesg(<?php echo $userid;?>,'')" /> 
					</p>

					</div>
                    <div class="clear-left"></div>
					
                </div>

				<?php } }?>							

				<?php //if($userid==Yii::app()->session['login']['id'] && $share!="share"){?>

					<?php //if(count($journals) != 0){ ?>

					<!--<div class="font-16px bolder padding-10pixels">Journal Log</div>-->

					<?php //} ?>

					<?php //}else{?>

					<!--<div class="font-16px bolder padding-10pixels"><span style="color:#FF791F;"><?php echo ucfirst($userinfo->fname)."'s";?></span> Journal Log</div>-->
					 
					<?php //}?>
					
                    <div id="Default4" class="contentHolder1">
                        <table width="98%" cellpadding="5" cellspacing="0">
						<?php
							foreach($journals as $eachjournal)
							{?>
								
						<tr>
								<td class="log-detail">
								<a class="journal-link" onclick="viewjournal(<?php echo $eachjournal->finao_journal_id;?>,<?php echo $eachjournal->finao_id; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1);" href="javascript:void(0)">
								<div id="journalmesg-<?php echo $eachjournal->finao_journal_id;?>" >

									<span class="font-14pixels">

									<?php echo date("m/j/Y  \a\&#116 g:i A", strtotime($eachjournal->createddate));?>

									</span> - <?php echo ucfirst($eachjournal->finao_journal);?>

								</div>

								 

								<div id = "journaldate-<?php echo $eachjournal->finao_journal_id;?>" style="display:none">

								<span class="font-14pixels"><?php echo date("m/j/Y  \a\&#116 g:i A", strtotime($eachjournal->createddate));?> </span>

								</div>
								</a>
								

								</td>

								</tr>

							<?php }	?>

						</table>

                    </div>

					<div id="journalimages" style="display:none;" class="finao-image-area">

					</div>


                </div>

            <div class="finao-canvas-right">

				

				<?php if(!($userid == Yii::app()->session['login']['id'])) { ?>

						<input type="hidden" id="frndtileid" value=""/>

						<input type="hidden" value="" id="userfrndid"/>

						<div id="trackingstatus" style="float:right;">

						</div>

						<div class="clear-right"></div>

					<?php } ?>

			

			

            	<?php $this->renderPartial('_newsinglefinao',array('finaoinfo'=>$finaoinfo

																	,'status'=>$status,'userid'=>$userid

																	,'getimages'=>$getimages,'share'=>$share

																	,'tileid'=>$tileid,'completed'=>$completed

																	,'page'=>$page

																	,'hidebtn'=>'journal'
																	,'heroupdate'=>$heroupdate
																	,'count'=>$count
																	)); ?>

            </div>

        </div>



<script type="text/javascript">

$("#journaltext").on("keypress", function(e) {

    if (e.which === 32 && !this.value.length)

        e.preventDefault();

});

$("#journaltext").on("keyup", function(e) {
	if(e.which == 13)
	{
		if(this.value != "Enter your Journal" && this.value != "")
			return false; 
		savejournalmesg(<?php echo $userid;?>,'');
	}
});

$(".finaos-area").on("keypress", function(e) {

    if (e.which === 32 && !this.value.length)

        e.preventDefault();

});

$("#journaltext").focus(function(){

 if(this.value == "Enter your Journal")
 {
	this.value = "";
	if($("#journaltext").hasClass("run-textarea-error"))
		$("#journaltext").addClass("run-textarea").removeClass("run-textarea-error");
 }

});



$("#journaltext").blur(function(){

 if(this.value == "")

 {

  this.value = "Enter your Journal";

 }

});



</script>