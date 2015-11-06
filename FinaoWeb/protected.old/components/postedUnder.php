<br/><br/><?php class postedUnder extends CWidget
{
 
 public $BlogPostedUnder;
 //public $comments;
 public function run()
 {
		 echo '<div class="popular-topics">
						<div id="topics" class="gradient-bg"><span style="float:left; padding-top:5px; padding-left:10px;">Topics</span></div>
						 <div class="popular-topics-content">
						 
						 
						  <ul>';
						  $criteria = new CDbCriteria();
						  $criteria->limit = 10;
						  $criteria->order = 'created_date DESC';
						  $criteria->group = 'blog_post_under';
						  $BlogPostedUnder = Blogs::model()->findAll($criteria);
						
						  foreach($BlogPostedUnder as $posts)
						  {
						  	$coutning = Blogs::model()->findAllByAttributes(array('blog_post_under'=>$posts->blog_post_under));
							$counts = count($coutning);
							
							if($posts->type == "blogs"){
							echo '<div id="populartags">';
							echo '<input type="hidden" id="blogid-'.$posts->blog_id.'" value="'. $posts->blog_id .'" />';
						 	echo '<div class="orange-link"><a class="blue-link font-12px" onclick="showpost('.$posts->blog_id.')">'. ucfirst($posts->blog_post_under) .'&nbsp;('.$counts.')</a></div>';
							// echo "(".count($tagcount).")";
							echo '<br>';
							echo '</div>';
								
							}
							
						  }
                                 
		// $criteria->with = 'Blogs';
		 echo'</ul></div></div>';
 }
 }?>
							
<script type="text/javascript">

function showpost(id)
{
	var blogid = +id;
	var url='<?php echo Yii::app()->createUrl("site/showBlogPost"); ?>';
	$.post(url,{blogid:blogid},
	 function(data){
	 	
	  if(data)
  	{
		//alert(data);
	 	$(taggedtopics).html(data);
	}
	 });
	
	
}
</script>