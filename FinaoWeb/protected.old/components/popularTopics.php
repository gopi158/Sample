<br/><br/><?php class popularTopics extends CWidget
{
 
 public $BlogTags;
 public $comments;
 public function run()
 {
		 echo '<div class="popular-topics">
						<div id="topics" class="gradient-bg"><span style="float:left; padding-top:5px; padding-left:10px;">Tags</span></div>
						 <div class="popular-topics-content">
						 
						 
						  <ul>';
						  $criteria = new CDbCriteria();
						  $criteria->limit = 10;
						  $criteria->order = 'createdate DESC';
						  $BlogTags = BlogTags::model()->findAll($criteria);
						
						  foreach($BlogTags as $tags)
						  {
						  	$tagcount = BlogsTags::model()->findAll(array('condition'=>'tag_id = '.$tags->tag_id));
							echo '<div id="populartags">';
							echo '<input type="hidden" id="tagid-'.$tags->tag_id.'" value="'. $tags->tag_id .'" />';
						 	echo '<div class="orange-link"><a class="blue-link font-12px"  onclick="showblog('.$tags->tag_id.')">'. ucfirst($tags->tag_name) .'&nbsp;('.count($tagcount).')</a></div>';
							// echo "(".count($tagcount).")";
							echo '<br>';
							echo '</div>';
						  }
                                 
		 $criteria->with = 'BlogsTags';
		 echo'</ul></div></div>';
 }
 }?>
							
<script type="text/javascript">

function showblog(id)
{
	var tagid = +id;
	
	var url='<?php echo Yii::app()->createUrl("site/showBlogTag"); ?>';
	
	$.post(url,{tagid:tagid},
	 function(data){
	 	
	  if(data)
  	{
		//alert(data);
	 	$(taggedtopics).html(data);
	}
	 });
	
	
}
</script>