<?php
/**
 * The template for displaying posts in the Speaker post format
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<div class="speaker-intro">
    	<div class="speaker-intro-left">
        	<p>
 <!--<img src="<?php echo get_template_directory_uri(); ?>/images/speakers/mike.jpg" class="image-border" />-->
	<?php 
    if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
    the_post_thumbnail(array(420,420), array('class' => 'image-border'));
    } 
    ?>
           
            </p>
            <p>
            <a href="#" class="book-spekaer">BOOK 
<?php
$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[3];
$title = explode("-", $name);
echo strtoupper($title[0]);
?>

</a> 
            <a href="#" class="more-info-speaker">MORE INFO</a> 
            <a href="#" class="view-speaker-finao">VIEW FINAO</a>
            </p>
        </div>
        <div class="speaker-intro-right">
        	<div class="speaker-name-hdline"><?php the_title(); ?></div>
            <div class="speaker-topic-hdline orange"><?php echo get_post_meta($post->ID, 'Speaker Tag', single); ?></div>
            <div id="Default" class="contentHolder">
            	<div class="speaker-intro-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="speaker-videos">
    	<div class="left-video">
         
          <?php
               /* Set variables and create if stament */
				$videosite = get_post_meta($post->ID, 'Video Site', single);
				$videoid = get_post_meta($post->ID, "Video ID", single);
				//echo $videosite;
				if ($videosite == 'vimeo') { 	
  				echo '<iframe src="http://player.vimeo.com/video/'.$videoid.'" width="480" height="270" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				} else if ($videosite == 'youtube') {
  				echo '<iframe width="480" height="270" src="http://www.youtube.com/embed/'.$videoid.'" frameborder="0" allowfullscreen></iframe>';
				} else if($videosite == 'vidler'){
				echo '<iframe id="viddler-'.$videoid.'" src="//www.viddler.com/embed/'.$videoid.'/?f=1&autoplay=0&player=full&secret=75830954&loop=0&nologo=0&hd=0" width="480" height="270" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';
				} else {
  				echo 'Please Select Video Site Via the CMS';
				}
				?>
        </div>
      <!--  <div class="right-video"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/video-sample2.jpg" width="480" height="270" /></a></div>-->
    </div>
    <div class="speaker-all-info">
    	<div class="tabs">
            <ul class="tabNavigation">
                <li><a href="#first">BIOGRAPHY</a></li>
                <li><a href="#second">BOOK NOW</a></li>
                <li><a href="#third">REVIEW</a></li>
                <li><a href="#fourth">LEAVE A REVIEW</a></li>
            </ul>
            <div id="first">
               <?php echo get_post_meta($post->ID, 'Bio', single); ?>
            </div>
            <div id="second">
               <form class="formoid-default" title="Booking Form" method="post">
	<div style="font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:600px; height:342px;">
       <div style="float:left; width:280px;">
       <div class="element-input" ><label class="title">Email<span class="required">*</span></label><input type="text" name="input1" required="required"/></div>
	<div class="element-input" ><label class="title">Name</label><input type="text" name="input" /></div>
	<div class="element-input" ><label class="title">Phone</label><input type="text" name="input2" /></div>
	<div class="element-input" ><label class="title">Event Name<span class="required">*</span></label><input type="text" name="input3" required="required"/></div>
	<div class="element-input" ><label class="title">Date Of Event</label><input type="text" name="input4" /></div>
    <div class="element-submit" style="padding-top:20px;"><input type="submit" value="Submit"/></div>
       </div>
       <div style="float:right;  width:280px;">
       <div class="element-input" ><label class="title">Location</label><input type="text" name="input5" /></div>
	<div class="element-input" ><label class="title">School/College/University<span class="required">*</span></label><input type="text" name="input6" required="required"/></div>
	<div class="element-input" ><label class="title">Estimated Attendance</label><input type="text" name="input7" /></div>
	<div class="element-input" ><label class="title">Additional Notes<span class="required">*</span></label><input type="text" name="input8" required="required"/></div>
       </div>
    </div>

	
	
	

</form>
            </div>
            <div id="third">
			<?php
      
$args = array(
 
	'author_email' => '',
	'ID'           => '',
	'karma'        => '',
	'number'       => '',
	'offset'       => '',
	'orderby'      => '',
	'order'        => 'DESC',
	'parent'       => '',
	'post_ID'      => '',
	'post_id'      => get_the_ID(),
	'post_author'  => '',
	'post_name'    => '',
	'post_parent'  => '',
	'post_status'  => '',
	'post_type'    => 'speakers',
	'status'       => '',
	'type'         => '',
	'user_id'      => '',
	'search'       => '',
	'count'        => false,
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_query'   => ''
);

// The Query
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );

// Comment Loop
if ( $comments ) {
	foreach ( $comments as $comment ) {
	 echo get_avatar( 'comment->comment_author_email', 50 ); 
	//echo get_avatar(get_the_author_meta('user_email'), $size = '96', $default = '<path_to_url>' ); 	
		echo '<p>' . $comment->comment_author .'</p>'; echo 'says';
		echo '<p>' . $comment->comment_content . '</p>';
		
	}
} else {
	echo 'No comments found.';
}
?>
           </div>
            <div id="fourth">
		
                <p><?php comment_form($args, $post_id); ?></p>
				
            </div>
        </div>
    </div>