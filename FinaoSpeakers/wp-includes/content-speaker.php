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
    the_post_thumbnail('medium', array('class' => 'image-border'));
    } 
    ?>
           
            </p>
            <p>
            <a href="#" class="book-spekaer">BOOK <?php the_title(); ?></a> 
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
        <div class="right-video"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/video-sample2.jpg" width="480" height="270" /></a></div>
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
                <p>BOOK NOW</p>
            </div>
            <div id="third">
            <div id="dropdowncomments">
        <?php comments_template(); ?>
</div>
            </div>
            <div id="fourth">
		
                <p><?php comment_form($args, $post_id); ?></p>
				
            </div>
        </div>
    </div>