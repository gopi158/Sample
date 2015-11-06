<div class="my-tile-hdline"><?php echo $tileid->tile_name;?></div>

        <div class="clear-right"></div>

        <div class="tile-meter">

             <?php $this->widget('ProgressBar',array('userid'=>$userid,'finao'=>'finao','tileid'=>$tileid->tile_id)); //,array('userid'=>$userid,'left'=>'left')?>

        </div>

        <div class="clear-right"></div>

        <div class="finao-message">

			<div id="editonhover">

			<div id="finaomesg-<?php echo $finaoinfo->user_finao_id;?>">

				<?php echo ucfirst($finaoinfo->finao_msg);?>

			</div>

			<?php

				if($userid==Yii::app()->session['login']['id'] && $completed != "completed" && $finaoinfo->Isdefault != 1)

				{ if(isset($share) && $share!="share"){?>

			<a id="editlink<?php //-echo $eachfinao->user_finao_id;ondblclick?>" href="javascript:void(0)" class="orange-link font-16px" onclick="showeditfinaomesg(<?php echo $finaoinfo->user_finao_id;?>)" style="display:none;">Edit FINAO</a>

			<?php } } ?>

			</div>

			<p class="finao-def-msg" id="editfinaomesg-<?php echo $finaoinfo->user_finao_id;?>" style="display:none;min-height: 173px;padding-bottom: 10px;">

				<textarea id="newmesg-<?php echo $finaoinfo->user_finao_id;?>" class="finaos-area" style="width:97%; height:50px;" onkeydown="closefunction(this,event,'finao',<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)"><?php echo ucfirst($finaoinfo->finao_msg);?></textarea>

				<a  class="orange-link font-13px" id="savefinao-<?php echo $finaoinfo->user_finao_id;?>" href="javascript:void(0)"   onclick="savefinaomesg(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)" ><img style="width:20px;" src="<?php echo Yii::app()->baseUrl; ?>/images/icon-save.png"></a>

				<a class="orange-link font-13px" id="closefinao-<?php echo $finaoinfo->user_finao_id;?>" href="javascript:void(0)" onclick="closefinao(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)"><img style="width:20px;" src="<?php echo Yii::app()->baseUrl; ?>/images/icon-close.png"></a>

			</p>

		</div>

		<div class="track-finao">

				<?php
				if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed" && $finaoinfo->Isdefault != 1)
				{ 
				?>
                	<ul class="status-buttons">
                        <?php
						foreach($status as $finaostatus)
						{?>
							<a href="javascript:void(0)" onclick="updatefinao(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $finaostatus->lookup_id;?>,<?php echo $userid;?>,'allfinaos',<?php echo $tileid->tile_id;?>)">
								<li <?php if($finaostatus->lookup_name=="Behind")
								{
									if($finaostatus->lookup_id==$finaoinfo->finao_status)
									{?>
										class="finao-behind finao-behind-active" 
									<?php }else{?>
										 class="finao-behind"
								 <?php }
								 }elseif($finaostatus->lookup_name=="Ahead") 
								 {
								 	if($finaostatus->lookup_id==$finaoinfo->finao_status)
									{?>
									class="finao-ahead finao-ahead-active"
										<?php }else{?>
										 class="finao-ahead" 
								<?php }}elseif($finaostatus->lookup_name=="On Track" )
									{
										if($finaostatus->lookup_id==$finaoinfo->finao_status){?>
										class="finao-ontrack finao-ontrack-active" 
									 <?php }else{?> 
									 class="finao-ontrack" 
								<?php }}?>>
						</li></a>
		            	<?php }?>

						<?php if($finaoinfo->Iscompleted==1){?>

						<a href="javascript:void(0)" id="complete-<?php echo $finaoinfo->user_finao_id;?>" ><li class="finao-complete finao-ahead-complete"></li></a>

						<?php }else{?>

		                <a href="javascript:void(0)" id="complete-<?php echo $finaoinfo->user_finao_id;?>" onclick="updatefinaopublic(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $userid;?>,'complete',<?php echo $tileid->tile_id;?>)"><li class="finao-complete"></li></a>

						<?php }?>
						
                    </ul>

				<?php 	}else if($userid!=Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){

			?>

			<ul class="status-buttons">

				<?php if($finaoinfo->Iscompleted != 1) foreach($status as $finaostatus)

				    {

				     if($finaostatus->lookup_name=="Behind")

				     {

				      if($finaostatus->lookup_id==$finaoinfo->finao_status)

				      {

				       $class="finao-behind finao-behind-active"; 

				      }

				     }elseif($finaostatus->lookup_name=="Ahead") 

				      {

				       if($finaostatus->lookup_id==$finaoinfo->finao_status)

				      {

				        $class="finao-ahead finao-ahead-active" ;

				       }

				     }elseif($finaostatus->lookup_name=="On Track" )

				     {

				      if($finaostatus->lookup_id==$finaoinfo->finao_status)

				      {

				       $class="finao-ontrack finao-ontrack-active";

				      }

				     }?>

				   <?php }?>

				
			</ul>

			

			<?php

			}

			?>

  </div>
  <?php if($userid != Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){

		?>
		<div class="upload-finao-media">
		<ul class="status-buttons">
			
			<a class="count-positon" onclick="getDetails('Image',<?php echo $userid; ?>,<?php echo $finaoinfo->user_finao_id; ?>,'tilepage')" href="javascript:void(0)"><li class="finao-upload-image"></li> <span class="count-value" ><?php if(isset($count['fnimgcount'])) echo "(".$count['fnimgcount'].")";?></span></a>

            <a class="count-positon" onclick="getDetails('Video',<?php echo $userid; ?>,<?php echo $finaoinfo->user_finao_id; ?>,'tilepage')" href="javascript:void(0)"><li class="finao-upload-video"></li><span class="count-value" ><?php if(isset( $count['fnvidcount'])) echo "(".$count['fnvidcount'].")";?></span></a>

			<?php $page = isset($page) ? $page : 0; ?>

			<?php if($completed == "completed"){?>
				<!-- onclick='getalljournals(<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid;?>,"completed",<?php echo $page;?>)' -->
				<a class="count-positon" onclick="viewjournal(0,<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid; ?>,'completed',<?php echo $page;?>);" href="javascript:void(0)" title="View journal"><li class="finao-add-journal"></li><span class="count-value" style="left:21px!important;" ><?php if(isset($count['journalcount']) ) echo "(".$count['journalcount'].")";?></span></a>

				<?php }else{?>
				<!-- onclick='getalljournals(<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid;?>,0,<?php echo $page;?>)' -->
				<a class="count-positon" onclick="viewjournal(0,<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid; ?>,0,<?php echo $page;?>);" title="View journal" href="javascript:void(0)"><li class="finao-add-journal"></li><span class="count-value" style="left:21px!important;" ><?php if(isset($count['journalcount']) ) echo "(".$count['journalcount'].")";?></span></a>
				<?php if($heroupdate == ""){?>
<a class="count-positon" onclick="getprevfinao(<?php echo $page;?> , <?php echo $userid;?>, 0, <?php echo $tileid->tile_id;?> , 0)" href="javascript:void(0)"><img src="<?php echo Yii::app()->baseUrl;?>/images/back-btn.png" align="Back to FINAO"/></a>
				<?php }?>
				<?php }?>

			

           	<?php if($finaoinfo->Iscompleted==1){?>

			<a href="javascript:void(0)" id="complete-<?php echo $finaoinfo->user_finao_id;?>" >
			<img width="70" src="<?php echo Yii::app()->baseUrl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png">
			</a>

			<?php } else{?>
			 <?php //if(isset($eachfinao->finao_status)){

			?>
			
			<a href="javascript:void(0)">
			<img width="70" src="<?php echo Yii::app()->baseUrl;?>/images/dashboard/Dashboard<?php echo ucfirst($finaoinfo->finaoStatus->lookup_name);?>.png">
			</a>

			<?php

			}

			?>
			
        </ul>
		</div>
		<div class="clear"></div>
		<?php

		}

		?>	

    	<?php

			if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed" )

		{ ?>
		<div class="upload-finao-media" >
    	<!--<span class="left font-20px" style="margin-right:20px; margin-top:6px;">Add:</span>-->

        <ul class="status-buttons">

        	<?php if($hidebtn != 'image') { ?>

			<a class="count-positon" id="aphoto<?php echo $finaoinfo->user_finao_id; ?>" onclick="changeIcon(this.id,'Image'); addimages(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>,'finao','Image')" href="javascript:void(0)"><li class="finao-upload-image"></li><span class="count-value" ><?php if(isset($count['fnimgcount'])) echo "(".$count['fnimgcount'].")";?></span></a>

			<?php } ?>

			<?php if($hidebtn != 'video') {?>

            <a class="count-positon" id="avideo<?php echo $finaoinfo->user_finao_id; ?>" onclick="changeIcon(this.id,'Video'); addimages(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>,'finao','Video');" href="javascript:void(0)"><li class="finao-upload-video"></li><span class="count-value" ><?php if(isset( $count['fnvidcount'])) echo "(".$count['fnvidcount'].")";?></span></a>

			<?php } ?>

			<?php if($hidebtn != 'journal') { ?>

            <a class="count-positon" id="getjournal-<?php echo $finaoinfo->user_finao_id;?>" onclick="getalljournals(<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid;?>,0,0)" href="javascript:void(0)" ><li class="finao-add-journal"></li><span class="count-value" style="left:21px!important;" ><?php if(isset($count['journalcount']) ) echo "(".$count['journalcount'].")";?></span></a>

			<?php } ?>
			<a  class="count-positon" onclick="getprevfinao(0 , <?php echo $userid;?>, 0, <?php echo $tileid->tile_id;?> , 0)" href="javascript:void(0)"><img src="<?php echo Yii::app()->baseUrl;?>/images/back-btn.png" align="Back to FINAO" href="javascript:void(0)"/></a>
        </ul>
		</div>
		<?php }?>

                



