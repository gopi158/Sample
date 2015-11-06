<?php
/**
 * Template Name: Custom Layout
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('custom'); ?>

	 <div role="main" class="main">
  
  
    <div class="swiper-main">
       
      <div class="swiper-container swiper1">
        <div class="swiper-wrapper">
         <?php $postid = get_the_ID();?>
		<?php 
        global $paged;
        $curpage = $paged ? $paged : 1;
        $args = array(
        'post_type' => 'speakers',
        'orderby' => id,
		'order' => 'ASC',
        'posts_per_page' => 150,
        'paged' => $paged
        );
        $query = new WP_Query($args);
        $count = 0;
        if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
        ?>
        <div class="swiper-slide">
             
        
<div class="speaker-intro">
    	<div class="speaker-intro-left">
        	<p>
 <!--<img src="<?php echo get_template_directory_uri(); ?>/images/speakers/mike.jpg" class="image-border" />-->
	<?php 
    /*if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
    the_post_thumbnail(array('300',300), array('class' => 'image-border'));
    }*/
	
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<img src="<?php echo $url; ?>" class="image-border" alt="<?php the_title();?>" width="320" height="320" /> 
    
           
            </p>
            <p>
            <a href="#book-active" id="book-now" class="book-spekaer">Book 
 

<?php
// Getting First Name 1
$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[3];
$title = explode("-", $name);
echo ucfirst($title[0]);
?>

</a> 
            <a href="#bio-active" id="bio-now" class="more-info-speaker"><?php

$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[3];
$title = explode("-", $name);
echo ucfirst($title[0]);
?> Bio</a> 
             
            </p>
        </div>
        <div class="speaker-intro-right">
        	<div class="speaker-name-hdline"><?php the_title(); ?></div>
            <div  class="speaker-topic-hdline orange"><?php echo get_post_meta($post->ID, 'Speaker Tag', single); ?></div>
            <div id="Default" class="contentHolder">
            	<div class="speaker-intro-content">
                    <?php the_content(); ?>
                </div>
            </div>
			<div class="view-all-speakers"><a href="http://biziindia.com/finaospeakers/speakers/"><img src="<?php echo get_template_directory_uri(); ?>/images/view-all-speakers.jpg" /></a></div>
        </div>
    </div>
    <div class="speaker-videos">
        <?php for($i=1;$i<=3;$i++){?> 
		<div class="<?php if($i%2 == 0 ){?>right-video<?php }else{?>left-video<?php }?>">
         
          <?php
               /* Set variables and create if stament */
				$videosite = get_post_meta($post->ID, "Video Site".$i."", single);
				$videoid = get_post_meta($post->ID, "Video ID".$i."", single);
				//echo $videosite;
				if ($videosite == 'vimeo') { 	
  				echo '<iframe src="http://player.vimeo.com/video/'.$videoid.'" width="480" height="270" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				} else if ($videosite == 'youtube') {
  				echo '<iframe width="480" height="270" src="http://www.youtube.com/embed/'.$videoid.'" frameborder="0" allowfullscreen></iframe>';
				} else if($videosite == 'vidler'){
				echo '<iframe id="viddler-'.$videoid.'" src="//www.viddler.com/embed/'.$videoid.'/?f=1&autoplay=0&player=full&secret=75830954&loop=0&nologo=0&hd=0" width="480" height="270" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';
				} else {
  				echo '';
				}
				?>
        </div>
		<?php } ?>
    	
      
    </div>
    <div class="speaker-all-info">
    	<div class="tabs"  id="tab-container">
            <ul class="tabNavigation">
                <li><a href="#first" id="bio-more">Biography</a></li>
                <li><a href="#second" id="booknow">Book Now</a></li>
                <li><a href="#third">Reviews</a></li>
                <li><a href="#fourth">Leave A Review</a></li>
            </ul>
            <div id="first" class="contentHolder" style="overflow:auto;">
		
             <div id="bio-active">  <?php echo get_post_meta($post->ID, 'Bio', single); ?></div>
			   </div>
            <div id="second" class="second">
			   <div id="msg"></div>
            <div class="booking-form" id="book-active">
            <form id="bform" class="formoid-default AdvancedForm" title="Booking Form" method="post"  name="bookingform">
            <div style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:800px; margin:0 auto;" id="supr">
            <div style="float:left; width:390px;">
            <div class="element-input" ><label class="title">Email<span class="required">*</span></label><input id="ValidEmail" class="was email" type="text" name="input1" /></div>
            <div class="element-input" ><label  class="title">Name<span class="required">*</span></label><input id="ValidName" class="was name" type="text" name="input" /></div>
            <div class="element-input" ><label class="title">Phone</label><input id="ValidPhone" type="text" name="input2"  class="phone" /></div>
            <div class="element-input" ><label class="title">Event Name<span class="required">*</span></label><input id="ValidEvent" class="was event" type="text" name="input3" /></div>
            <div class="element-input" ><label class="title">Date Of Event</label><input type="text" name="input4" class="Date" id="Date" readonly="readonly"/></div>
            <div class="element-submit" style="padding-top:20px;"><input type="submit" value="Submit"/></div>
            </div>
            <div style="float:right;  width:390px;">
            <div class="element-input" ><label class="title">Location</label><input id="ValidLocation" type="text" name="input5" class="location" /></div>
            <div class="element-input" ><label class="title">School/College/University<span class="required">*</span></label><input id="ValidSchool" type="text" name="input6" class="was school"/></div>
            <div class="element-input" ><label class="title">Estimated Attendance</label><input type="text" id="ValidNumber" name="input7" class="attendance" /></div>
            <div class="element-input" ><label class="title">Additional Notes<span class="required"></span></label><textarea  name="input8" cols="30" rows="5" class="additional" /></textarea></div>
            </div>
            </div>
            </form>
            
            </div>
 <div style="clear:both;"></div>
            </div>
            <div id="third">
			<?php
   $postID = get_the_ID();
   $comment_array = get_approved_comments($postID);
if($comment_array){
   foreach($comment_array as $comment){
   	
		
	?>
	 <div class="comments-tab">
					<div class="comment-person-img"><?php echo get_avatar( 'comment->comment_author_email', 50 ); ?></div>
					<div class="comment-text-tab">
						<div class="commented-by">
							<span class="Left commented-person-name"><?php echo $comment->comment_author ?></span>
							<span class="Right commented-on"><?php echo $comment->comment_date ?></span>
						</div>
						<div class="comment-text">
							<?php echo $comment->comment_content ?>
						</div>
					</div>
				</div><?php }}
				else{
					echo "no comments found";
				}?>
				</div>
            <div id="fourth">
		
                <?php comment_form( $args, $post_id ); ?>
		 		
            </div>
        </div>
    </div>
        
        </div>
        
<?php endwhile; endif;?>    
         
          
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="pagination pagination1"></div>
  </div>
<?php get_footer('custom'); ?>