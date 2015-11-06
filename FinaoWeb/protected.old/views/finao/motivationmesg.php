<div class="finao-welcome-content">
	<?php //$this->widget('finao',array('type'=>'tilefinao')); ?>
	<!--<div style="height:80px;"></div>-->
	<div class="slider-navigation">
	<?php if(isset($alltiles) && count($alltiles) >= 1 && isset($alltiles[0])) {
			if($noofpages>1){
			if($prev<=$noofpages)
			{?>
				<a onclick="getprevtiles(<?php echo $prev;?>,<?php echo $userid;?>,'prev')" class="slider-navigation-left" href="javascript:void(0)">&nbsp;</a>
			<?php 
			} ?>
			<?php if($next<=$noofpages){?>
			
				<a onclick="getprevtiles(<?php echo $next;?>,<?php echo $userid;?>,'next')" class="slider-navigation-right" href="javascript:void(0)">
					&nbsp;
				</a>
			
			<?php }?>
		<?php } } ?>	
	</div>
	
	<div class="journal-slider">
		<div class="add-tiles">
		<table id="tiledisplay" align="center" width="100%" cellpadding="3" cellspacing="10">
				<?php $j = 0;?>
				<?php 
				if(isset($alltiles) && count($alltiles) >= 1 && isset($alltiles[0]))
					foreach($alltiles as $eachtile ){
					if($j==0){
				?>
				<tr>
					<?php
						}
					?>
              		<td>
	                  	<a onclick="js: getfinaos(<?php echo $eachtile->userid;?>,<?php echo $eachtile->tile_id;?>); refreshwidget(<?php echo $eachtile->userid;?>);"  href="javascript:void(0);">
	                  	<div class="holder">
					  	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php echo $eachtile->tile_profileImagurl;?>" width="150" />
	                    <div class="go-left text-position"><?php echo $eachtile->tile_name;?></div>
					  	</div>
	             		</a>
              		</td>
				<?php
					$j=$j+1;
					if($j > 2){
					$j=0;	
				?>
				</tr>
			<?php
				}	
				} ?>
       		</table>
		</div>	
	</div>
</div>

<script type="text/javascript" >
$( document ).ready( function(){
var userid = document.getElementById('userid');
if(userid != null)
{
	//alert(userid.value);
	getprofile(userid.value);
	gettracking(userid.value);
	getallstatus(userid.value);
}
});
function getprevtiles(pageid , userid, type)
	{
		
		var url='<?php echo Yii::app()->createUrl("/finao/nextPrevtiles"); ?>';
		$.post(url, { pageid :  pageid , userid : userid , type : type },
	   		function(data){
	   			//alert(data);
				if(data)
				{
					//hidealldivs();
					$("#motivationmesg").show();
					$("#motivationmesg").html(data);
				}
				
	     });
	}
	
	

</script>