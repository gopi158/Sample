
<script type="text/javascript">
$(document).ready(function(){
	
$("#sumbmiting").click(function() {
//getting data from form

	var email = $("#email").val();
	var name  = $("#name").val();
	var phone = $("#phone").val();
	var event = $("#event").val();
	var Date  = $("#Date").val();
	var location = $("#location").val();
	var school   = $("#school").val();
	var attendance = $("#attendance").val();
	var additional = $("#additional").val();
	var emailaddressVal = $("#email").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(emailaddressVal== ''|| !emailReg.test(emailaddressVal)){
              $("#email").css("border-color", "red");
			  $("#emailerror").show();
			  
            }
			else{
				 $("#email").css("border-color", "green");
				 $("#emailerror").hide();
             
			}
	
	
	if(school== ''){
              $("#school").css("border-color", "red");
			   $("#college").show();
			  
            }
			else{
				
				 $("#school").css("border-color", "green");
				  $("#college").hide();
             
			}
		if(event== ''){
              $("#event").css("border-color", "red");
			   $("#eventname").show();
			 
            }
			else{
				 $("#event").css("border-color", "green");
				  $("#eventname").hide();
            
			}	
			if(additional== ''){
              $("#additional").css("border-color", "red");
			   $("#Additionalnotes").show();
			 return false;
            }
			else{
				 $("#additional").css("border-color", "green");
				   $("#Additionalnotes").hide();
              
			}
			
    //var email = document.getElementById('email');
	//var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//if (!filter.test(email.value)) {
	//document.getElementById("email").style.border = "1px solid red";
    //alert('Please provide a valid email address');
   // email.focus;
   // return false;
 //}
// var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone;  
// appending data to data string
   var dataString = 'email='+ email + '&name='+ name + '&phone=' + phone +'&event='+ event + '&Date=' + Date + '&location='+ location + '&school=' + school +'&attendance='+ attendance + '&additional=' + additional;  
//alert (dataString);return false;  
$.ajax({  
  type: "POST",  
  url: "<?php echo get_template_directory_uri(); ?>/ajaxcall.php",  //calling another func
  data: dataString,  
  success: function(data) {  
  //$('<div id="alert">Successfully Updated</div>');
  /**  alert("Done!")* /*/
	/* $('#second').html("<div id='message'></div>");  
    $('#message').html("<h2>Contact Form Submitted!</h2>")  
    .append("<p>We will be in touch soon.</p>")  
    .hide()  
   .fadeIn(1500, function() {  
      $('#message').append("<img id='checkmark' src='<?php echo get_template_directory_uri(); ?>/images/check.png' />");  
	  $("#cform").show();  
    }); */
$("#msg").html(data);
  }  
  
});  
return false; 
});
});
</script>
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
            <a href="#" class="book-spekaer">Book 
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
            <div class="speaker-topic-hdline orange"><?php echo get_post_meta($post->ID, 'Speaker Tag', single); ?></div>
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
            <div id="first">
               <?php echo get_post_meta($post->ID, 'Bio', single); ?>
            </div>
            <div id="second">
			   <div id="msg"></div>
               <form class="formoid-default" title="Booking Form" method="post" id="cform">
	<div style="" class="booking-form">
       <div style="float:left; width:280px;">
    <div class="element-input" >
	<label class="title">Email<span >*</span></label>
	<input type="text" name="email" id="email" required="required"/><span id="emailerror" style="color:red;display:none;">Required</span>
	</div>
	<div class="element-input" >
	<label class="title">Name</label><input type="text" name="name" id="name"/>
	</div>
	<div class="element-input" ><label class="title">Phone</label><input type="text" name="phone" id="phone" /></div>
	<div class="element-input" ><label class="title">Event Name<span >*</span></label>
	<input type="text" id="event" name="event" required="required"/><span id="eventname" style="color:red;display:none;">Event Name Required</span>
	</div>
	<div class="element-input" ><label class="title">Date Of Event</label><input type="text" name="Date" id="Date" /></div>
    <div class="element-submit" style="padding-top:20px;"><input type="submit" value="Submit" id="sumbmiting"/></div>
       </div>
       <div style="float:right;  width:280px;">
       <div class="element-input" ><label class="title">Location</label><input type="text" name="location"  id="location"/>
	   </div>
	   <div class="element-input" ><label class="title">School/College/University<span >*</span></label>
	   <input type="text" name="school" id="school" required="required"/><span id="college" style="color:red;display:none;">School/College/University Required</span>
	   </div>
	<div class="element-input" ><label class="title">Estimated Attendance</label><input type="text" name="attendance"  id="attendance"/></div>
	<div class="element-input" ><label class="title">Additional Notes<span >*</span></label>
	<input type="text" name="additional" id="additional" required="required"/><span id="Additionalnotes" style="color:red;display:none;">additional notesRequired</span>
	</div>
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