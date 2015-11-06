<script>

$(document).ready(function(){



	// hide #back-top first

	$("#back-top").hide();

	

	// fade in #back-top

	$(function () {

		$(window).scroll(function () {

			if ($(this).scrollTop() > 100) {

				$('#back-top').fadeIn();

			} else {

				$('#back-top').fadeOut();

			}

		});



		// scroll body to 0px on click

		$('#back-top a').click(function () {

			$('body,html').animate({

				scrollTop: 0

			}, 800);

			return false;

		});

	});



});

</script>

<style>

#back-top{position:fixed; top:400px; z-index:99; right:0px; bottom:0; }

a.back{margin-bottom: 7px; -webkit-transition: 1s; -moz-transition: 1s; -o-transition: 1s;  transition: 1s;}

#scroll-down{background:url(images/home/scrolldown.png) left top no-repeat; width:22px; height:18px; -webkit-animation: scroll_down .7s ease infinite; -moz-animation: scroll_down .7s ease infinite; animation: scroll_down .7s ease infinite; position:fixed; top:500px; right:15px;}

</style>

<body  id="top">

<p id="back-top"><a class="back" href="#top"><img src="<?php echo $this->cdnurl; ?>/images/home/backtop.png" width="150" /></a></p>



    <div class="main-container">

    	<div class="finao-canvas">

        	
			<div class="orange font-20px padding-10pixels"><span class="left">FAQ's</span> <span class="right"><a href="<?php echo Yii::app()->request->urlReferrer;?>"><img src="<?php echo $this->cdnurl; ?>/images/back.png" width="60" /></a></span></div>
            <div class="clear"></div>
        

        <div class="font-18px" style="margin-top:10px;">General</div>

        <div class="questions">

        	<ol>

            	<li class="orange font-14px"><a href="#quesss1" class="orange-link font-14px">What is a FINAO<sup>&reg;</sup>?</a></li>

            	<li class="orange font-14px"><a href="#quesss2" class="orange-link font-14px">What is my Dashboard?</a></li>

            	<li class="orange font-14px"><a href="#quesss3" class="orange-link font-14px">What is my Profile?</a></li>

            	<li class="orange font-14px"><a href="#quesss4" class="orange-link font-14px">What is a Tile?</a></li>

            	<li class="orange font-14px"><a href="#quesss6" class="orange-link font-14px">How do I track someone or let them track me?</a></li>

            	<li class="orange font-14px"><a href="#quesss7" class="orange-link font-14px">Why can't I comment on the FINAO<sup>&reg;</sup> of someone I'm tracking?</a></li>

            	<li class="orange font-14px"><a href="#quesss8" class="orange-link font-14px">Can I get a Profile for my team?</a></li>

            	<li class="orange font-14px"><a href="#quesss9" class="orange-link font-14px">What is a FINAO<sup>&reg;</sup> TagNote™?</a></li>

                <li class="orange font-14px"><a href="#quesss10" class="orange-link font-14px">What is FINAO<sup>&reg;</sup> NATION?</a></li>

            </ol>

        </div>

        

        <div class="font-18px">Customer Service</div>

        <div class="questions">

        	<ol>

            	<li class="orange font-14px"><a href="#quesss101" class="orange-link font-14px">Who do I contact if I have questions with an order?</a></li>

            	<li class="orange font-14px"><a href="#quesss102" class="orange-link font-14px">When will I receive my product?</a></li>

            	<li class="orange font-14px"><a href="#quesss103" class="orange-link font-14px">What is FINAO<sup>&reg;</sup>s Returns Policy?</a></li>

            	<li class="orange font-14px"><a href="#quesss104" class="orange-link font-14px">How am I notified if a product is placed on backorder?</a></li>

            	<li class="orange font-14px"><a href="#quesss105" class="orange-link font-14px">What if I do not receive my order?</a></li>

            	<li class="orange font-14px"><a href="#quesss106" class="orange-link font-14px">How do I purchase and send a gift to a family member?</a></li>

            </ol>

        </div>

        

        <div class="font-18px">Shopping</div>

        <div class="questions">

        	<ol>

            	<li class="orange font-14px"><a href="#quesss201" class="orange-link font-14px">How do I place an order?</a></li>

            	<li class="orange font-14px"><a href="#quesss202" class="orange-link font-14px">How do I ensure that I have ordered the right size garment?</a></li>

            	<li class="orange font-14px"><a href="#quesss203" class="orange-link font-14px">How do I track my order?</a></li>

            	<li class="orange font-14px"><a href="#quesss204" class="orange-link font-14px">How do you calculate shipping rates on orders?</a></li>

            	<li class="orange font-14px"><a href="#quesss205" class="orange-link font-14px">Are the colors portrayed on-line accurate with the product I will receive?</a></li>

            	<li class="orange font-14px"><a href="#quesss206" class="orange-link font-14px">Do I have to place my shipping and credit card information every time I purchase a garment or will this be stored?</a></li>

            </ol>

        </div>

        

        <div class="font-18px">Miscellaneous</div>

        <div class="questions">

        	<ol>

            	<li class="orange font-14px"><a href="#quesss301" class="orange-link font-14px">Does FINAO<sup>&reg;</sup> have retail stores?</a></li>

            	<li class="orange font-14px"><a href="#quesss302" class="orange-link font-14px">Where are the washing instructions of the garments listed?</a></li>

            	<li class="orange font-14px"><a href="#quesss303" class="orange-link font-14px">Can I place multiple orders (like for a team or group)? Do I have to enter each one individually using the website? Are there group/bulk order discounts?</a></li>

            	<li class="orange font-14px"><a href="#quesss304" class="orange-link font-14px">How many characters will be allowed on FINAO<sup>&reg;</sup> FlipWear<sup>&reg;</sup> garments? Can I change the font and/or size of the TagNote™?</a></li>

            	<li class="orange font-14px"><a href="#quesss305" class="orange-link font-14px">What type of imprinting is used for garments and accessories?</a></li>

            	<li class="orange font-14px"><a href="#quesss306" class="orange-link font-14px">Can I change the color schemes of the FINAO<sup>&reg;</sup> logo on my selected garment?</a></li>

            </ol>

        </div>

        

        <div class="orange font-14px padding-10pixels" id="quesss1">What is a FINAO<sup>&reg;</sup>?</div>

        <div class="content-run-text">A FINAO<sup>&reg;</sup> is your statement of what you want to achieve</div>

        <div class="content-run-text">Your FINAO<sup>&reg;</sup>s can be as short-term as "I will rush for 100 yards on Saturday night" to as long-term as "I will reach the summit of all major peaks in North America to as personal as "I will spend more quality time with my children in 2013".</div>

        <div class="content-run-text">Your FINAO<sup>&reg;</sup> is what you establish to aspire to. It needs to align with your passions and capabilities, not those expected of you by society. </div>

        

        <div class="orange font-14px padding-10pixels" id="quesss2">What is my Dashboard"?</div>

        <div class="content-run-text">Your "Dashboard" is your private area where you create your FINAO<sup>&reg;</sup>s and choose what you want to share with the rest of FINAO<sup>&reg;</sup> Nation. This is where you manage all of your FINAO<sup>&reg;</sup> activity in a secure and easy-to-navigate manner. Here are some of the things you can do in your Dashboard:</div>

        <ul class="answers">

        	<li>Create your custom FINAO<sup>&reg;</sup> Tiles by writing a FINAO<sup>&reg;</sup> and linking it to a specific interest tile</li>

            <li>Track the progress of your FINAO<sup>&reg;</sup> </li>

            <li>Add photos or videos to your FINAO<sup>&reg;</sup>s</li>

            <li>Keep a journal of your activity</li>

            <li>Choose to display any of your tiles and FINAO<sup>&reg;</sup> activity publicly, or keep it all to yourself</li>

            <li>Archive any FINAO<sup>&reg;</sup>s </li>

            <li>Publish your Canvas accomplishments to a Resume you can share with colleges or prospective jobs</li>

            <li>Edit the background photo of your "Share It" Profile Page </li>

            <li>Chose to track others FINAO<sup>&reg;</sup> Nation members</li>

            <li>Check your messages</li>

            <li>Review your Resources - these are products from select FINAO<sup>&reg;</sup> sponsors that can help you achieve your FINAO<sup>&reg;</sup>. These are specific to each tile. </li>

            <li>See who's tracking you and who you're tracking</li>

            <li>Review and manage your TagNotes<sup>TM</sup></li>

            <li>Update your connection to your Team Connects</li>

            <li>Invite a Mentor to help you achieve your FINAO<sup>&reg;</sup>s and view your mentors</li>

          </ul>

            

        <div class="orange font-14px padding-10pixels" id="quesss3">What is a Profile page?</div>

        <div class="content-run-text">Your Profile page displays your Tiles that you have chosen to share publicly.  Within your Profile, people will see:  </div>

        <ul class="answers">

            <li>The Tiles the FINAO<sup>&reg;</sup> is linked to</li>

            <li>All public FINAO<sup>&reg;</sup>s within the shared Tile</li>

            <li>Your FINAO<sup>&reg;</sup> progress</li>

            <li>Any photos or videos in your shared FINAO<sup>&reg;</sup>s</li>

            <li>Activity Journal of your progress toward achieving your FINAO<sup>&reg;</sup>s</li>

            <li>The status of the Tile activity  </li>

            <li>Your selected background photo </li>

            <li>Your Team Connects</li>

            <li>A Dashboard view of your Profile Stats </li>

        </ul>

        

        <div class="orange font-14px padding-10pixels" id="quesss4">What is a Tile?</div>

        <div class="content-run-text">A tile is one of the different interests you can select when creating each FINAO<sup>&reg;</sup> to help keep your FINAO<sup>&reg;</sup>s organized and on track. When you create a FINAO<sup>&reg;</sup>, select a tile to represent the related interests you have. Each Tile can include multiple unique FINAO<sup>&reg;</sup>s, photos, videos, stats, goals and tracking. Once selected and populated, you can chose to make any Tile public or at any time make it private again. Once public, the Tiles can be viewed on the Profile page.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss6">How do I track someone or let them track me? </div>

        <div class="content-run-text">Whenever you're viewing another members Profile page, there is a "Track" button at the top of their workspace. To track their FINAO<sup>&reg;</sup>s and progress, click the "Track" button. This will send a message to them to accept your request to track them. They can accept or deny the request.</div>

        <div class="content-run-text">When a member viewing your Profile page, clicks on the "Track Me" button, you will be sent a request message to allow them to track you. You can accept or deny the request.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss7">Why can't I comment on a FINAO<sup>&reg;</sup> of someone I am tracking? </div>

        <div class="content-run-text">The FINAO<sup>&reg;</sup> Nation is built on creating a platform for drama-free social media. It's a safe place where anyone can establish their goals and put their FINAO<sup>&reg;</sup> out to the world as declaration of "I will not fail, that is not an option."  It is not the public's role to pass judgment upon another's personal goals or efforts.</div>

        <div class="content-run-text">If you want to show support of someone's FINAO<sup>&reg;</sup>, view their videos, photos and journals. This will show activity to them. </div>

        <div class="content-run-text">If you disapprove or dislike their efforts, simply choose to quit tracking them.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss8">Can I create a Profile for my Team?</div>

        <div class="content-run-text">Teams, ranging from High School sports to bowling leagues to Little League Soccer clubs, may create a Team Profile Page with the purpose of managing the team's online activity. This is only available for official teams and must be approved by the FINAO<sup>&reg;</sup> Nation content managers. Submit this form to set up your Team Page.</div>

        <div class="content-run-text">The Coach/Manager will create the page and manage the content. Within each Team Page, there are multiple Tiles the Manager can select to make public. These include:</div>

        <ul class="answers">

            <li>Team Schedule</li>

            <li>Team Roster</li>

			<li>Team stats </li>

			<li>Coaches Journal</li>

			<li>Team FINAO<sup>&reg;</sup>s</li>

			<li>Booster support</li>

			<li>League Information</li>

			<li>Team FlipWear choices  </li>

        </ul>

        <div class="content-run-text">In addition to the web page, the team can create a team-branded FlipWear product for team members and supporters. A group purchase will be allowed through this channel whether paid individually or in a single transaction. </div>

        

        <div class="orange font-14px padding-10pixels" id="quesss9">What is a FINAO<sup>&reg;</sup> TagNote™?</div>

        <div class="content-run-text">A TagNote<sup>TM</sup> (QR Code) is the small box of random white and black squares printed inside your garment next to your FINAO<sup>&reg;</sup>. This graphic can be read with most smart phones with a QR reading app. (these are free to download).  The TagNote allows you to update your goal status or share situational information such as date, name, contact info, etc.. You can change the content of your TagNote<sup>TM</sup>  as often as you like, by logging into your profile on finaonation.com.</div>

        <div class="content-run-text">Examples of TagNote Content:</div>

        <div class="content-run-text">#1. Jon Wilkens, Sarah's Party July 4th 2012.  Phone number XXX-XXX-XXXX, Email JonW@XXXX.com</div>

        <div class="content-run-text">#2. Join me on the August 3 day cancer walk.  Get more information by contacting me at XXX-XXX-XXXX or visiting my walk site at www.JonW3day.com </div>

        

        <div class="orange font-14px padding-10pixels" id="quesss10">What is FINAO<sup>&reg;</sup> Nation?</div>

        <div class="content-run-text">FINAO<sup>&reg;</sup> Nation is an online community of members who have established a profile in www.finaonation.com. Each member can express and/or share their goals, messages, and aspirations. Our community portal allows friends and family members to share their FINAO<sup>&reg;</sup>s via our FINAO<sup>&reg;</sup> library as well as being linked to social networks such as Facebook and Twitter.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss101">Who do I contact if I have questions or issues with an order?</div>

        <div class="content-run-text">Please call 1-877-FIN-AO11 or send an email to askus@finaonation.com. FINAO<sup>&reg;</sup> customer service reps will answer your questions within one business day. Our goal is to provide each of our customers with a world-class experience.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss102">When will I receive my product?</div>

        <div class="content-run-text">Due to the personalized nature of creating FINAO<sup>&reg;</sup>s, you can generally expect to receive your product anywhere from 7-14 days after placing an order on our web-site. Expedited shipping is also available.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss103">What is FINAOs Returns Policy?</div>

        <div class="content-run-text">If there is a manufacturing and/or shipping error, FINAO<sup>&reg;</sup> guarantees 100% replacement of your product. If you wish to return your product for another reason please contact our customer service to discuss the reason.  Our general policy is items are non-returnable because of the custom nature of the products, so please give detailed information why you are not satisfied so we can find a resolution that works for you!</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss104">How am I notified if a product is placed on backorder?</div>

        <div class="content-run-text">If a product is backordered, FINAO<sup>&reg;</sup> customer service will send an email to you indicating that we have run out of stock for the particular product you ordered. An alternative or similar product will be offered, if available.  You will have the option of receiving a refund if the alternative is not acceptable.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss105">What if I do not receive my order?</div>

        <div class="content-run-text">Please call 1-877-FIN-AO11 or send an email to askus@finaonation.com.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss106">How do I purchase and send a gift to a friend or family member?</div>

        <div class="content-run-text">When checking out, there is an option for selecting a gift certificate. You will need to provide the recipient's shipping address in the "Ship To" fields. </div>

        

        <div class="orange font-14px padding-10pixels" id="quesss201"> How do I place an order?</div>

        <div class="content-run-text">FINAO<sup>&reg;</sup>s website provides easy instructions for placing orders. Our website guides you with a simple step-by step product selection process by identifying all product categories, sizes, and colors (where applicable) that our customers can choose from.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss202">How do I ensure that I have ordered the right size garment?</div>

        <div class="content-run-text">FINAO<sup>&reg;</sup>s website provides sizing charts for garments. FINAO<sup>&reg;</sup> strongly suggests you select garment size based on your actual measurements as FINAO<sup>&reg;</sup> will be unable to replace your product due to sizing issues. Please note that garment sizing can vary significantly based on product type, so it is important that our customers pay close attention to each garment size. As always, if more information is needed regarding a product, please email FINAO<sup>&reg;</sup>s customer service department at askus@finaonation.com. Please include product information (name, size, color) so we may answer your question as soon as possible.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss203">How do I track my order?</div>

        <div class="content-run-text">We will send you tracking information as soon as product has shipped from our service centers. If you would like to receive product sooner than our general service level, there will be an expedited service to choose from when checking out of the ordering process.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss204">How do you calculate shipping rates on orders?  </div>

        <div class="content-run-text">The standard shipping method for all orders will be defaulted to Ground Service. All orders that ship ground will have standard costs for shipping and handling. Expedited shipping (Next Day or 2 Day Air will be calculated if chosen.  We do ship to Canada. For any other countries, shipping is not yet available, but look for it soon!</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss205">Are the colors portrayed on-line accurate with the product I will receive? </div>

        <div class="content-run-text">Both colors online and physical product received by our customers should be a close match. The FINAO<sup>&reg;</sup> team has utilized industry standard color code keys that best represent product colors.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss206">Do I have to place my shipping and credit card information every time I purchase a garment or will this be stored?</div>

        <div class="content-run-text">We do not store shipping or credit card information. If your browser is configured to store your information, certain fields may auto populate. However, FINAO<sup>&reg;</sup> Nation does not store any credit card information and while you are shopping it is not visible beyond the last four digits (so that you may confirm this is your preferred method of payment).</div>

        

        

        <div class="orange font-14px padding-10pixels" id="quesss301">Does FINAO<sup>&reg;</sup> have retail stores?</div>

        <div class="content-run-text">At the current time, FINAO<sup>&reg;</sup> does not have retail stores.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss302">Where are the washing instructions of the garments listed?</div>

        <div class="content-run-text">Please note that every garment produced will contain a care and content label. Depending on the garment purchased, the location of the care and content label could be in different locations (normally on the neck or side seam) and will contain all the necessary information to care for your garment properly.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss303">Can I place multiple orders (like for a team or group)?  Do I have to enter each one individually using the website?  Are there group/bulk order discounts?</div>

        <div class="content-run-text">Team and/or group orders do not have to be entered individually. There will be group/bulk discounts available. All team and/or group orders should be sent to customerservice@finaonation.com.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss304">How many characters will be allowed on FINAO<sup>&reg;</sup> FlipWear<sup>&reg;</sup> garments?  Can I change the font and/or size of the TagNote™?</div>

        <div class="content-run-text">The maximum character length for the creation of a FINAO<sup>&reg;</sup> on a garment is currently set at 150 characters. Currently the font type and size of the TagNote<sup>TM</sup> are fixed and cannot be changed.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss305">What type of imprinting is used for garments and accessories?</div>

        <div class="content-run-text">FINAO<sup>&reg;</sup> uses various decorating capabilities such as silk- screening, embroidery, digital printing, applique', felting and laser-etching*. You can rest assured that the method used for each garment adds to the look and feel. Tested and ready for wear especially for you!</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss306">Can I change the color schemes of the FINAO<sup>&reg;</sup> logo on my selected garment?</div>

        <div class="content-run-text">The FINAO<sup>&reg;</sup> logo color scheme is set with a pre-determined color palette. If you require alternate combinations on quantity orders, please email customerservice@finaonation.com for customizable options.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss307">What Are Cookies?</div>

        <div class="content-run-text">Cookies are short pieces of data that are sent to your computer when you visit a website. On later visits, this data is then returned to that website. Cookies allow us to recognize you automatically whenever you visit our site so that we can personalize your experience and provide you with better service. We also use cookies (and similar browser data, such as Flash cookies) for fraud prevention and other purposes. If your web browser is set to refuse cookies from our website, you will not be able to complete a purchase or take advantage of certain features of our website, such as storing items in your Shopping Cart or receiving personalized recommendations. As a result, we strongly encourage you to configure your web browser to accept cookies from our website.</div>

        

        <div class="orange font-14px padding-10pixels" id="quesss308">Enabling Cookies</div>

        <div class="content-run-text">NEW CUSTOMERS</div>

        <div class="content-run-text">By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</div>

        </div>

    </div>

</body>