<?php
/**
 * Template Name: Speakers Page Template
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


get_header('inner'); ?>

 <!--scripts for loading the speakers based on tags starts -->
 <script>
function term_ajax_get(termID) {
	 //alert(termID);
	 //alert('#term-'+termID);
    // jQuery('#term-'+termID).removeClass("active-button");
    //jQuery('#term-'+termID).addClass("active-button");  //adds class current to the category menu item being displayed so you can style it with css
	////jQuery("#term-"+termID).addClass("active-button");
	
    jQuery("#loading-animation").show();
    var ajaxurl = '<?=site_url?>/wp-admin/admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {"action": "load-filter2", term: termID },
        success: function(response) {
            jQuery("#category-post-content").html(response);
            jQuery("#loading-animation").hide();
            return false;
        }
    });
}
</script>
  <!--scripts for loading the speakers based on tags  ends-->
 
<!--<div class="TopWrap">
    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a>
</div>-->
 <div class="inner-container">
 <div class="speaker-intro">
<div class="all-speakers" id="allspeakers">
	<div class="speakers-hdline">
		<span class="Left"><h3>Speakers</h3></span>
    	<!--<span class="Right" style="margin-top:15px;"><a href="#" id="hide" class="orange-link font-15px">Hide All Speakers &and;</a></span>-->
    </div>
    
    <div class="filter-buttons"><a href="<?=site_url?>/speakers/" id="filtershow" class="CycBTN active-button">Show All</a> &nbsp; <a href="#" class="CycBTN" id="filterbytopic">Filter By Topic</a></div>
	<div id="listbyfilter" style="padding:10px;display:none;">
<?php  

$args = array( 'taxonomy' => 'speakertag' );
$terms = get_terms('speakertag', $args);
 //print_r($terms);
$count = count($terms);$i=0;
if ($count > 0) {
    $cape_list = '<p class="my_term-archive">';
    foreach ($terms as $term) {
        $i++;
    	$term_list .= '<a  onclick="term_ajax_get('.$term->term_id.');" class="CycBTNTag '.$term->term_id.' ajax" id="term-'.$term->term_id.'" href="#" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a>';
		
    	if ($count != $i) $term_list .= ' &middot; '; else $term_list .= '</p>';
    }
    echo $term_list;
}
?>
	</div>
    <div class="speakers-list" id="category-post-content">
    	<ul>
		<?php 
        global $paged;
        $curpage = $paged ? $paged : 1;
        $args = array(
        'post_type' => 'speakers',
        'orderby' => 'title',
		'order' => 'ASC',
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
	</div><!-- close div for speaker-intro-->
     </div><!--inner container div-->

</div>
<?php get_footer(); ?>