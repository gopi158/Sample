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
			
			<?php 
        global $paged;
        $curpage = $paged ? $paged : 1;
        $args = array(
        'post_type' => 'speakers',
        'orderby' => 'rand',
		'order' => 'ASC',
        'posts_per_page' => 6,
        'paged' => $paged
        );
        $query = new WP_Query($args);
        $count = 0; $c=1;
        if($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
		if($c=='4') $c=1;
        ?>
        	<div>
				<?php 
				the_post_thumbnail('full',array('class' => 'CycIMG')); 
				//$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');?>
   <!--<img src="<?php echo $large_image_url[0]; ?>" width="986" height="440" class="CycIMG"/>-->
 <div style="display:none"><?php the_post_thumbnail('thumbnail', array('class' => 'CycIMGs')); ?></div>
 				<?php /*?><img src="<?php echo get_template_directory_uri(); ?>/images/01.jpg" width="986" height="440" class="CycIMG"/> <?php */?>
					<div class="CycSlideContent">
						<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide<?php echo get_post_meta($post->ID, 'slider postion', single); ?>">
                            	<h3><?php the_title(); ?></h3>
                            	<p><?php echo substr(get_the_excerpt(), 0,250).'...'; ?> <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="<?php the_permalink(); ?>" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
           
		  <?php $c++; endwhile; endif;?> 
		  <?php /*?> <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/02.jpg" width="986" height="440" class="CycIMG"/> 
					<div class="CycSlideContent">
					<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Patrick Perez</h3>
                            	<p>Student success author and super-fresh Latino youth speaker Patrick "Pac Man" Perez combines the eye-catching style of .. <!--<a href="#"  class="orange-link">Readmore</a>--></p>
								<p><a href="http://biziindia.com/finaospeakers/speakers/patrick-perez/" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
  			<div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/03.jpg" width="986" height="440" class="CycIMG"/> 
					<div class="CycSlideContent">
					<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Scott Backovich</h3>
                            	<p>Scott's presentations begin as a giant party. In one moment, students are laughing hysterically, moving actively on their feet, and shouting .. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="http://biziindia.com/finaospeakers/speakers/scott-backovich/" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/04.jpg" width="986" height="440" class="CycIMG"/> 
					<div class="CycSlideContent">
					<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide1">
                            	<h3>Eddie Slowikowski</h3>
                            	<p>One little known fact about Eddie Slowikowski is that he is a Sub-4 miler.  He ran the mile in 3 minutes 59.6 seconds.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="http://biziindia.com/finaospeakers/speakers/eddie-slowikowski/" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
            <div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/05.jpg" width="986" height="440" class="CycIMG"/> 
					<div class="CycSlideContent">
					<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide2">
                            	<h3>Aric Bostick</h3>
                            	<p>Being an educator, counselor or youth advocate is one of the most rewarding occupations in the world.  However, it is also one of the most challenging,.. <!--<a href="#" class="orange-link">Readmore</a>--></p>
								<p><a href="http://biziindia.com/finaospeakers/speakers/aric-bostick-2/" class="CycBTN Left">Read more</a></p>
                            </div>
						</div>
					</div>
			</div>
          	<div>
 				<img src="<?php echo get_template_directory_uri(); ?>/images/06.jpg" width="986" height="440" class="CycIMG"/> 
					<div class="CycSlideContent">
					<div class="logo-area" style="position: absolute; top:15px; left:15px;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
						<div class="CycDetails">
                        	<div class="Slide1">
                            	<h3>Tiana Tozer</h3>
                            	<p>Tiana's message can be altered to meet the needs of various school climates, age groups and purposes.... 
								<a href="http://biziindia.com/finaospeakers/speakers/tiana-tozer/" class="CycBTN Left">Read more</a></p>
                          	  </div> 
						</div>
					</div>
			</div><?php */?>
			
			
    	</div>
        
        <div style="float:right; margin:0 25px 5px 0;"><a href="<?=site_url?>/speakers/" class="orange-link font-15px" id="viewall">View All Speakers</a></div>
	</div>
<!-- END CYCLE -->
<!-- BEGIN DEMO DESCRIPTION STUFF -->
</div>

<div class="Home-all-speakers" id="allspeakers">
	<?php /*?><div class="speakers-hdline">
		<span class="Left"><h3>Speakers</h3></span>
    	<span class="Right" style="margin-top:15px;"><a href="#" id="hide" class="orange-link font-15px">Hide All Speakers &and;</a></span>
    </div>
    
    <div class="filter-buttons"><a href="#" class="CycBTN active-button">Show All</a> &nbsp; <a href="#" class="CycBTN" id="filterbytopic">Filter By Topic</a></div>
	<div id="listbyfilter">
<?php  

$args = array( 'taxonomy' => 'speakertag' );
$terms = get_terms('speakertag', $args);
// print_r($terms);
$count = count($terms);$i=0;
if ($count > 0) {
    $cape_list = '<p class="my_term-archive">';
    foreach ($terms as $term) {
        $i++;
    	$term_list .= '<a href="/fspeakers/speakertag/' . $term->slug . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a>';
		
    	if ($count != $i) $term_list .= ' &middot; '; else $term_list .= '</p>';
    }
    echo $term_list;
}
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
    </div><?php */?>

<div class="speakers-message" id="speakersmessage">
	<p class="orange font-20px">The FINAO Speakers Bureau</p>
	<p><img src="<?php echo get_template_directory_uri(); ?>/images/chris.jpg" class="Left" style="margin-right:10px; border:solid 2px #FFF;" />The FINAO Speakers Bureau is a  specialized service formed to help youth organizations and schools, and enterprise groups including large and small business. We match quality speakers with target audiences providing a customized message with an infusion of goal oriented accountability.</p>
	<p style="line-height:27px;"><span class="orange"> - Chris Fisher<br /> <!--<img src="<?php echo get_template_directory_uri(); ?>/images/speakersBureauLogo.png" width="30" class="Left" style="margin-right:5px;" />-->Managing Director FSB</span> <br /><i>Joining FINAO lets me do even greater things to meet the needs and objectives.. </i><a href="javascript:void(0)" class="orange-link font-13px"  onclick="Showchrisbio()" id="Showmore">Show Chris bio</a>
	
	</p>
	<div id="chrisbio" style="display:none; padding:0 25px;">
	<!--<p style="line-height:0; margin-bottom:20px;">&nbsp;</p>-->
	<p class="orange font-20px" id="">Chris's Bio:</p>
	<p>Joining FINAO lets me do even greater things to meet the needs and objectives we all have in serving youth and business.</p>
	<p>Chris Fisher has worked 15 plus years in the speaking industry.  Chris was an agent for the Jostens Speakers Bureau for 3 years.  Chris became the Director of the Jostens Speakers Bureau. Chris then set up the Fisher Agency is the owner and Director of The Fisher Agency and Bureau dedicated to the Youth Education Market.</p>
	<p>Chris understands the issues of today's youth as well as educators because his family is full of teachers and his two children recently graduated from high school.  Chris will help you select the best possible speaker for your event and your budget.  Chris is excited to be apart of The FINAO Speakers Bureau, seeing that is the way he lives his life.</p>
	<p class="speaker-quote">&quot;Without inspiration the best powers of the mind remain dormant, there is a fuel in is which needs to be ignited.&quot;<span class="orange">--Johann Gottfried Von Herder.</span></p> 
	 </p></div>
</div>
<!--
<div style="margin-top:10px; float:left;">
<iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="970" height="450" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe> 
</div>-->

</div>
</div>
<?php get_footer(); ?>