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
		function isNumberKey(evt)
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
		
			 return true;
		  }
              function book_validate()
			  {
			  var err=0;
			   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			  $('.was').each(function() {
			  	if($(this).val()=='')
				{$(this).css('border','1px red solid');//$(this).focus();
				err++;}
				else {$(this).css('border','1px green solid');}
				});
				if(err>0) { return false;}
			  
			  else 
			  {
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
				}
				return false;
            }
		function strs()
		{
			var ss=$("#ValidName").val();
		 if(!(ss).match(/^[a-zA-Z ]+$/))
		  {
		  	$('#ValidName').css('border','1px red solid');$('#Validnamer').show();$('#ValidName').focus();
				 return false;
		  }
		  else
		  {
		  	$('#ValidName').css('border','1px green solid');$('#Validnamer').hide();
		  }
		}	
		function valid_school()
		{
			var ss=$("#ValidSchool").val();
		 if(!(ss).match(/^[a-zA-Z ]+$/))
		  {
		  	$('#ValidSchool').css('border','1px red solid');$('#ValidSchooler').show();$('#ValidSchool').focus();
				 return false;
		  }
		  else
		  {
		  	$('#ValidSchool').css('border','1px green solid');$('#ValidSchooler').hide();
		  }
		}	
		function valid_email()
		{
		 var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if(emailPattern.test($('#ValidEmail').val())==false)
			  {
			  	$('#ValidEmail').css('border','1px red solid');$('#ValidEmailerr').show();$('#ValidEmail').focus();
				 return false;
			  }
			  else {$('#ValidEmail').css('border','1px green solid');$('#ValidEmailerr').hide();}
		}		
		function valid_evntname()
		{
		if($('#ValidEvent').val()=='')
			  {
			  	$('#ValidEvent').css('border','1px red solid');$('#ValidEvent').focus();
				 return false;
			  }
			  else {$('#ValidEvent').css('border','1px green solid');}
		}		
        </script>
		<!--logo-->

<div class="speaker-intro">
    	<div class="speaker-intro-left">
        	<p>
 <!--<img src="<?php echo get_template_directory_uri(); ?>/images/speakers/mike.jpg" class="image-border" />-->
	<?php 
    /*if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
    the_post_thumbnail(array('300',300), array('class' => 'image-border'));
    }*/
	
	//$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<!--<img src="<?php echo $url; ?>" class="image-border" alt="<?php the_title();?>" width="320" height="320" /> -->
    <?php 
	if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
    the_post_thumbnail('medium', array('class' => 'image-border'));
    }
	?>
           
            </p>
            <p style="min-width:500px; max-width:700px;">
            <a href="#book-active" id="book-now" class="book-spekaer">Book 
 

<?php
// Getting First Name 1
$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[2];
$title = explode("-", $name);
echo ucfirst($title[0]);
?>

</a> 
            <a href="#bio-active" id="bio-now" class="more-info-speaker"><?php

$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[2];
$title = explode("-", $name);
echo ucfirst($title[0]);
?>'s Bio</a> 
<?php $a=get_post_meta($post->ID, 'Speakers Finao Profile', single); 
if($a)
{?>

   <a href="<?php echo get_post_meta($post->ID, 'Speakers Finao Profile', single); ?>" id="bio-now" class="view-speaker-finao" target="_blank"><?php

$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[2];
$title = explode("-", $name);
echo ucfirst($title[0]);
?>'s FINAO</a>

<?php }else{ ?>
  <a href="<?php echo get_post_meta($post->ID, 'Speakers Finao Profile', single); ?>" id="bio-now" class="" target="_blank"><?php

$url  = $_SERVER['REQUEST_URI'];
$pieces = explode("/", $url);
$name = $pieces[2];
$title = explode("-", $name);
//echo ucfirst($title[0]);
?></a>
<?php }?>
             
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
			<div class="view-all-speakers"><a href="<?=site_url?>/speakers/"><img src="<?php echo get_template_directory_uri(); ?>/images/view-all-speakers.jpg" /></a></div>
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
    	
      
    </div>
    <div class="speaker-all-info">
    	<div class="tabs"  id="tab-container">
            <ul class="tabNavigation">
                <li><a href="#first" id="bio-more">Biography</a></li>
                <li><a href="#second" id="booknow">Booking Info</a></li>
                <li><a href="#third">Reviews</a></li>
                <li><a href="#fourth">Leave a Review</a></li>
            </ul>
            <div id="first" class="contentHolder" style="overflow:auto;">
		
             <div id="bio-active">  <?php echo get_post_meta($post->ID, 'Bio', single); ?></div>
			   </div>
            <div id="second" class="second">
			   <div id="msg"></div>
            <div class="booking-form" id="book-active">
            <form id="bform" class="formoid-default AdvancedForm" title="Booking Form" method="post"  name="bookingform">
            <div style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:800px; margin:0 auto;" id="supr">
            <div style="float:left; width:390px;">
            <div class="element-input" ><label class="title">Email<span class="required">*</span></label><input id="ValidEmail" class="was email" type="text" name="input1" onchange="return valid_email();" /><span style="color:#FF0000; display:none" id="ValidEmailerr">Enter Valid Email Id</span></div>
            <div class="element-input" ><label  class="title">Name<span class="required">*</span></label><input id="ValidName" class="was name" type="text" name="input" onchange="return strs();" /><span style="color:#FF0000; display:none" id="Validnamer">Enter Valid Name</span></div>
            <div class="element-input" ><label class="title">Phone</label><input onkeypress="return isNumberKey(event)" id="ValidPhone" type="text" name="input2"  class="phone" /></div>
            <div class="element-input" ><label class="title">Event Name<span class="required">*</span></label><input id="ValidEvent" class="was event" type="text" name="input3" onchange="return valid_evntname();"  /></div>
            <div class="element-input" ><label class="title">Date Of Event</label><input type="text" name="input4" class="Date" id="Date" readonly="readonly"/></div>
            <div class="element-submit" style="padding-top:20px;"><input type="button" onclick="return book_validate();" value="Submit"/></div>
            </div>
            <div style="float:right;  width:390px;">
            <div class="element-input" ><label class="title">Location</label><input id="ValidLocation" type="text" name="input5" class="location" /></div>
            <div class="element-input" ><label class="title">School/College/University<span class="required">*</span></label><input id="ValidSchool" type="text" name="input6" onkeyup="return valid_school();" class="was school"/><span style="color:#FF0000; display:none" id="ValidSchooler">Enter Valid School</span></div>
            <div class="element-input" ><label class="title">Estimated Attendance</label><input type="text" id="ValidNumber" name="input7" class="attendance" onkeypress="return isNumberKey(event)" /></div>
            <div class="element-input" ><label class="title">Additional Notes<span class="required"></span></label><textarea  name="input8" cols="30" rows="5" class="additional" /></textarea></div>
            </div>
            </div>
            </form>
            
            </div>
 <div style="clear:both;"></div>
            </div>
            <div id="third">
			<?php
   $postID = get_the_ID();
   $comment_array = get_approved_comments($postID);
if($comment_array){
   foreach($comment_array as $comment){
   	
		
	?>
	 <div class="comments-tab">
					<div class="comment-person-img"><?php echo get_avatar( 'comment->comment_author_email', 50 ); ?></div>
					<div class="comment-text-tab">
						<div class="commented-by">
							<span class="Left commented-person-name"><?php echo $comment->comment_author ?></span>
							<span class="Right commented-on"><?php echo $comment->comment_date ?></span>
						</div>
						<div class="comment-text">
							<?php echo $comment->comment_content ?>
						</div>
					</div>
				</div><?php }}
				else{
					echo "no comments found";
				}?>
				</div>
            <div id="fourth">
		
                <?php comment_form( $args, $post_id ); ?>
		 		
            </div>
        </div>
    </div>
	
	
	<script>
// AJAXified commenting system
jQuery('document').ready(function($){
var commentform=$('#commentform'); // find the comment form
commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
var statusdiv=$('#comment-status'); // define the infopanel

commentform.submit(function(){
//serialize and store form data in a variable

var formdata=commentform.serialize();
//Add a status message
statusdiv.html('<p>Processing...</p>');
//Extract action URL from commentform
var formurl=commentform.attr('action');
//Post Form with data
$.ajax({
type: 'post',
url: formurl,
data: formdata,
error: function(XMLHttpRequest, textStatus, errorThrown){
statusdiv.html('<p class="wdpajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
},
success: function(data, textStatus){
if(data=="success")
statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
else
statusdiv.html('<p class="ajax-error" >Thanks for your Review. We appreciate your response.</p>');
commentform.find('textarea[name=comment]').val('');
}
});
return false;

});
});</script>