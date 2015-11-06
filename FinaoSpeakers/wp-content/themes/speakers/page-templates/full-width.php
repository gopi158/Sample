<?php
/**
 * Template Name: Full-width Page Template, No Sidebar
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('inner'); ?>

	 <div class="inner-container">
  	<div class="pages-content-area" style="padding: 30px 10px!important;">
    	<div class="orange font-18px padding-10pixels"><span class="Left"><?php the_title(); ?></span> <span class="Right"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/back.png" width="60" /></a></span></div>
            <div class="clear"></div>
       <!-- <div class="content-run-text">FINAO<sup>&reg;</sup> began as a movement in the early 1990s based on the belief that Failure Is Not An Option. It is now an online community where you can safely declare your goals in your private personal profile. FINAO empowers you to form goals that align with your personal passions and capabilities. We call these statements of commitment "FINAOs" (fin-nāy-o), which stands for "Failure Is Not An Option."</div>
        <div class="content-run-text">Everyone's different, so the FINAO is completely customizable to help you create the goal-oriented life you want to live. Set your goals. Track your progress. Share what you want with others. Follow others to become inspired. </div>
        <div class="orange font-18px padding-10pixels">The FINAO<sup>&reg;</sup> Team</div>
        <div class="content-run-text">Our team is a mix of career-minded individuals who decided it's time to put family first, taking the risk to leave secure career positions to follow dreams, and who wake up saying, "I will leave a positive mark on this world."  </div>
		<div class="content-run-text">We're laser-focused on the personal pursuit of aspirations, commitments, values, and goals; all distinct individuals defining success on our own terms. Despite our unique personal values and definitions of success we are driven by one principle – Failure Is Not An Option.</div>
		<div class="content-run-text">That passion is evident in everything we do, but most importantly it manifests itself in our efforts to ensure our members have a great experience while expressing their own FINAO.</div>-->
        <?php while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-page-image">
						<?php the_post_thumbnail(); ?>
					</div><!-- .entry-page-image -->
				<?php endif; ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>
        
    </div> 
  </div>

<?php get_footer('inner'); ?>