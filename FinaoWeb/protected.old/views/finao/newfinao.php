<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/form-style.css" type="text/css" media="screen" />

	

	<?php

		$form=$this->beginWidget('CActiveForm', array(

						'id'=>'user-finao-form',

						'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),

						)); ?>

 <div class="main-container">						

	<div class="finao-canvas">

		<div class="step-details">

            	<span class="my-finao-hdline orange">Your FINAO</span>

                <!--<span class="right step-area">Step 3</span>-->

            </div>

	      <input type="hidden" id="userid" value="<?php echo $userid;?>"/>

		<div id="mesg"></div>

		  <div class="clear-right"></div>

		  <div class="welcome-run-text">Everyone has a FINAO. Enter yours here.</div>

		<p class="padding-5pixels">

			<?php //echo $form->labelEx($model,'finao_msg'); ?>

			 <div class="welcome-run-text">

		    <?php echo $form->textArea($model,'finao_msg',array('class'=>'add-story','maxlength'=>140,'id'=>'finaomesg','style'=>'width:96%; resize:none; height:100px;','onfocus'=>'removeclass()')); ?>

			</div>

		</p>

		

	



	<div class="orange font-20px">Select Tile</div>

    	

          	<div class="tiles-div" id="finaotiles">

			<input type="hidden" id="tileid" />

			<input type="hidden" id="tilename" />

				<table id="tiledisplaypop" width="100%" cellpadding="3" cellspacing="10">

				<?php $j = 0;?>

				<?php foreach($tiles as $i => $eachtile ){

					if($j==0){

				?>

				<tr>

					<?php

						}

					?>

              		<td>

	                  	<a href="#">

	                  	<div class="holder smooth" id="divpop-<?php echo $eachtile->lookup_name;?>-<?php echo $eachtile->lookup_id;?>" onclick="clickdiv(this.id)">

					  	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php // strtolower($eachtile->lookup_name).".jpg";?>" width="80" />

	                    <div class="go-left text-position"><?php echo $eachtile->lookup_name;?></div>

					  	</div>

	             		</a>

              		</td>

				<?php

					$j=$j+1;

					if($j > 6){

					$j=0;	

				?>

				</tr>

			<?php

				}	

				} ?>

       		</table>

	   </div>

           <div style="clear:left;"></div>

	   		<p class="padding-15pixels" style="padding-top:15px;">

		<span>

		<?php echo $form->checkBox($model,'finao_status_Ispublic',array('id'=>'ispublic'));?>

		Make Finao Public?</span>

		<!--<span class="right" style="padding-top:10px;" >	-->

			

		<!--</span>	-->

		 </p>

           <p style="clear:left; padding:0px;"></p>

	<div class="center">

			<!--<input type="button" id="skip" class="btn-next-step" onclick="navigate();" value="Skip this step" />-->

		<?php if(isset($type) && $type=="firstfinao"){?>

		<!--<input type="button" class="orange-button" value="save and add another finao" id="addanotherfinao" onclick="submitfinao(<?php //echo $userid;?>,'addanotherfinao','firstfinao')"/>-->

			<input type="button" class="btn-next-step" value="Save" id="savefinaomedia" onclick="submitfinao(<?php echo $userid;?>,'','firstfinao')"/>

			<!--<input type="button" class="orange-button" value="save and add journal" id="savefinaojournal" onclick="submitfinao(<?php echo $userid;?>,this.id,'savefinaojournal','firstfinao')"/>

		<input type="button" value="Cancel" class="orange-button" id="firstfinao" onclick="newfinaocancel()"/> -->

		

		<?php }else{?>

		<!--<input type="button" class="orange-button" value="save and add another finao" id="addanotherfinao" onclick="submitfinao(<?php //echo $userid;?>,'addanotherfinao','tilefinao')"/>-->

			<input type="button" class="btn-next-step" value="Save" id="savefinaomedia" onclick="submitfinao(<?php echo $userid;?>,'','tilefinao')"/>

			<!--<input type="button" class="orange-button" value="save and add journal" id="savefinaojournal" onclick="submitfinao(<?php echo $userid;?>,this.id,'savefinaojournal','tilefinao')"/>

		<input type="button" class="orange-button" value="Cancel" id="cancelnewfinao" onclick="cancelfinao(<?php echo $userid;?>)"/>-->

		<?php }?>

		

	</div>

<?php $this->endWidget();

?>

</div>

	</div>	

<script type="text/javascript">

function clickdiv(id)

{
	
	var checkboxid = id.split("-");

	if($("#tileid").length)

		$("#tileid").val(checkboxid[2]);

		alert(id);

	if($("#tilename").length)

		$("#tilename").val(checkboxid[1]);

		
	
	$("#tiledisplaypop .holder-active").addClass("holder-active").removeClass("holder smooth");

	$("#"+id).addClass("holder-active");		

}

function removeclass()

{

	//alert("hii");

	document.getElementById('finaomesg').className = "finaos-area";

}

$('#tileid').change(function()

{

	var tileid = $('#tileid').children("option:selected").text();

	$("#tilename").val(tileid);

});

$('#tileid').change(function()

{

	var tileid = $('#tileid').children("option:selected").text();

	$("#tilename").val(tileid);

});

function submitfinao(userid,type)

{

	var finaomesg = document.getElementById('finaomesg').value;

	var tileid = document.getElementById('tileid').value;

	var tilename = document.getElementById('tilename').value;

	var ispublic = document.getElementById("ispublic").checked;

	var redirecttype="addanotherfinao";

	if(tileid > 0 && tilename == "" )

		tileid = "";

	//alert(ispublic);

	if(finaomesg.length > 1 && tileid.length >= 1)

	{

		//alert(tileid.length)

		var url='<?php echo Yii::app()->createUrl("/finao/addFinao"); ?>';

		$.post(url, { userid : userid , tileid : tileid , finaomesg : finaomesg , tilename : tilename , ispublic : ispublic},

	   		function(data){

	   			//alert("no data");

				if(data)

				{

					//getmessages();

					if(type == "firstfinao")

					{

						var url = "<?php echo Yii::app()->createUrl('/finao/motivationmesg');?>";

   						window.location = url;

					}

					if(redirecttype=="addanotherfinao")

					{

						var url = "<?php echo Yii::app()->createUrl('/profile/finalstep');?>";

   						window.location = url;

						

					}

					else if(redirecttype=="savefinaomedia")

					{

						//addimages(userid,data,'finao','Image');

						getfinaos(userid,tileid);

					}

						

					else if(redirecttype=="savefinaojournal")

						getnewjournal(userid,data);

				}

				

	    

	     });

	}

	else

	{

		//$("#mesg").html("Please enter mandatory fields");

		if(finaomesg.length < 1)

		{

			document.getElementById('finaomesg').className = "finaos-area-error";

			//alert("error");

		}

		if(tilename.length < 1)

		{

			document.getElementById('finaotiles').className = "tiles-div-error";

			//alert("error1");

		}

	}

}

function navigate()

{

	var url = "<?php echo Yii::app()->createUrl('/profile/finalstep');?>";

   	window.location = url;

}

</script>