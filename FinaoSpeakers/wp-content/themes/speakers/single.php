<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('swipe'); ?>

	<div class="inner-container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
                 <!--.nav-single -->
            <div class="speaker-slider-navigation">
            <?php previous_post_link('%link','<img class="LeftArrow" src="http://finaospeakers.com/wp-content/uploads/2013/06/arrow-left.png"/>'); ?>
            <?php next_post_link('%link','<img class="RightArrow" src="http://finaospeakers.com/wp-content/uploads/2013/06/arrow-right.png"/>'); ?>
             </div>
				<?php //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
    </div>
<?php get_footer('swipe'); ?>