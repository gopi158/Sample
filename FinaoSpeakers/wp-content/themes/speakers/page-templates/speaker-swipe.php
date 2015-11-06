<?php
/**
 * Template Name: Speakers swipe Page Template
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
 
 <div class="inner-container">
  	<div class="speaker-intro">
    	<div class="speaker-intro-left">
        	<p><img src="<?php echo get_template_directory_uri(); ?>/images/speakers/mike.jpg" class="image-border" width="320" height="320" /></p>
            <p><a href="#" class="book-spekaer">BOOK MIKE</a> <a href="#" class="more-info-speaker">MORE INFO</a> <a href="#" class="view-speaker-finao">VIEW FINAO</a></p>
        </div>
        <div class="speaker-intro-right">
        	<div class="speaker-name-hdline">Mike Smith</div>
            <div class="speaker-topic-hdline orange">EXCITING. PASSIONATE. REAL.</div>
            <div id="Default" class="contentHolder">
            	<div class="speaker-intro-content">
                    <p>"A native to Imperial, Nebraska, Mike has been speaking professionally for the last 5 years and has been a youth outreach worker for over 10 years. He is the founder and executive director of a 501c3 non-profit in THE BAY and its offshoot, Skate For Change (SFC), both of which have begun to receive national acclaim and support from the likes of Red Bull and State Farm. This past summer, Mike also embarked on his second annual mission of skateboarding across the entire state of Nebraska to raise money for these causes.</p>
                    <p>Today, Mike spends his days expanding the scope of these ventures â€" currently, he is finishing up construction on a 28,000 square-foot facility in Lincoln that will serve as the headquarters for THE BAY and SFC,..</p>
                    <p>"A native to Imperial, Nebraska, Mike has been speaking professionally for the last 5 years and has been a youth outreach worker for over 10 years. He is the founder and executive director of a 501c3 non-profit in THE BAY and its offshoot, Skate For Change (SFC), both of which have begun to receive national acclaim and support from the likes of Red Bull and State Farm. This past summer, Mike also embarked on his second annual mission of skateboarding across the entire state of Nebraska to raise money for these causes.</p>
                    <p>Today, Mike spends his days expanding the scope of these ventures â€" currently, he is finishing up construction on a 28,000 square-foot facility in Lincoln that will serve as the headquarters for THE BAY and SFC,..</p>
                </div>
            </div>
        </div>
    </div>
    <div class="speaker-videos">
    	<div class="left-video"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/video-sample1.jpg" width="480" height="270" /></a></div>
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
                <p>"A native to Imperial, Nebraska, Mike has been speaking professionally for the last 5 years and has been a youth outreach worker for over 10 years. He is the founder and executive director of a 501c3 non-profit in THE BAY and its offshoot, Skate For Change (SFC), both of which have begun to receive national acclaim and support from the likes of Red Bull and State Farm. This past summer, Mike also embarked on his second annual mission of skateboarding across the entire state of Nebraska to raise money for these causes.</p>
				<p>Today, Mike spends his days expanding the scope of these ventures â€" currently, he is finishing up construction on a 28,000 square-foot facility in Lincoln that will serve as the headquarters for THE BAY and SFC,..</p>
            </div>
            <div id="second">
                <p>BOOK NOW</p>
            </div>
            <div id="third">
                <p>REVIEW</p>
            </div>
            <div id="fourth">
                <p>LEAVE A REVIEW</p>
            </div>
        </div>
    </div>
  </div>
 
 
<?php get_footer('swipe'); ?>