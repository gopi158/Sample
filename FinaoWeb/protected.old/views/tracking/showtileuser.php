<?php
foreach($displaytiles as $relatetiles){?>
<div id = "<?php echo $relatetiles->lookup_id; ?>" onclick="finduser(this.id)">
<input type="hidden" value="<?php echo $relatetiles->lookup_id  ?>"/>
	<?php echo $relatetiles->lookup_name.'<br />'; ?>
</div>	
<? }
?>


<script type="text/javascript">
function finduser(id)
{
	var tiledata = id;
	var url='<?php echo Yii::app()->createUrl("/tracking/tiletracking"); ?>';
 	$.post(url,{tiledata : tiledata},
   		function(data){
   			//alert(data);
			$("#finaoform").hide();
				$("#finaodiv").hide();
				$("#journaldiv").html(data);
				$("#journaldiv").show();
     });
		
}

</script>