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

#back-top{position:fixed; bottom:120px; z-index:99; right:0px; }

a.back{margin-bottom: 7px; -webkit-transition: 1s; -moz-transition: 1s; -o-transition: 1s;  transition: 1s;}

#scroll-down{background:url(images/home/scrolldown.png) left top no-repeat; width:22px; height:18px; -webkit-animation: scroll_down .7s ease infinite; -moz-animation: scroll_down .7s ease infinite; animation: scroll_down .7s ease infinite; position:fixed; top:500px; right:15px;}

</style>



<body  id="top">

<p id="back-top"><a class="back" href="#top"><img src="<?php echo $this->cdnurl; ?>/images/home/backtop.png" width="150" /></a></p>

	 <div class="main-container">

    	<div class="finao-canvas">

			<div class="orange font-20px padding-10pixels"><span class="left">Privacy Policy </span> <span class="right"><a href="<?php echo Yii::app()->request->urlReferrer;?>"><img src="<?php echo $this->cdnurl; ?>/images/back.png" width="60" /></a></span></div>
			<div class="clear"></div>
            <div class="content-run-text">
                 <p class="bolder" style="margin-top:5px;">We use the latest technologies to ensure that your email address and all personal information is safe.</p>
                 <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>and/or its subsidiaries, as owner(s) of this website, strives to offer its visitors the many advantages of Internet technology and to provide an interactive and personalized experience. We may use Personally Identifiable Information (your name, email address, street address and telephone number) subject to the terms of this privacy policy.</p>
                 <p class="bolder">How we gather information from users</p>   
                 <p>How we collect and store information depends on the page you are visiting, the activities in which you elect to participate and the services provided. </p>
                 <p>Like most Web sites, JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, also collects information automatically and through the use of electronic tools that may be transparent to our visitors. For example, we may log the name of your Internet Service Provider or use cookie technology to recognize you and hold information from your visit. Among other things, the cookie may store your user name and password, sparing you from having to re-enter that information each time you visit, or may control the number of times you encounter a particular advertisement while visiting our site.</p>
                 
                 <p class="bolder">What we do with the information we collect</p>
                 <p>Like other Web publishers, we collect information to enhance your visit and deliver more individualized content and advertising.
Aggregated Information (information that does not personally identify you) may be used in many ways. For example, we may combine information about your usage patterns with similar information obtained from other users to help enhance our site and services (e.g., to learn which pages are visited most or what features are most attractive). Aggregated Information may occasionally be shared with our advertisers and business partners. Again, this information does not include any Personally Identifiable Information about you or allow anyone to identify you individually.</p>
		
        		<p><span class="orange font-16px">Information we share</span></p>
                <p>We do not share personal information with companies, organizations and individuals outside of FINAO unless one of the following circumstances apply:</p>
                <ul class="answers">
                	<li class="orange">With your consent</li>
                </ul>
                <p style="padding-left:25px;">We will share personal information with companies, organizations or individuals outside of FINAO when we have your consent to do so. We will require opt-in consent for the sharing of any sensitive personal information</p>
                
                <ul class="answers">
                	<li class="orange">With domain administrators</li>
                </ul>
                <p style="padding-left:25px;">If your FINAO Account is managed for you by a domain administrator (for example, for FINAO Apps users) then your domain administrator and resellers who provide user support to your organization will have access to your FINAO Account information (including your email and other data). Your domain administrator may be able to:</p>
               
               	<ul class="answers">
                	<li style="padding-left:50px; padding-bottom:5px;">View statistics regarding your account, like statistics regarding applications you install.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Change your account password.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Suspend or terminate your account access.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Access or retain information stored as part of your account.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Receive your account information in order to satisfy applicable law, regulation, legal process or enforceable governmental request.</li>
                    <li style="padding-left:50px;">Restrict your ability to delete or edit information or privacy settings.</li>
                </ul>
                
                <ul class="answers">
                	<li class="orange">For external processing</li>
                </ul>
                <p style="padding-left:25px;">We provide personal information to our affiliates or other trusted businesses or persons to process it for us, based on our instructions and in compliance with our Privacy Policy and any other appropriate confidentiality and security measures.</p>
                
                <ul class="answers">
                	<li class="orange">For legal reasons</li>
                </ul>
                <p style="padding-left:25px;">We will share personal information with companies, organizations or individuals outside of FINAO if we have a good-faith belief that access, use, preservation or disclosure of the information is reasonably necessary to:</p>
                <ul class="answers">
                	<li style="padding-left:50px; padding-bottom:5px;">Meet any applicable law, regulation, legal process or enforceable governmental request.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Enforce applicable Terms of Service, including investigation of potential violations.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Detect, prevent, or otherwise address fraud, security or technical issues.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Protect against harm to the rights, property or safety of FINAO, our users or the public as required or permitted by law.</li>
                </ul>
                <p>We may share aggregated, non-personally identifiable information publicly and with our partners - like publishers, advertisers or connected sites. For example, we may share information publicly to show trends about the general use of our services.</p>
              <p>If FINAO is involved in a merger, acquisition or asset sale, we will continue to ensure the confidentiality of any personal information and give affected users notice before personal information is transferred or becomes subject to a different privacy policy.</p>
              <p>We may use Personally Identifiable Information collected on JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup> and/or its subsidiaries, as owner(s) of this website, to communicate with you about your registration and customization preferences; our Terms of Service and privacy policy; services and products offered by JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, and other topics we think you might find of interest. </p>
              
              <p>Personally Identifiable Information collected by JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, may also be used for other purposes, including but not limited to site administration, troubleshooting, processing of e-commerce transactions, administration of sweepstakes and contests, and other communications with you. In certain cases, you can choose not to provide us with information, for example by setting your browser to refuse to accept Certain third parties who provide support for the operation of our site (our Web hosting service, our shopping cart providers and fulfillment partners, for example) and for our business (marketing services for example) may also access such information. We will use your information only as permitted by law. In addition, from time to time as we continue to develop our business, we may sell, buy, merge or partner with other companies or businesses. In such transactions, user information may be among the transferred assets. If you do not wish your information to be used by third parties for non-order related services (such as marketing), please contact us at the email or U.S. mail addresses below.</p>
              
              <p>We may also disclose your information in response to a court order, at other times when we believe we are reasonably required to do so by law, in connection with the collection of amounts you may owe to us, and/or to law enforcement authorities whenever we deem it appropriate or necessary. Please note we may not provide you with notice prior to disclosure in such cases.</p>
              
              <p><span class="orange font-16px">Affiliated sites, linked sites and advertisements</span></p>
              <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, expects its partners, advertisers and affiliates to respect the privacy of our users. Be aware, however, that third parties, including our partners, advertisers, affiliates and other content providers accessible through our site, may have their own privacy and data collection policies and practices. For example, during your visit to our site you may link to, or view as part of a frame on a JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, page, certain content that is actually created or hosted by a third party. Also, through JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, you may be introduced to, or be able to access, information, Web sites, features, contests or sweepstakes offered by other parties.</p>
              <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, is not responsible for the actions or policies of such third parties. You should check the applicable privacy policies of those third parties when providing information on a feature or page operated by a third party.</p>
              <p>While on our site, our advertisers, promotional partners or other third parties may use cookies or other technology to attempt to identify some of your preferences or retrieve information about you. For example, some of our advertising is served by third parties and may include cookies that enable the advertiser to determine whether you have seen a particular advertisement before. Other features available on our site may offer services operated by third parties and may use cookies or other technology to gather information. JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, does not control the use of this technology by third parties or the resulting information, and is not responsible for any actions or policies of such third parties.</p>
				<p>You should also be aware that if you voluntarily disclose Personally Identifiable Information on message boards or in chat areas, that information can be viewed publicly and can be collected and used by third parties without our knowledge and may result in unsolicited messages from other individuals or third parties. Such activities are beyond the control of JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, and this policy.</p>
                
                <p><span class="orange font-16px">Children</span></p>
                <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, does not knowingly collect or solicit Personally Identifiable Information from or about children under 13 except as permitted by law. If we discover we have received any information from a child under 13 in violation of this policy, we will delete that information immediately. If you believe JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, has any information from or about anyone under 13, please contact us at the address listed below.</p>
                
                <p><span class="orange font-16px">How to Stop email Communication from Us</span></p>
                <p>If you do not want to receive commercial/promotional email from us, please let us know by utilizing the unsubscribe option available at the bottom of any of our email communications, by accessing the form <a href="#" class="orange-link font-14px">unsubscribe@finaonation.com</a>, by calling us at PHONE or by writing to us at: JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, <span class="orange">13024 Beverly Park Rd Suite 201, Mukilteo WA 98275</span></p>
                
                <p><span class="orange font-16px">Changes to this Policy</span></p>
                <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, reserves the right to change this policy at any time. Please check this page periodically for changes. Your continued use of our site following the posting of changes to these terms will mean you accept those changes. Information collected prior to the time any change is posted will be used according to the rules and laws that applied at the time the information was collected.</p>
                
                <p><span class="orange font-16px">Governing law</span></p>
                <p>This policy and the use of this Site are governed by Washington law. If a dispute arises under this Policy we agree to first try to resolve it with the help of a mutually agreed-upon mediator in the following location: Snohomish, Washington. Any costs and fees other than attorney fees associated with the mediation will be shared equally by each of us.</p>
                <p>If it proves impossible to arrive at a mutually satisfactory solution through mediation, we agree to submit the dispute to binding arbitration at the following location: Snohomish, Washington, under the rules of the American Arbitration Association. Judgment upon the award rendered by the arbitration may be entered in any court with jurisdiction to do so.</p>
				<p>This statement and the policies outlined herein are not intended to and do not create any contractual or other legal rights in or on behalf of any party.</p>
                <p>If it proves impossible to arrive at a mutually satisfactory solution through mediation, we agree to submit the dispute to binding arbitration at the following location: Snohomish, Washington, under the rules of the American Arbitration Association. Judgment upon the award rendered by the arbitration may be entered in any court with jurisdiction to do so.</p>
                <p>This statement and the policies outlined herein are not intended to and do not create any contractual or other legal rights in or on behalf of any party.</p>
              
            </div>
            
        </div>

    </div>

</body>