<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>FINAO NATION</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/styles.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/home.css" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<!-- Required header files -->
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/javascript/ajaximage/css/style.css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/team-pages.css" media="screen" />


<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/ajaximage/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/ajaximage/js/file_uploads.js"></script>
<!--<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/ajaximage/js/vpb_script.js"></script>-->

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?0SEie6sCph2idhKnNxLeAObpgmg1AaP6';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
<?php include('analytics.php')?>

 

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!--<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/slick/jquery.slick.2.1.js"></script>-->

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 

<script type="text/javascript">



$(document).ready(function($){

	//notificationcount();
 		/*Added by LK (01.07.2013)*/
		$(".fancybox").fancybox({
		//alert("Gallery image clicked");
		 'scrolling'   : 'no',
		openEffect	: 'elastic',
		closeEffect	: 'elastic'
		 
		});
		
		$("#my-story").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,		
	});
		
		$("#tip5").fancybox({
		   'width'  : 700,
            'height'  : '700',
            'easingIn'  : 'swing',
            'transitionOut' : 'elastic',
			'titleFormat': null
		});
		
 		
		$(".fancybox123").fancybox({
			'beforeClose': function() { $('#videocontent').html(""); },
			'scrolling'  : 'no',
			'closeClick': false 
			
			 });

});


</script>

  


<!-- Sweet Menu (Archives, My Tag Notes, MyFlipwear) end -->

<script type="text/javascript">
    
function closefrommenu(page)
{
 
	
	//alert("Calling");
	if(page=="main")
	{
		
		//alert("main");
		$('#singleviewfinao').hide();
		$('#viewallfinaos').show();
		$('#hidecover').show();
		$('.fixed-image-slider').css({'height':'70'});
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
		$('.active-category').removeClass('active-category');
	
	}
	else if(page == "finao")
	{
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
	}
	else
	{ 
	  
		//alert("Hello");
		$('.finao-cover-new').show();
		$('#singleviewfinao').hide();
		$('#viewallfinaos').show();
		$('#hidecover').show();
		$('.fixed-image-slider').css({'height':'70'});
		hidealldivs();
		clickvalue = $(".active-category").attr("rel");
		$("#allinfo").show();
		if(clickvalue == 'tiles')
		{
			selectetileid = $("#usertileid").val();
			if(selectetileid != "")
				getdetailtile(userid,selectetileid);
			else
				$(".active-category").trigger("click");	
		}
		else 
		{
			$(".active-category").trigger("click");
		}
	
	}
	
}

        $(document).ready(function() {

         /*   $(".dropdown img.flag").addClass("flagvisibility");



            $(".dropdown dt a").click(function() {

                $(".dropdown dd ul").toggle();

            });

                        

            $(".dropdown dd ul li a").click(function() {

                var text = $(this).html();

                $(".dropdown dt a span").html(text);

                $(".dropdown dd ul").hide();

                $("#result").html("Selected value is: " + getSelectedValue("sample"));

            });

                        

            function getSelectedValue(id) {

                return $("#" + id).find("dt a span.value").html();

            }



            $(document).bind('click', function(e) {

                var $clicked = $(e.target);

                if (! $clicked.parents().hasClass("dropdown"))

                    $(".dropdown dd ul").hide();

            });





            $("#flagSwitcher").click(function() {

                $(".dropdown img.flag").toggleClass("flagvisibility");

            }); */

        });

    </script>

	<script type="text/javascript">

	function lookup(inputString,divsuggestid,divautosugglistid,targetController) { 

		if(inputString.length == 0) {

			// Hide the suggestion box.

			$("#"+divsuggestid).hide();

		} else { 

					urlinfo = 'site/Populatedata';

					stateval = "";

					citival = "";

					schoolval = "";

					orgval = "";

					tagval = "";

					//schdistrictval = "";

					

					if($("#txtsearchstate").length)					

						stateval = ($("#txtsearchstate").val().toLowerCase() != 'state') ? $("#txtsearchstate").val() : "" ;

					if($("#txtsearchcity").length)

						citival = ($("#txtsearchcity").val().toLowerCase() != 'city') ? $("#txtsearchcity").val() : "" ;

					if($("#txtsearchschool").length)

						schoolval = ($("#txtsearchschool").val().toLowerCase() != 'school') ? $("#txtsearchschool").val() : "" ;				

					if($("#tags").length)

						tagval = ($("#tags").val().toLowerCase() != 'tags') ? $("#tags").val() : "" ;							//Added for activity finder on 07012013					

					if($("#txtsearchorg").length)

						orgval = ($("#txtsearchorg").val().toLowerCase() != '') ? $("#txtsearchorg").val() : "" ;	 //, schooldistrict : ""+schdistrictval+""

					//Ended on 07012013		

					//alert(urlinfo);

				    var url='<?php echo Yii::app()->createUrl("'+urlinfo+'"); ?>';

					$.post(url, {queryString: ""+inputString+"",targetControl: ""+targetController+"" , state: ""+stateval+"" , city: ""+citival+"", school : ""+schoolval+"" , org : ""+orgval+""  }, function(data){ //alert(data);

						if(data.length >0) { 

							//$('#suggestions').show();

							$("#"+divsuggestid).show();

							$('#'+divautosugglistid).html(data);

							setTimeout(function() {

        							$("#"+divsuggestid).hide();

    						}, 6000);

						}

					});

		} 

	} // lookup



	function lookupActivity(inputString,divsuggestid,divautosugglistid,targetController,targetid) { 

		if(inputString.length == 0) {

			// Hide the suggestion box.

			$("#"+divsuggestid).hide();

		} else { 

					urlinfo = 'site/Populatedata';
					emailval = ""; // Added on 29-01-2013 for search the people in FINAO
					tileval = ""; 

					
					if($("#searchemail").length)
						emailval = ($("#searchemail").val().toLowerCase() != 'search people') ? $("#searchemail").val() : "";
					if($("#searchtile").length)
						tileval = ($("#searchtile").val().toLowerCase() != 'search tile') ? $("#searchtile").val() : "";

					
					// Ended on 29-01-2013

				    var url='<?php echo Yii::app()->createUrl("'+urlinfo+'"); ?>';

					$.post(url, {queryString: ""+inputString+"",targetControl: ""+targetController+"" , targetid : ""+targetid+"", useremail : ""+emailval+"" , usertile : ""+tileval+"" }, function(data){ //alert(data);

						if(data.length >0) { 

							//$('#suggestions').show();

							$("#"+divsuggestid).show();

							$('#'+divautosugglistid).html(data);

							$("#"+divsuggestid).mouseover(function() {

						            $("#"+divsuggestid).show();

						        });

							$("#"+divsuggestid).mouseout(function() {

                        			$("#"+divsuggestid).hide();

                     		});

						}

					});

		} 

	}// lookup
	
	function fill(thisValue,targetid,suggestid) {

		$('#'+targetid).val(thisValue);

		//setTimeout("$('#"+suggestid+"').hide()", 200);

		$("#search-submit").trigger("click");

	}

	

	function checkValidate(targetPageName)

	{

		if(targetPageName == 'searchemail')

		{

			if($("#searchemail").val()== "Search People")

			{

				//alert("Please Enter Name to search the contact");

				$("#no-data").show();

				setTimeout("$('#no-data').hide()", 5000);

				return 'false';

			}

			else

				return 'true';

			//retValue = ($("#searchemail").val().toLowerCase() != 'Search People') ? 'true' : 'false' ;

		}

		

	}

//Added on 20032013-For skipping the screen

function skipdetails(controller){

	var action = controller+'/isSkip';

	var url='<?php echo Yii::app()->createUrl("'+action+'"); ?>';

	var skip = "skipped";

	$.post(url,{skip:skip},

	 function(data){

	   //$("#rotatetabs").html(data);

	   if(data=="newfinao")

	   {

			var url1 = "<?php echo Yii::app()->createUrl('/finao/motivationmesg/newfinao/##id');?>";	

			url = url.replace('##id','newfinao');

			window.location = url1;

	   }

	   else if(data=="motivationmesg")

	   {

	   		var url2 = "<?php echo Yii::app()->createUrl('/finao/motivationmesg');?>";

			window.location = url2;

	   }

	   else if(data=="not skipped")

	   {

	   		$("#mesg").text("Add FINAO cannot be skipped due to some reasons ");

	   }

	   });

}	

//Ended on 20032013-For skipping the screen	

</script>

</head>





<body>

<!--This div is added for displaying finao video gallery in user Dashboard-->
<div id="inline1" style="display: none;">
<div id="videocontent" class="popup-video-display">
</div>
</div>
<!--This div is added for displaying finao video gallery in user Dashboard ends-->
<div style="display:none;">
<div style=" width:800px;">
	<form id="login_form" method="post" action="">	
		<h3 class="orange" id="succ" align="center">Change Password</h3>
		<table width="100%" border="0" cellpadding="5" cellspacing="0" id="login_forms">
		  <tr>
			<td colspan="3"><p class="forgot-error-msg red" id="login_error"></p></td>
		  </tr>
		  <tr>
			<td>Enter Old Password <span class="red">*</span></td>
			<td>:</td>
			<td><input type="password" class="textbox" id="old_password" onchange="return check_password();" /></td>
		  </tr>
		  <tr><td>Enter New Password <span class="red">*</span></td><td>:</td><td><input type="password" class="textbox" id="news_password" /></td></tr><tr><td>Re Enter New Password <span class="red">*</span></td><td>:</td><td><input class="textbox" type="password" id="new_confirm_password" /></td></tr><tr>
		  <td colspan="3"><input type="button" value="Save" style="margin-left:166px;" class="orange-button" id="password_submit" onclick="return change_password();" />&nbsp;&nbsp;&nbsp;<input type="button" value="Reset" class="orange-button" onclick="formReset();" /></td></tr>
		  
		</table>	
	</form></div>
</div>

<!-- BG image change -->





<script type="text/javascript">

	/*var backimage = "<?php echo $this->getBgimagepath(); ?>";

	$(function(){

		 $('#bgimg').attr('src', backimage);		

	});*/

</script>



<!--<div id="bg_grid"></div>-->

<div><!--<img src="" id="bgimg" class="bg" />--></div>





<?php /*$userid = Yii::app()->session['login']['id'];

$iscompleted = UserFinao::model()->findByAttributes(array('userid'=>$userid,'Iscompleted'=>1));

if(isset($iscompleted) && !empty($iscompleted)){?>

<div class="wrap">

<div id="slick-2">

<p><a onclick="showCompletedFInaos(<?php echo $userid;?>)"><h3>Completed FINAO'S</h3></a></p>

</div>

</div>

<?php }*/?>

<input  type="hidden" value="<?php echo Yii::app()->session['login']['id']; ?>" id="borderckeckid"/>



 <div class="header-home" style="height:80px!important;">

        <div class="logo-area"><a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/logo2.png" title="FINAO NATION" width="180" /></a></div>

        <div class="search-area">

            <span class="settings">

			<?php

    				if(isset(Yii::app()->session['login'])){

				?>	
					<?php //if(isset(Yii::app()->session['login']['profImage']) && Yii::app()->session['login']['profImage']!="" ){

						//$src = Yii::app()->baseUrl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];
						if(Yii::app()->session['login']['profImage']!='')
						{
							$src = Yii::app()->baseUrl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];
						}
			 		else{

			 			$src = Yii::app()->baseUrl."/images/no-image.jpg";

			  		}?>
					

    				<div class="messages">

                		<ul id="menu">

                    	<li>

							<a href="javascript:void(0);" class="drop">

							<?php /*?><img src="<?php echo $this->cdnurl; ?>/images/home/settings.png" width="50" /><?php */?>	
							<img src="<?php echo $src;?>"  width="26" height="26" style="margin-top:4px;" class="image-border"  />							</a><!-- Begin Home Item -->

	                        <div class="dropdown_2columns align_right"><!-- Begin 2 columns container -->

	                    		<div class="col_2" style="padding-bottom:10px;">

	                                <a class="menu-link" href="<?php echo Yii::app()->createUrl('profile/profilelanding/edit/1'); ?>">

									<img src="<?php echo $this->cdnurl; ?>/images/edit-profile.png" width="16" style="float: left;margin-right: 4px;" />Manage your Profile</a>

	                            </div>
                                <?php  if(Yii::app()->session['login']['socialnetworkid']=='0' or Yii::app()->session['login']['socialnetworkid']=='1'){?>
								<div class="col_2">

	                            	<a class="menu-link tip5" href="#login_form" id="tip5">

									<img src="<?php echo $this->cdnurl; ?>/images/changepassword.png" width="16" style="float: left;margin-right: 4px;" /> Change Password</a>     

	                            </div>
							<?php }?>

	                   			<div class="col_2" style="padding-bottom:0;">

	                            	<a class="menu-link" href="<?php echo Yii::app()->createUrl('site/logout'); ?>">

									<img src="<?php echo $this->cdnurl; ?>/images/signout.png" width="16" style="float: left;margin-right: 4px;" /> Sign Out</a>     

	                            </div>

	                        </div><!-- End 2 columns container -->

                    </li>

                	</ul>

            	</div>

				
				<?php /*?><div class="messages">

                		<ul id="menu">

                    	<li>

							<a href="#" class="drop">

							<img src="<?php echo $this->cdnurl; ?>/images/home/settings.png" width="50" />							</a><!-- Begin Home Item -->

	                        <div class="dropdown_2columns align_right"><!-- Begin 2 columns container -->

	                    		<div class="col_2" style="padding-bottom:10px;">

	                                <a class="menu-link" href="<?php echo Yii::app()->createUrl('profile/profilelanding/edit/1'); ?>">

									<img src="<?php echo $this->cdnurl; ?>/images/edit-profile.png" width="16" style="float: left;margin-right: 4px;" />Manage your Profile</a>

	                            </div>

	                   			<div class="col_2" style="padding-bottom:0;">

	                            	<a class="menu-link" href="<?php echo Yii::app()->createUrl('site/logout'); ?>">

									<img src="<?php echo $this->cdnurl; ?>/images/signout.png" width="16" style="float: left;margin-right: 4px;" /> Sign Out</a>     

	                            </div>

	                        </div><!-- End 2 columns container -->

                    </li>

                	</ul>

            	</div><?php */?>

        	<!--<a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="icon-signout"><img src="<?php echo $this->cdnurl; ?>/images/signout.png" title="Sign Out" /></a>-->

        		

        		<div style="clear:right;"></div>

					

						</span>

						<script type="text/javascript">
						
						// Added And Updated By Manoj on 19/3/2013 for auto refresh of notification content
						$(document).ready(function(){
						    //alert("Hello");
							$('#notification').load("<?php echo Yii::app()->createUrl('/tracking/notifications');?>");
							var notification = setInterval(function(){
						   //alert("refreshed");
							$('#notification').load("<?php echo Yii::app()->createUrl('/tracking/notifications');?>");
							}, 10000); // refresh every 10000 milliseconds
							
							
							
							/*$(window).load("<?php echo Yii::app()->createUrl('/finao/checkvideostatus');?>");
							var check = setInterval(function(){
						   //alert("refreshed");
							$(window).load("<?php echo Yii::app()->createUrl('/finao/checkvideostatus');?>");
							}, 5000); // refresh every 10000 milliseconds*/
						});	
						</script>

				<div id = "notification">

           		</div>

				<?php

						}?>

                        <span style="position:absolute; right:150px; top:2px;">

					 <?php if(isset(Yii::app()->session['login'])){?>

					<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg');?>">

					<?php if(isset(Yii::app()->session['login']['profImage']) && Yii::app()->session['login']['profImage']!="" ){

						$src = Yii::app()->baseUrl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];
						if(!file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".Yii::app()->session['login']['profImage']))
						{
							
						}
			 		}else{

			 			$src = Yii::app()->baseUrl."/images/no-image.jpg";

			  		}?>
					<?php //print_r($src); ?>
					
    				<?php /*?><img src="<?php echo $this->getProfilePic();?>" width="25" height="25" class="image-border" style="margin-right:6px;" />			<?php */?>	
					<img src="<?php echo  Yii::app()->baseUrl.'/images/icon-home.png'; ?>" width="25" height="25" style="margin-right:6px;" />					

					<?php } ?>

					</a>

					

					</span>

            <span class="right" style="margin-right:200px; margin-top:3px;">

			<?php if(isset(Yii::app()->session['login'])){$this->widget('NetworkSearch',array('homepage'=>'homepage')); } ?>

			</span>

            

        </div>

		<?php

    				if(isset(Yii::app()->session['login'])){

					

		$passuser = Yii::app()->session['login']['id']; ?>

		<!--<a onclick="showtracking(<?php echo $passuser;?>)">TRACKING</a>

							<a onclick="showsearching(<?php echo $passuser;?>)">SEARCH</a>-->

		<?php }?>

</div>

<?php echo $content; ?>



<div id="footer">

    <div class="footer-left">

     <a href="<?php echo Yii::app()->createUrl('profile/aboutus'); ?>">About FINAO</a> |

     <!--<a href="<?php //echo Yii::app()->createUrl('profile/landing'); ?>">Explore FINAO</a> |-->
       <?php /*?> <a href="<?php echo Yii::app()->createUrl('profile/landing'); ?>">Explore FINAO</a> |<?php */?>
        <a href="<?php echo Yii::app()->createUrl('profile/finaogives'); ?>">FINAO Gives</a> |

     <a  href="<?php echo Yii::app()->createUrl('profile/faq'); ?>">FAQ</a> |

        <!--<a  href="<?php echo Yii::app()->createUrl('profile/grouppurchase'); ?>">Group Purchase</a> |-->

        <a  href="<?php echo Yii::app()->createUrl('profile/terms'); ?>">Terms of Use</a> |

  <a  href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>">Privacy Policy</a> |

        <a  href="<?php echo Yii::app()->createUrl('profile/contactus'); ?>">Contact Us</a>

    </div>

    <div class="footer-right">

     <!--<span class="follow-me">Follow Us On:</span>-->

     <ul>

            <a href="https://www.facebook.com/FINAONation" target="_blank"><li class="facebook">&nbsp;</li></a>

            <a href="http://www.linkedin.com/company/2253999" target="_blank"><li class="linkedin">&nbsp;</li></a>

             <a href="http://pinterest.com/finaonation/" target="_blank"><li class="pinterest">&nbsp;</li></a>

            <a href="https://twitter.com/FINAONation" target="_blank"><li class="twitter">&nbsp;</li></a>

       </ul>

    </div>

    <div class="clear"></div>

    <div class="copyrights">&copy; 2013, JoMoWaG, LLC</div>

</div>
<script type="text/javascript">



function finduser(id)

{

	var tiledata = id;

	var url='<?php echo Yii::app()->createUrl("/tracking/tiletracking"); ?>';

 	$.post(url,{tiledata : tiledata},

   		function(data){

   			//alert(data);

				$("#finaoform").hide();

				$("#finaodiv").hide();

				$("#searchdiv").hide();

				$("#journaldiv").hide();

				$("#searchshowdiv").html(data);

				$("#searchshowdiv").show();

				document.getElementById('backbutton').style.display = "block";

     });

		

}

function showtracking(userid)

{

	$("#divfinaowidget").hide();

	hidealldivs();

	$("#trackingstatus").hide();

	$("#journaldiv").hide();

	$("#followtracking").show();

	$("#profiletracking").show();

	$("#statusclass").removeClass();

	$("#statusclass").addClass("finao-work-space");

	//refreshwidget(userid);

		

}function showsearching(userid)

{

		$("#divfinaowidget").hide();

		hidealldivs();

		$("#trackingstatus").hide();

        $("#searchdiv").show();

		$("#statusclass").removeClass();

		$("#statusclass").addClass("finao-work-space");

		//refreshwidget(userid);

}



function showusers(id)

{

		document.getElementById('trackinguser-'+id).style.display = "block";

		document.getElementById('minusimg-'+id).style.display = "block";

		document.getElementById('plusimg-'+id).style.display = "none";

}

function hideusers(id)

{

	document.getElementById('trackinguser-'+id).style.display = "none";

	document.getElementById('plusimg-'+id).style.display = "block";

	document.getElementById('minusimg-'+id).style.display = "none";

}

function showuserss(id)

{

		document.getElementById('trackinguserr-'+id).style.display = "block";

		document.getElementById('minusimgg-'+id).style.display = "block";

		document.getElementById('plusimgg-'+id).style.display = "none";

}

function hideuserss(id)

{

	document.getElementById('trackinguserr-'+id).style.display = "none";

	document.getElementById('plusimgg-'+id).style.display = "block";

	document.getElementById('minusimgg-'+id).style.display = "none";

}

function showhideusers(id,clickparam,track){

	if(clickparam.indexOf("plus") != -1){

		document.getElementById(track+'-'+id).style.display = "block";

		document.getElementById('minusimgg-'+id).style.display = "block";

		document.getElementById(clickparam).style.display = "none";

	}else{

		document.getElementById(track+'-'+id).style.display = "none";

		document.getElementById('plusimgg-'+id).style.display = "block";

		document.getElementById(clickparam).style.display = "none";

	}

}

function showhideuserstracking(id,clickparam,track){

	if(clickparam.indexOf("plus") != -1){

		document.getElementById(track+'-'+id).style.display = "block";

		document.getElementById('minusimg-'+id).style.display = "block";

		document.getElementById(clickparam).style.display = "none";

	}else{

		//alert(clickparam);

		document.getElementById(track+'-'+id).style.display = "none";

		document.getElementById('plusimg-'+id).style.display = "block";

		document.getElementById(clickparam).style.display = "none";

	}

}


function goback()

{

				$("#finaoform").hide();

				$("#finaodiv").hide();

				$("#searchdiv").show();

				$("#journaldiv").hide();

				$("#searchshowdiv").hide();

}

function notificationcount()

{

	// Function Added By Manoj On 19/3/2013

	var url='<?php echo Yii::app()->createUrl("/tracking/notifications"); ?>';

 	$.post(url, 

   		function(data){

		//alert(data);

				$("#notification").html(data);

		});

}

function accepttile(id,userid)

{

	 var tileid = id;
	//var tracker = document.getElementById('tracker').value;
	 var tracker = userid; 

	var url='<?php echo Yii::app()->createUrl("/tracking/acceptTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , tracker : tracker},

   		function(data){
		
		$("#reject-"+tileid+"-"+tracker).hide();
        $("#accept-"+tileid+"-"+tracker).html(data);

		});

	//alert("ACCEPT");

}

function rejecttile(id,userid)

{

	var tileid = id;

	//var tracker = document.getElementById('tracker').value;

	var tracker = userid;

	var url='<?php echo Yii::app()->createUrl("/tracking/rejectTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , tracker : tracker},

   		function(data){

		//alert(data);

				$("#reject-"+tileid+"-"+tracker).html(data);

				$("#accept-"+tileid+"-"+tracker).hide();

		});

}

function checknotificationcount(id)

{

	var userid = id;

	var url='<?php echo Yii::app()->createUrl("/tracking/counttiles"); ?>';

 	$.post(url, { userid :  userid },

   		function(data){

		//alert(data);

				$("#countdiv").html(data);

		});

}
 
function getprevfinao(pageid , userid, type, tileid , iscompleted,groupid)

{
	var groupid = document.getElementById('groupid').value;
	
	var update = document.getElementById('isheroupdate');
	if(update != null && update.value != "")
		heroupdate = update.value;
	else
		heroupdate = "";
	var isshare = document.getElementById('isshare').value;
	if(tileid==0 && iscompleted == 0 )

	{

		var loggeduserid = document.getElementById('loggeduserid');
		if(loggeduserid != null)
			loggeduserid = loggeduserid.value;
		else
			loggeduserid = "";
		
		if(heroupdate != "")
		{
			location.href='<?php echo Yii::app()->createUrl("/finao/motivationmesg"); ?>';
		}
		if(userid != loggeduserid)
		{
			var url = '<?php echo Yii::app()->createUrl("/finao/motivationmesg/frndid/##id"); ?>';
			url = url.replace('##id',userid);
			window.location.href=url;
		}
		else if(isshare=="share")
		{
			
			var url = '<?php echo Yii::app()->createUrl("/finao/motivationmesg/frndid/##id/share/1"); ?>';
			url = url.replace('##id',userid);
			window.location.href=url;
		}
		else
		{
			location.href='<?php echo Yii::app()->createUrl("/finao/motivationmesg"); ?>';
		}

	}
	
	var url='<?php echo Yii::app()->createUrl("/finao/getFinaoMessages"); ?>';
	
	/****** Please remove this code is heroupdate is not working *************/
	if(iscompleted == "completed")
		heroupdate = "";
	/****** Please remove above code is heroupdate is not working *************/	
	
	$.post(url, { pageid :  pageid , userid : userid , type : type , tileid : tileid , iscompleted : iscompleted , share : isshare,heroupdate:heroupdate,groupid:groupid },

   		function(data){

   			//alert(data);

			if(data)

			{  //alert(finaoid);
						

				if(iscompleted=="completed")

				{
				//var finaoid=$('#next').val();
			
				//view_single_finao(userid,finaoid);

					hidealldivs();
					$("#divdisplaydata").hide();
					$("#showcompletedfinaodiv-profile").show();

					$("#showcompletedfinaodiv-profile").html(data);

					$("#showcompletedfinaodiv-default").show();

					$("#showcompletedfinaodiv-default").html(data);

				}

				else

				{	
				
					$('.fixed-image-slider').css({'height':'70'});
					$('#hidecover').hide();
					hidealldivs();
					$("#divdisplaydata").hide();
					$("#finaodiv").show();

					$("#finaoform").show();

					$("#finaomesgsdisplay").html(data);

					getTrackStatus(userid,tileid);

				}

				

			}

			

     });
	 view_single_finao(userid,finaoid);
	 
}

function showCompletedFInaos(userid,finaoid){

	var iscompleted = "completed";
 	var groupid = document.getElementById('groupid').value;
 	var url='<?php echo Yii::app()->createUrl("/finao/getFinaoMessages"); ?>';
 	$.post(url, {iscompleted : iscompleted, userid : userid, finaoid:finaoid,groupid:groupid},
   		function(data){

   			//alert(data);

			if(data)
 			{ 

				$('.finao-cover-new').hide();
				$("#statusclass").removeClass();

				$("#statusclass").addClass("finao-work-space");

				$("#divfinaowidget").show();

				hidealldivs();
				$("#divdisplaydata").hide();
				document.getElementById('iscompleted').value = "completed";

				//refreshwidget(userid);

				$("#showcompletedfinaodiv-profile").show();

				$("#showcompletedfinaodiv-profile").html(data);

				$("#showcompletedfinaodiv-default").show();

				$("#showcompletedfinaodiv-default").html(data);
				
				view_single_finao(userid,finaoid); 

			}

			

     });

	

}

function getalljournals(id,userid,iscompleted,pageid)

{

	//alert(id);

	//alert(userid);

	//$("#getalljournals-"+id).trigger("click");
	var update = document.getElementById('isheroupdate');
	if(update != null && update.value != "")
		heroupdate = update.value;
	else
		heroupdate = "";

	var isshare = document.getElementById('isshare').value;
	
	var tileid = document.getElementById('selectedtile').value;

	var url='<?php echo Yii::app()->createUrl("/finao/allJournals"); ?>';

 	$.post(url, { finaoid : id, userid : userid, iscompleted : iscompleted,isshare:isshare,pageid:pageid,heroupdate:heroupdate},

   		function(data){

   			//alert(data);

			if(data)

			{
				/*if(isshare=="share")
				{*/
					//$("#journaltrackingstatus").show();
					//getTrackStatus(userid,tileid);
				/*}*/

				if(iscompleted=="completed")

				{
					hidealldivs();
					$("#showcompletedfinaodiv-profile").show();

					$("#showcompletedfinaodiv-profile").html(data);

					$("#showcompletedfinaodiv-default").show();

					$("#showcompletedfinaodiv-default").html(data);

					$("#finaodiv").hide();

					$("#journaldiv").show();

					$("#journaldiv").hide();

				}

				else

				{
					hidealldivs();
					$("#finaodiv").hide();

					$("#journaldiv").show();

					$("#journaldiv").html(data);

				}

				

			}

			

     });

}

function statusborder()

{

	

	var statusid = 	document.getElementById('statusid').value;

	var isshare = 	document.getElementById('isshare').value;

	var userid = 	document.getElementById('userid').value;

	var borderckeckid = 	document.getElementById('borderckeckid').value;

/*	alert(isshare);

	alert(userid);*/

	if(isshare == "share" || userid != borderckeckid)

	{

		if(statusid=="Ahead")

	{

		$("#statusclass").removeClass();

		$("#statusclass").addClass("finao-work-space border-ahead");

	}

	else if(statusid=="On Track")

	{

		$("#statusclass").removeClass();

		$("#statusclass").addClass("finao-work-space border-ontrack");

	}

	else 

	{

		//alert(statusid);

		$("#statusclass").removeClass();

		$("#statusclass").addClass("finao-work-space border-behind");

	}

	}

	 

}

function getDetails(imageorvideo,userid,finaoid,page)

	{

		//alert("imagetest");

		if($("#dispfinaotileid").length)

			tileid = $("#dispfinaotileid").val();

		else

			tileid = 0;	

		// Added on 28-03-2013 for back to finaos link

		var pageid = document.getElementById('finaopageid');

		if(pageid != null)

		{

		    var finaopageid = document.getElementById('finaopageid').value;

		}

		else

			finaopageid = 0; 

		// Ended here

		var completed = document.getElementById('iscompleted');

		if(completed!=null)

			var iscompleted = completed.value;

		else

			var iscompleted = "";

		//	alert(iscompleted);
		
		var update = document.getElementById('isheroupdate');
		if(update != null && update.value != "")
			heroupdate = update.value;
		else
			heroupdate = "";

		var url='<?php echo Yii::app()->createUrl("/finao/getDetails"); ?>';

		$.post(url, { tileid :  tileid , imageorvideo : imageorvideo, userid:userid , finaoid:finaoid , finaopageid : finaopageid ,iscompleted : iscompleted , pagetype : page,heroupdate:heroupdate},

   		function(data){

   			if(data)

			{

				//alert(data);

				if(page=="tilepage")

				{

					hidealldivs();

					$("#divImgVid").show();

					$("#divImgVid").html(data);

				}

				else if(page=="finaopage")

				{

					$("#finaoimages").show();

					$("#finaoimages").html(data);

				}

				else if(page=="journalpage")

				{

					$("#Default4").hide();

					$("#journalimages").show();

					$("#journalimages").html(data);

				}

			}

			

     	});

	}

	function getprevImgVid(pageid ,groupid, userid, type, tileid, imageorvideo,pagetype,finaoid,journalid)

	{ 
		 if(groupid !='')
		 {
			 var groupid = groupid;
		 }else
		 {
			 groupid = '';
		 }
		var update = document.getElementById('isheroupdate');
		if(update != null && update.value != "")
			heroupdate = update.value;
		else
			heroupdate = ""; 

		var url='<?php echo Yii::app()->createUrl("/finao/getDetails"); ?>';

		$.post(url, { pageid :  pageid , userid : userid , type : type , tileid : tileid , imageorvideo : imageorvideo , pagetype : pagetype, finaoid: finaoid ,heroupdate:heroupdate , journalid : journalid,groupid:groupid },

	   		function(data){
				if(data)
				{
					//alert(data);
					
					if(pagetype=="tilepage")
					{
						$("#divImgVid").show();
						$("#divImgVid").html(data);
					}
					else if(pagetype=="finaopage")
					{
						if(journalid != 0)
						{
							$("#finaoimagesjournal").show();
							$("#finaoimagesjournal").html("");
							$("#finaoimagesjournal").html(data);
						}
						else
						{
							$("#finaoimages").show();
							$("#finaoimages").html("");
							$("#finaoimages").html(data);	
						}
					}
					 

				}
	     });

	}

	function refreshwidget(userid)
	{
		var url='<?php echo Yii::app()->createUrl("/finao/refreshwidget"); ?>';
		var isshare = document.getElementById('isshare');
		//Added on 02-04-2013 for displaying tiles strip correctly for friends id
		var frnduserid = document.getElementById('profileuserid');
		if(isshare != null)
			share = isshare.value;
		else
			share = "";
		if(frnduserid != null)
		{
			share = "share";
		}

		// Ended here
		$.post(url, {islocalcall:0, userid : userid , isshare : share},
	   		function(data){
	   			//alert(data);
				if(data)
				{
					//hidealldivs();
					//$("#motivationmesg").show();
					$("#tileswidget").html(data);
				}
	     });
	}

function getprofile(userid)

{

	var url='<?php echo Yii::app()->createUrl("/profile/viewProfile"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#leftprofile").html(data);

			}

		});

}

function gettracking(userid)

{

	var url='<?php echo Yii::app()->createUrl("/tracking/viewTracking"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#lefttracking").html(data);

			}

		});

}

function getallstatus(userid)

{

	var url='<?php echo Yii::app()->createUrl("/finao/viewAllStatus"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  			//alert(data);

			if(data)

			{

				//$("#leftallstatus").show();

				$("#leftallstatus").html(data);

			}

		});

}

 function createfinao(userid,groupid)

 { //alert(userid); alert(groupid);   
   var userid=""; var url ="";

		var userid =  <?php echo  Yii::app()->session['login']['id']?>;

		var url = '<?php echo Yii::app()->createUrl("finao/addNewFinao");?>';

		$.post(url, { userid : userid,groupid:groupid},

		function(data){

		if(data)

		{
			if(groupid != 0)
			{
				/*$('.fixed-image-slider').css({'height':'430'});
				$('#hidecover').hide();*/
			}   

		//hidealldivs();

		$('#finaofeed').hide();
		$("#allinfo").show();

		$("#divdisplaydata").html("");

		$("#divdisplaydata").html(data);

		$("#divdisplaydata").show();

		}

		});

 }
 
 function getvideostatus(finaoid)
 {
	 //alert(finaoid);//CheckVideoStatus
	 
	    var userid =  <?php echo  Yii::app()->session['login']['id']?>;

		var url = '<?php echo Yii::app()->createUrl("finao/CheckVideoStatus");?>';

		$.post(url, { userid : userid,finaoid:finaoid},

		function(data){

		if(data)

		{ 
		 //alert(data) 
		if(data == 1)
		{
			refreshmenucount(userid);
		}  

		/*hidealldivs();

		$('#finaofeed').hide();
		$("#allinfo").show();

		$("#divdisplaydata").html("");

		$("#divdisplaydata").html(data);

		$("#divdisplaydata").show();*/

		}

		});
 }
 
  function Checkfiles()
    {
        var fup = document.getElementById('filename');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

    if(ext =="GIF" || ext=="gif")
    {
        return true;
    }
    else
    {
        alert("Upload Gif Images only");
        return false;
    }
    }
	
	function getheroupdate()
	{
	var update = document.getElementById('isheroupdate');
	if(update != null)
	update.value = "heroupdate";
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
	
	
	
	
	
	/*Group Script Start Here */
	
	function creategroup(groupid,edit)
	{
		url='<?php echo Yii::app()->createUrl("Group/createGroup");?>';
		$.post(url, { userid : userid,edit:edit,groupid:groupid },
		function(data){
		if(data)
		{
		//alert(data);	
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").html("");
		$("#divdisplaydata").html(data);
		$("#divdisplaydata").show();
		}
		});
		$('#create_grou').hide();
		 
	}
	
function check_password()
{
if($('#old_password').val().length >=6 )
{
var pwd=$('#old_password').val();
var url='<?php echo Yii::app()->createUrl("/site/validPassword"); ?>';
$.post(url,{cpwd : pwd},function(data){
if(data=='Password is correct')
{
	$('#login_error').hide();
}
else { $('#login_error').html(data); $('#login_error').show();}		
});
}
}
function change_password()
{
var pwd=$('#old_password').val();
if(pwd !='')
{
	var url='<?php echo Yii::app()->createUrl("/site/validPassword"); ?>';
	$.post(url,{cpwd : pwd},function(data){
	if(data=='Password is correct')
	{
		var news=$('#news_password').val(); var newc=$('#new_confirm_password').val();
		//alert(news.length);alert(newc.length);
		if(news.length >=6 && newc.length >=6  && news == newc )
		{
			var pwd=$('#news_password').val();
			var url='<?php echo Yii::app()->createUrl("/site/changePassword"); ?>';
			$.post(url,{npswd : pwd},function(data){$('#succ').html('Password Changed Successfully');	$('#login_forms').hide();});					
		}
		else
		{
			$('#login_error').html('Passwords should be same and more than 6 characters ');$('#login_error').show();return false;
		}
	}
	else { $('#login_error').html('Re-enter New Password');$('#login_error').show(); }		
	});	
}
else 
{
	$('#login_error').html('Please Enter Old Password');$('#old_password').focus();$('#login_error').show();return false;
}	
}
function formReset()
{
document.getElementById("login_form").reset();$('#login_error').hide();
}

	
	/*Group Script Ends Here */
	
	

</script> 



</body>

</html>
