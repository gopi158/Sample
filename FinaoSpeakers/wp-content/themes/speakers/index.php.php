
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<!--<div class="TopWrap">
    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a>
</div>-->
<div class="ContentWrap">
<!-- BEGIN CYCLE -->
    <div class="CycleWrapper">
    	
	<div class="pics" id="Cycle"> 
        	<div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/03.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide3">
                            	<h3>Patrick maurer</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/02.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Mike Smith</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. <!--<a href="#"  class="orange-link">Readmore</a>--></p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
  			<div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/01.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide1">
                            	<h3>Scott Backovich</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/04.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide1">
                            	<h3>Harriet</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/05.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Matt McFadyen</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/02.jpg" width="986" height="400" class="CycIMG"/> 
					<div class="CycSlideContent">
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Mike Smith</h3>
                            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed leo eget odio fringilla porta. Morbi consequat convalli.. </p>
								<p><a href="#" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
    	</div>
        
        <div style="float:right; margin:0 25px 10px 0;"><a href="#" class="orange-link font-15px" id="viewall">View All Speakers</a></div>
	</div>
<!-- END CYCLE -->
<!-- BEGIN DEMO DESCRIPTION STUFF -->
</div>

<div class="all-speakers" id="allspeakers">
	<div class="speakers-hdline">
		<span class="Left"><h3>Speakers</h3></span>
    	<span class="Right" style="margin-top:15px;"><a href="#" id="hide" class="orange-link font-15px">Hide All Speakers &and;</a></span>
    </div>
    
    <div class="filter-buttons"><a href="#" class="CycBTN active-button">Show All</a> &nbsp; <a href="#" class="CycBTN" id="filterbytopic">Filter By Topic</a></div>
	<div id="listbyfilter">content comes here
<?php  
// Let's find out if we have taxonomy information to display  
// Something to build our output in  
$taxo_text = "speakers";  
  
// Variables to store each of our possible taxonomy lists  
// This one checks for an Operating System classification  
$os_list = get_the_term_list( $post->ID, 'speakertag', '<strong>Operating System(s):</strong> ', ', ', '' ); 
?>
	
	</div>
    <div class="speakers-list">
    	<ul>
		<?php 
        global $paged;
        $curpage = $paged ? $paged : 1;
        $args = array(
        'post_type' => 'speakers',
        'orderby' => 'post_date',
        'posts_per_page' => 150,
        'paged' => $paged
        );
        $query = new WP_Query($args);
        $count = 0;
        if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
        ?>
        	<a href="<?php the_permalink(); ?>"><li>
            	
                <p class="speaker-image">
                <!--<img src="<?php echo get_template_directory_uri(); ?>/images/speakers/speaker1.jpg" class="image-border" />-->
				<?php 
                if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail('thumbnail', array('class' => 'image-border'));
                } 
                ?>
                </p>
                <p class="speaker-name"><?php the_title(); ?></p>
                <p class="speaker-topic"><?php echo get_post_meta($post->ID, 'Speaker Tag', single); ?></p>
            </li></a>
<?php endwhile; endif;?>    
        </ul>
    </div>
    </div>

<div class="speakers-message" id="speakersmessage">
	<p class="orange font-20px">About Speakers Bureau</p>
	<p><img src="<?php echo get_template_directory_uri(); ?>/images/speakersBureauLogo.png" width="100" class="Left" style="margin-right:10px;" />The FINAO Speakers Bureau is a  specialized service formed to help youth organizations and schools, and enterprise groups including large and small business. We match quality speakers with target audiences providing a customized message with an infusion of goal oriented accountability.</p>
	<p><i>Joining FINAO lets me do even greater things to meet the needs and objectives we all have in serving youth and business.</i></p>
    <p class="orange Right">Managing Director, FSB</p>
</div>

</div>
<?php get_footer(); ?>