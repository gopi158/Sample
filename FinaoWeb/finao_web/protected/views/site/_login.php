<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */ 

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
include ("header.php");
include ("configuration/configuration.php");
include ("footer.php");
?>
<style>
  .display_video_content
  {
    z-index: -1;
  }
</style>
<script>
  $(document).on("click","#explore_signup",function(){
    $('.bs-modal-sm1').modal('hide');
  });

  $(document).on("click","#open_sign_up_form",function(){
      //$("#msg_alert_popup").modal('show');
      $("#fname").val("");
      $("#lname").val("");
      $("#password").val("");
      $("#reenter_password").val("");
      $("#email_signup").val("");
      Recaptcha.reload();
  });
</script>
<div class="modal fade bs-modal-sm2" id="modalsignup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content" style="border-radius:1px;">
            <div align="right" style="margin-top: -15px; margin-right: -15px;">
                <button type="button" class="close close-opacity" data-dismiss="modal" aria-hidden="true">          
                    <img alt="Icon-close" src="<? echo $icon_path."/icon-close.png"?>" class="img-responsive">
                </button>
            </div>
            <div>
                <div class="row" style="margin-top: 20px;">
                    <p align="center">
                        <img alt="Logo" src="<? echo $icon_path."logo-small.png"; ?>" class="img-responsive">
                    </p>
                </div>
            </div>
            <div>
                <div class="signup-container">
                    <div class="row signup-container-fields">
                        <form class="form-signin" role="form" id="signup">
                            <div class="col-md-11 col-sm-11">
                                <div class="form-group">
                                    <input type="text" class="form-control placeholder" maxlength="50" id="fname" name="signup_info[first_name]" placeholder="FIRST NAME" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control placeholder" maxlength="50" id="lname" name="signup_info[last_name]" placeholder="LAST NAME">
                                </div>
                            </div>
                            <div class="col-md-11 col-sm-11">
                                <div class="form-group">
                                    <input type="email" class="form-control placeholder" id="email_signup" name="signup_info[email]" placeholder="EMAIL">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control placeholder" id="password" name="signup_info[password]" placeholder="PASSWORD">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control placeholder" id="reenter_password" name="signup_info[reenter_password]" placeholder="RE-ENTER PASSWORD">
                                </div>
                            </div>
                            <div class="col-md-11 col-sm-11">
                                <div class="form-group" align="center">
                                    <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC"></script>
                                    <noscript>
                                        <iframe src="https://www.google.com/recaptcha/api/noscript?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC" height="300" width="500" frameborder="0"></iframe>
                                        <br>
                                    </noscript>
                                </div>
                            </div>
                            <div class="col-md-11 form-group" align="center">
                                <a href="#">
                                    <img alt="Image-fb" src="<? echo $image_path."login-facebook.png"; ?>" class="img-responsive">
                                </a>
                            </div>
                            <div class="col-md-11 form-group">
                                <p>
                                    By clicking "Sign Up" you are agreeing<br />
                                    to FINAO's
                                    <a href="#" data-toggle="modal" data-target=".bs-modal-lg">terms and conditions.</a>
                                </p>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <div style="padding: 0;" id="signupbutton">
                <div >
                    <button class="button-signup" style="width:100%;" id="signup_submit">SIGN UP</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--term and conditions-->
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
            <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">          
        </button>
      </div>
      <div class="modal-body">
        <div class="content-page">
          <h4 class="modal-title orange" id="myModalLabel">Terms &amp; Conditions</h4>
          <p>
            Thank you for using finaonation.com.  These Terms of Use (&quot;Terms of Use&quot;) govern your access and use of <span class="orange">
              both finaonation.com and the FINAO<sup>&reg;</sup> mobile app
            </span> (collectively, the &quot;Site&quot;).   By accessing, using, or placing an order through the Site, you consent to the Terms of Use listed below.  FINAO<sup>&reg;</sup> reserves the right to add, change, or remove portions of these Terms of Use at any time.  It is the your responsibility to check the Terms of Use each time prior to using the Site.  Continued use of the site is your consent to the latest Terms of Use.
          </p>
          <p>
            <span class="orange">Use of Site and Customer Accounts</span>
          </p>
          <p>
            Only if you agree to these Terms of Use will FINAO<sup>&reg;</sup> grant you (the &quot;End User&quot;) a personal, non-exclusive, non-transferrable, non-sub-licensable, limited privilege to enter and use the Site. <span class="orange">Any use or access by anyone under the age of 13 is prohibited, unless a parent or legal guardian consents to such use.</span>  Most services offered through the Site require you to create a user account, and to provide complete and accurate information about yourself and your billing information.  You are responsible for maintaining the confidentiality of your account information, including your password, and for all activity that occurs under your account.  You agree to notify FINAO<sup>&reg;</sup> immediately of unauthorized use of your account or password, or other breach of security.  You may be held liable for loss incurred by FINAO<sup>&reg;</sup> or another Site user due to someone else using your password or customer account.  You may not attempt to or in any way gain unauthorized access to the Site.  Should you do so or assisting others in making such attempts, or distributing tools, software, or instructions for that purpose, your customer account will be terminated.
          </p>
          <p>
            All media (downloaded or samples), software, text, images, graphics, user interfaces, music, videos, photographs, trademarks, logos, artwork and other content on the Site (collectively, "Content"), including but not limited to the design, selection, arrangement, and coordination of such Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>.  You may not use any automatic device, program, algorithm, or methodology, or any similar manual process to access, acquire, copy, probe, test, or monitor any portion of the Site or any Content, or in any way reproduce or circumvent the navigational structure or presentation of the Site or any Content.  You may not obtain or attempt to obtain any materials, documents, or information through any means not purposely made available through the Site.  You may not take any action that imposes unreasonably large load on the infrastructure of the Site or any of the systems or networks comprising of or connected to the Site.
          </p>

          <p>If you create an account on behalf of a company, organization, or other entity, then both you and that entity warrant that you are authorized as an agent of the entity, and that you agree to and bind the entity to these Terms of Use.</p>

          <p>
            You also agree that FINAO<sup>&reg;</sup> may, in its sole discretion and without prior notice to you, terminate your access to the Site and your Account for any reason, including without limitation: (1) attempts to gain unauthorized access to the Site or assistance to others' attempting to do so, (2) overcoming software security features limiting use of or protecting any Content, (3) discontinuance or material modification of the Site or any service offered on or through the Site, (4) violations of this Terms of Use, (5) failure to pay for purchases, (6) suspected or actual copyright infringement, (7) unexpected operational difficulties, or (8) requests by law enforcement or other government agencies. You agree that FINAO<sup>&reg;</sup> will not be liable to you or to any third party for termination of your access to the Site.
          </p>

          <p>
            <span class="orange">Acceptable Use Policy</span>
          </p>
          <p>
            FINAO<sup>&reg;</sup> provides a safe environment in which we all share and track goals and aspirations.  In order to promote this positive vibe, you agree to adhere to the following Acceptable Use Policy while using this Site.
          </p>

          <p>You agree to not post Content that:</p>

          <ul class="answers">
            <li>Is sexually explicit or looks to exploit children by exposing inappropriate content;</li>
            <li>Creates risk of or actual mental or physical injury, death, disfigurement, or loss to any person or property;</li>
            <li>Is deemed hateful, violent, abusive, racially offensive, defamatory, infringing, threatening, or humiliating;</li>
            <li>Infringes on a third party&acute;s rights; or</li>
            <li>Violates or encourages the violation of laws or regulations.</li>
          </ul>

          <p>
            <span class="orange">Data Use Policy and Personal Information</span>
          </p>
          <p>
            As more fully described in our <a href="privacy.html">Privacy Policy</a>, you must disclose certain Personally Identifiable Information to use our Site, register, and make purchases. As a condition of registering with our Site or making any purchases of any products and/or services or conduct any transactions, you represent that you have first read our <a href="privacy.html">Privacy Policy</a> and consent to the collection, use and disclosure of your Personally Identifiable Information and Non-Personally Identifiable Information as described in our <a href="privacy.html">Privacy Policy</a>. We reserve the right to modify our <a href="privacy.html">Privacy Policy</a>; as a condition of browsing the Site, using any features or making any purchase, you agree that you will first review our <a href="privacy.html">Privacy Policy</a> prior to making any initial or subsequent purchases.
          </p>
          <p>
            While FINAO<sup>&reg;</sup> takes reasonable steps to safeguard and to prevent unauthorized access to your personal information, we cannot be responsible for the acts of those who gain unauthorized access, and we make no warranty, express, implied, or otherwise, that we will prevent unauthorized access to your private information. IN NO EVENT SHALL FINAO<sup>&reg;</sup> OR ITS AFFILIATES BE LIABLE FOR ANY DAMAGES (WHETHER CONSEQUENTIAL, DIRECT, INCIDENTAL, INDIRECT, PUNITIVE, SPECIAL OR OTHERWISE) ARISING OUT OF, OR IN ANY WAY CONNECTED WITH, A THIRD PARTY'S UNAUTHORIZED ACCESS TO YOUR PERSONAL INFORMATION, REGARDLESS OF WHETHER SUCH DAMAGES ARE BASED ON CONTRACT, STRICT LIABILITY, TORT OR OTHER THEORIES OF LIABILITY, AND ALSO REGARDLESS OF WHETHER FINAO<sup>&reg;</sup> WAS GIVEN ACTUAL OR CONSTRUCTIVE NOTICE THAT DAMAGES WERE POSSIBLE.
          </p>

          <p>
            <span class="orange">Email Communications</span>
          </p>
          <p>
            By establishing an Account with us, and each time you make a purchase through our Site, you grant permission for FINAO<sup>&reg;</sup> to contact you at your e-mail address. To stop receiving our marketing emails, send an e-mail to us at <a href="#" class="orange-link font-14px">askus@finaonation.com</a> or follow the opt-out procedures set forth in such marketing emails. FINAO<sup>&reg;</sup> cannot be held responsible for emails not received due to SPAM filters installed by your Internet Service Provider (ISP), email provider or by you, the Customer. FINAO<sup>&reg;</sup> cannot be held responsible for order delays or failure to receive out of stock or declined notifications created by SPAM filters or other related computer software and/or hardware.
          </p>

          <p>
            <span class="orange">Intellectual Property</span>
          </p>

          <p>
            All media and Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>, and is protected by copyright, trade dress, and trademark laws, and various other intellectual property rights laws. Except as expressly provided in this Terms of Use, no part of the Site and no Content may be reproduced, recorded, retransmitted, sold, rented, broadcast, distributed, published, uploaded, posted, publicly displayed, altered to make new works, performed, digitized, compiled, translated or transmitted in any way to any other computer, website or other medium or for any commercial purpose, without FINAO<sup>&reg;</sup>'s prior express written consent. Except as expressly provided herein, you are not granted any rights or license to patents, copyrights, trade secrets, trade dress, rights of publicity or trademarks with respect to any of the Content, and FINAO<sup>&reg;</sup> reserves all rights not expressly granted hereunder. FINAO<sup>&reg;</sup> expressly disclaims all responsibility and liability for uses by you of any Content obtained on or in connection with the Site.
          </p>
          <p>
            FINAO<sup>&reg;</sup> and FlipWear are registered trademarks, trademarks or service marks of JoMoWaG, LLC &shy; Dba FINAO <sup>&reg;</sup>. All custom graphics, icons, logos and service names are registered trademarks, trademarks or service marks of JoMoWaG, LLC &shy; Dba FINAO<sup>&reg;</sup>. All other trademarks or service marks are property of their respective owners. The use of any FINAO <sup>&reg;</sup> trademark or service mark without FINAO<sup>&reg;</sup>'s express written consent is strictly prohibited.
          </p>
          <p>
            By submitting a design to FINAO<sup>&reg;</sup>, or using logos stored on the site, you warrant and represent that you are the sole, legal owner or licensee of all rights, including copyright, to each copyright, trademark, service mark, trade name, logo, statement, portrait, graphic, artwork, photograph, picture or illustration of any person or any other intellectual property included in such design.
          </p>
          <p>
            Further, you warrant and represent that no part of the design: (a) violates or infringes upon any common law or statutory right of any person or entity, including, but not limited to, rights relating to copyrights, trademarks, contract rights, moral rights or rights of public performance; (b) is the subject of any notice of such infringement you have received; or (c) is subject to any restriction or right of any kind or nature whatsoever which would prevent FINAO<sup>&reg;</sup> from legally reproducing the images or text submitted.
          </p>
          <p>
            You agree to defend, at your sole expense, any claim, suit, or proceeding brought against FINAO<sup>&reg;</sup> which relates to, or is based upon, a claim that any portion of the design infringes or constitutes wrongful use of any copyright, trademark, or other right of any third party, provided that FINAO<sup>&reg;</sup> gives you written notice of any such claim and provides you such reasonable cooperation and assistance as you may require in the defense thereof. You shall pay any damages and costs assessed against FINAO<sup>&reg;</sup> pursuant to such a suit or proceeding. Further, you agree to indemnify and hold FINAO<sup>&reg;</sup> harmless from and with respect to any such loss or damage (including, but not limited to, reasonable attorneys' fees and costs) associated with any such claim, suit or proceeding.
          </p>
          <p>
            All items shown on this web site containing corporate logos or registered trademarks are shown only to illustrate FINAO<sup>&reg;</sup>'s logo reproduction capabilities. Purchase of merchandise from FINAO<sup>&reg;</sup> in no way, shape or form grants you permission to reproduce logos, nor does it transfer, grant or lease ownership of any logos or trademarks to you.
          </p>

          <p>
            <span class="orange">Conditions of Sale and Payment Terms.</span>
          </p>

          <p>To purchase any goods and/or services on our Site, you must (a) be at least eighteen (18) years of age or the applicable state age of majority. Prior to the purchase of any goods or services on our Site, you must provide us with a valid credit card number and associated payment information including all of the following: (i) your name as it appears on the card, (ii) your credit card number, (iii) the credit card type, (iv) the date of expiration and (v) any activation numbers or codes needed to charge your card. By submitting that information to us, you hereby agree that you authorize us to charge your card at our convenience but within thirty (30) days of credit card authorization.</p>

          <p>
            <span class="orange">Methods of Payment, Credit Card Terms and Taxes.</span>
          </p>

          <p>
            All payments must be made by VISA, MasterCard, American Express, or Discover Card. Your card issuer agreement governs your use of your designated card, and you must refer to that agreement and not this Terms of Use to determine your rights and liabilities as a cardholder. YOU, AND NOT FINAO<sup>&reg;</sup>, ARE RESPONSIBLE FOR PAYING ANY UNAUTHORIZED AMOUNTS BILLED TO YOUR CREDIT CARD BY A THIRD PARTY. You agree to pay all fees and charges incurred in connection with your purchases (including any applicable taxes) at the rates in effect when the charges were incurred. Unless you notify FINAO<sup>&reg;</sup> of any discrepancies within sixty (60) days after they first appear on your credit card statement, you agree that they will be deemed accepted by you for all purposes. If FINAO<sup>&reg;</sup> does not receive payment from your credit card issuer or its agent, you agree to pay all amounts due upon demand by FINAO<sup>&reg;</sup> or its agents. You are responsible for paying any governmental taxes imposed on your purchases and shipping, including, but not limited to, sales, use or value-added taxes. FINAO<sup>&reg;</sup> shall automatically charge and withhold the applicable sales tax for orders to be delivered to addresses within Washington State and any other states or localities that it deems are required.
          </p>

          <p>
            <span class="orange">Improper/Fraudulent Chargeback fee: $25.00</span>
          </p>

          <p>
            <strong>Explanation:</strong> Customers issuing chargeback(s) with their Credit Card's issuing Bank without proper cause will be billed any fees incurred by FINAO<sup>&reg;</sup> in disputing the chargeback as well as a $25.00 Chargeback fee. This is necessary to recover the charges we were billed by Visa/MasterCard/Discover Card when the no cause chargeback was issued. With this type of fraud/negligence on the rise, and little recourse given to the Merchant by the credit card issuers, we must protect ourselves from this new type of crime/negligence.
          </p>

          <p>
            <span class="orange">Order Acceptance Policy</span>
          </p>

          <p>
            Your receipt of an electronic or other form of order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell. FINAO<sup>&reg;</sup> reserves the right at any time after receipt of your order to accept or decline your order for any reason. FINAO<sup>&reg;</sup> further reserves the right any time after receipt of your order, without prior notice to you, to supply less than the quantity you ordered of any item. Your order will be deemed accepted by FINAO<sup>&reg;</sup> upon our shipment of products or delivery of services that you have ordered. All orders placed over $1000.00 (U.S.) must obtain pre-approval with an acceptable method of payment, as established by our credit and fraud avoidance department. We may require additional verifications or information before accepting any order.
          </p>

          <p>
            <span class="orange">Jurisdiction and Limited Liability</span>
          </p>
          <p>These Terms of Use are governed by the laws of the State of Washington.  By using or accessing the Site, you agree to submit personal jurisdiction to the State Courts in King County or the United States District Court for the Western District of Washington.  </p>

          <p>
            <span class="orange">International Use</span>
          </p>
          <p>If you are a user of the site that is outside of the United States, you consent to your personal information and any information transferred through the use of the Site, to be transmitted and stored in the United States.  All Site users, even if located or domiciled outside of the United States, consent to these Terms of Use.  </p>
          <p>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!--term and conditions-->

<div class="modal fade bs-modal-sm1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm1">
    <div class="modal-content" style="border-radius: 1px;">
      <div class="text-align-right" style="margin-top: -15px; margin: -15px;">
        <button type="button" class="close close-opacity no-border" data-dismiss="modal" aria-hidden="true">
            <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">          
        </button>
      </div>
      <div>
        <div class="row" style="margin-top: 30px;">
          <div class="col-lg-2 col-md-2 col-sm-2" style="padding-left: 30px">
            <a href="#">
              <img class="img-responsive" alt="Profile-image" src="content/images/wallace.jpg">
            </a>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4" style="margin-left: -25px; font-weight: bold; padding-top: 4%;">Wallace Greene</div>
          <div class="col-lg-4 col-md-4 col-sm-4 landing-explore-fade" style="padding-top: 4%;">two hours ago</div>
        </div>
      </div>
      <div>
        <div class="row" style="padding-top: 15px; padding-left: 45px; padding-right: 45px;">

          <img class="img-responsive col-md-12 col-sm-12" alt="Finao-image" src="content/images/finao-sample-img.jpg">
                    </div>
        <div class="row" style="margin-left: 25px; margin-top: 20px; margin-right: 15px">

          <div style="float: left; font-weight: bold;">
            <img alt="Icon-finao" src="<? echo ($icon_path."icon-finao.png");?>">I will travel the world
                       
                        </div>
          <br />
          <p style="text-align: left; float: left; padding-left: 0px;">I drove over to Spokane with my family last week and got to see a sweet firework show in the mountains!</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="#" class="status-button-ontrack landing-explore-on-track">ON TRACK</a>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 text-right" style="padding-right: 25px">
            <span class="inspiring">Inspiring</span>
          </div>
        </div>

        <div class="popup-selected-finao popup-selected-finao-border" style="margin: 15px 15px 10px -5px;"></div>

        <div class="row">
          <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2" style="padding-left: 38px; float: left; margin-left: 15px">
              <a href="#">
                <img class="img-responsive post-image" alt="Profile-image" src="<? echo $icon_path."mitchell.jpg"; ?>">
              </a>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5" style="margin-left: -35px; float: left; font-weight: bold; text-align: left;">
              Wallace Greene<br />
              <img alt="Icon-finao" src="<? echo $icon_path. "icon-finao.png";?>">
              I will travel the world
                           
                            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 landing-explore-fade">yesterday</div>
          </div>
          <div class="row" style="margin-left: 40px; margin-right: 22px;">
            <p style="text-align: left">I drove over to Spokane with my family last week and got to see a sweet firework show in the mountains!</p>
          </div>
        </div>

      </div>
      <div class="landing-sign-up col-md-7" style="margin-top:0px;width:100%; font-size:35px;">
        <a href="#" data-toggle="modal" id="explore_signup" data-target=".bs-modal-sm2" style="color: #FFF; text-decoration: none;">SIGN UP</a>
      </div>      
    </div>
  </div>
</div>


<div class="container white-background">
  <div class="content-wrapper" style="margin-top: 0px">
    <div class="row">
      <div class="col-lg-5 col-md-5 col-sm-6  everyone-has-a-finaoline" style="margin-left: -25px;">
        <div class="row compress">EVERYONE</div>
        <div class="row compress">HAS A</div>
        <div class="row">
          <span class="orange landing-finao">FINAO</span>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6" style="margin-left: 25px;">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3"></div>
          <div class="button-explore col-md-8 col-sm-12">
            <a href="#" data-toggle="modal" data-target=".bs-modal-sm1" style="color: #FFF; text-decoration: none;">EXPLORE FINAO</a>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3"></div>
          <div class="landing-sign-up col-md-8 col-sm-12">
            <a href="#" data-toggle="modal" data-target=".bs-modal-sm2" style="color: #FFF; text-decoration: none;">SIGN UP</a>
          </div>
        </div>
        <div class="row landing-login-facebook">

          <div class="col-lg-7 col-md-7 col-sm-7 col-sm-push-2 col-md-push-4 text-align-center">
            <a href="#">
              <img alt="Fb-image" src="<? echo $image_path."login-facebook.png"; ?>" />
              <br />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row col-lg-12 col-sm-12 col-md-12 clear-50px"></div>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="landing-videoWrapper">
        <iframe id="viddler-4344341d" src="//www.viddler.com/embed/e38f4f0c/?f=1&amp;autoplay=0&amp;player=full&amp;secret=76006978&amp;loop=0&amp;nologo=0&amp;hd=0&amp;offsetTime=0" width="437" height="288" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
      </div>
    </div>

    <div class="col-lg-5 col-md-5 col-sm-6 finao-line-container">
      <div class="landing-everyone-has-a-finaoline ">
        <div class="row compress-bot">
          <span class="orange">F</span>AILURE
        </div>

        <div class="row compress-bot">
          <span class="orange">I</span>S <span class="orange">N</span>OT
        </div>
        <div class="row compress-bot">
          <span class="landing-everyone-an-optionline">
            <span class="orange">A</span>N
            <span class="orange ">O</span>PTION
          </span>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="msg_alert_popup" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div align="right" style="margin-top: -15px; margin-right: -15px;">
        <button type="button" class="close close-opacity" data-dismiss="modal" aria-hidden="true">
          <img alt="Image" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">
        </button>
      </div>
      <div>
        <div class="row" style="margin-top: 20px;">
          <p align="center">
            <img alt="Logo" src="<? echo $icon_path."logo-small.png"; ?>" class="img-responsive"/>
                    </p>
        </div>
      </div>
      <div class="modal-body" align="center">
        <span id="alert_msg" class="font-18px"></span>
        <br />
        <br />
        <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary" style="width:80px;height:30px;font-family: 'oswaldbook';">
          <span class="font-18px">
            OK
          </span>
        </button>
      </div>
    </div>
  </div>
</div>