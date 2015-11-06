<?php
/**
 * The template for displaying posts in the Speaker post format
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.validate.css" />
        <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.3.2.js" type="text/javascript">
        </script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.js" type="text/javascript">
        </script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validation.functions.js" type="text/javascript">
        </script>
        <script type="text/javascript">
            /* <![CDATA[ */
            jQuery(function(){
                jQuery("#ValidField").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
				 jQuery("#ValidEvent").validate({
                    expression: "if (VAL.match(/^[a-zA-Z]/) && VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
				
				
			
				  jQuery("#ValidSchool").validate({
                    expression: "if (VAL.match(/^[a-zA-Z]/) && VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
				
				 jQuery("#ValidNotes").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Required field"
                });
				 
				 
                jQuery("#ValidNumber").validate({
                    expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
                    message: "Please enter a valid number"
                });
				
                jQuery("#ValidInteger").validate({
                    expression: "if (VAL.match(/^\(?\d{3}\)? ?-? ?\d{3} ?-? ?\d{4}$/) && VAL) return true; else return false;",
                    message: "Please enter a valid integer"
                });
				
				jQuery("#ValidPhone").validate({
                    expression: "if (VAL.match(/^[0-9]{3}-[0-9]{3}-[0-9]{4}/) && VAL) return true; else return false;",
                    message: "Please enter a valid Number"
                });
				
				jQuery("#ValidName").validate({
                    expression: "if (VAL.match(/^[a-zA-Z]/) && VAL) return true; else return false;",
                    message: "Please enter a valid Name"
                });
				
				jQuery("#ValidLocation").validate({
                    expression: "if (VAL.match(/^[a-zA-Z]/) && VAL) return true; else return false;",
                    message: "Please enter a valid Name"
                });
				
                jQuery("#ValidDate").validate({
                    expression: "if (!isValidDate(parseInt(VAL.split('-')[2]), parseInt(VAL.split('-')[0]), parseInt(VAL.split('-')[1]))) return false; else return true;",
                    message: "Please enter a valid Date"
                });
                jQuery("#ValidEmail").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                    message: "Please enter a valid Email ID"
                });
                jQuery("#ValidPassword").validate({
                    expression: "if (VAL.length > 5 && VAL) return true; else return false;",
                    message: "Please enter a valid Password"
                });
                jQuery("#ValidConfirmPassword").validate({
                    expression: "if ((VAL == jQuery('#ValidPassword').val()) && VAL) return true; else return false;",
                    message: "Confirm password field doesn't match the password field"
                });
                jQuery("#ValidSelection").validate({
                    expression: "if (VAL != '0') return true; else return false;",
                    message: "Please make a selection"
                });
                jQuery("#ValidMultiSelection").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please make a selection"
                });
                jQuery("#ValidRadio").validate({
                    expression: "if (isChecked(SelfID)) return true; else return false;",
                    message: "Please select a radio button"
                });
                jQuery("#ValidCheckbox").validate({
                    expression: "if (isChecked(SelfID)) return true; else return false;",
                    message: "Please check atleast one checkbox"
                });
				jQuery('.AdvancedForm').validated(function(){
				var email = $(".email").val();
				var name  = $(".name").val();
				var phone = $(".phone").val();
				var event = $(".event").val();
				var Date  = $(".Date").val();
				var location = $(".location").val();
				var school   = $(".school").val();
				var attendance = $(".attendance").val();
				var additional = $(".additional").val();
				var speaker = $(".speaker-name-hdline").text();
				 
				
		       //var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone;  
// appending data to data string
   var dataString = 'email='+ email + '&name='+ name + '&phone=' + phone +'&event='+ event + '&Date=' + Date + '&location='+ location + '&school=' + school +'&attendance='+ attendance + '&additional=' + additional+ '&speaker=' + speaker;  
//alert (dataString);return false;  
				
				$.ajax({  
				type: "POST",  
				url: "<?php echo get_template_directory_uri(); ?>/ajaxcall.php",  //calling another func
				context: document.body,
				data: dataString,  
				success: function(data) { 
				 
				$("#msg").html(data);
				document.getElementById("bform").reset();
				setTimeout('$("#msg").fadeOut()',5000);
 				}  
				});  
				//alert("Use this call to make AJAX submissions.");
				});
            });
            /* ]]> */
        </script>

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
            <a href="#" id="book-now" class="book-spekaer">Book 
<?php
//echo $_SERVER['REQUEST_URI'];
?>

<?php
// Example 1
$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[3];
$title = explode("-", $name);
echo ucfirst($title[0]);
?>

</a> 
            <a href="#" class="more-info-speaker">More Info</a> 
            <a href="#" class="view-speaker-finao">View Speakers's FINAO</a>
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
    	
      <!--  <div class="right-video"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/video-sample2.jpg" width="480" height="270" /></a></div>-->
    </div>
    <div class="speaker-all-info">
    	<div class="tabs">
            <ul class="tabNavigation">
                <li><a href="#first">Biography</a></li>
                <li><a href="#second">Book Now</a></li>
                <li><a href="#third">Reviews</a></li>
                <li><a href="#fourth">Leave A Review</a></li>
            </ul>
            <div id="first" class="contentHolder">
		
             <div id="Demo">  <?php echo get_post_meta($post->ID, 'Bio', single); ?></div>
			   </div>
          
            <div id="second">
			   <div id="msg"></div>
            <div class="booking-form">
            <form id="bform" class="formoid-default AdvancedForm" title="Booking Form" method="post">
            <div style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:600px; margin:0 auto;">
            <div style="float:left; width:280px;">
            <div class="element-input" ><label class="title">Email<span class="required">*</span></label><input id="ValidEmail" class="email" type="text" name="input1" /></div>
            <div class="element-input" ><label  class="title">Name<span class="required">*</span></label><input id="ValidName" class="name" type="text" name="input" /></div>
            <div class="element-input" ><label class="title">Phone</label><input id="ValidPhone" type="text" name="input2"  class="phone" /></div>
            <div class="element-input" ><label class="title">Event Name<span class="required">*</span></label><input id="ValidEvent" class="event" type="text" name="input3" /></div>
            <div class="element-input" ><label class="title">Date Of Event</label><input type="text" name="input4" class="Date" /></div>
            <div class="element-submit" style="padding-top:20px;"><input type="submit" value="Submit"/></div>
            </div>
            <div style="float:right;  width:280px;">
            <div class="element-input" ><label class="title">Location</label><input id="ValidLocation" type="text" name="input5" class="location" /></div>
            <div class="element-input" ><label class="title">School/College/University<span class="required">*</span></label><input id="ValidSchool" type="text" name="input6" class="school"/></div>
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
  /*    
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
	'post_status'  => 'publish',
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
		//echo $comment->comment_approved;
	 
		 echo get_avatar( 'comment->comment_author_email', 50 ); 
	//echo get_avatar(get_the_author_meta('user_email'), $size = '96', $default = '<path_to_url>' ); 	
		echo '<p>' . $comment->comment_author .'</p>'; echo 'says';
		echo '<p>' . $comment->comment_content . '</p>';
	 
		
	}
} else {
	echo 'No comments found.';
}*/

 
   $postID = get_the_ID();
   $comment_array = get_approved_comments($postID);

   foreach($comment_array as $comment){
      echo get_avatar( 'comment->comment_author_email', 50 ); 
	//echo get_avatar(get_the_author_meta('user_email'), $size = '96', $default = '<path_to_url>' ); 	
		echo '<p>' . $comment->comment_author .'</p>'; echo 'says';
		echo '<p>' . $comment->comment_content . '</p>';
   }
 
?>
           </div>
            <div id="fourth">
		
                <p><?php comment_form($args, $post_id); ?></p>
				
            </div>
        </div>
    </div>