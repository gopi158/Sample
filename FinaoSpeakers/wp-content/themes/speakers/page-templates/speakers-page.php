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





get_header('swipe'); ?>

<link href="<?php echo get_template_directory_uri(); ?>/css/dcmegamenu.css" rel="stylesheet" type="text/css" />

<link href="<?php echo get_template_directory_uri(); ?>/css/black.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>



<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/jquery.hoverIntent.minified.js'></script>

<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/js/jquery.dcmegamenu.1.2.js'></script>



 <!--scripts for loading the speakers based on tags starts -->

 <script>

 var j = jQuery.noConflict(); 

 j(document).ready(function($){

	j('#mega-menu-1').dcMegaMenu({

		rowItems: '3',

		speed: 'fast',

		effect: 'fade'

	});

});

function term_ajax_get(termID) {jQuery('#ss').fadeOut();

	 //alert(tname);

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

	jQuery('.orange').html(jQuery('#nam'+termID).val());

	

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

	

	 <div class="filter-buttons">

    	<ul id="mega-menu-1" class="mega-menu">

        <li><a href="<?=site_url?>/speakers/">Show All</a></li>

        <li><a href="#">Filter By Topic</a>

            <ul id="ss">

			<?php  

			$args = array( 'taxonomy' => 'speakertag' );

			$terms = get_terms('speakertag', $args);

			//print_r($terms);die();

			$count = count($terms);$i=0;

			if ($count > 0) {

				$cape_list = '<p class="my_term-archive">';

				foreach ($terms as $term) {

					$i++;

					echo '<li><a  onclick="term_ajax_get('.$term->term_id.');" class="CycBTNTag '.$term->term_id.' ajax" id="term-'.$term->term_id.'" href="#" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a><input type="hidden" id="nam'.$term->term_id.'" value="'.$term->name.'" ></li>';

				if ($count != $i) $term_list .= ' &middot; '; else $term_list .= '</p>';

				}}

				?>

		       </ul>

        </li>

	</ul>

    </div>

	 <div class="font-18px Left"><span>Topic:</span> <span class="orange">All Topics</span></div>

    

 <?php /*?>   <div class="filter-buttons"><a href="<?=site_url?>/speakers/" id="filtershow" class="CycBTN active-button">Show All</a> &nbsp; <a href="#" class="CycBTN" id="filterbytopic">Filter By Topic</a></div><div id="listbyfilter" style="padding:10px;display:none;">

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

	</div><?php */?>



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

				

				//$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>

<!--<img src="<?php echo $url; ?>" class="image-border" alt="<?php the_title();?>" width="150" height="150" />-->

               <?php  ?>

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

<?php get_footer('swipe'); ?>