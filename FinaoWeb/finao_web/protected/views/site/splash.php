<?php
    include ("configuration/configuration.php");
?>
<script>
    function submit_splash()
    {
        if (($("#splash_email").val() == "") && ($("#splash_phone").val()==""))
        {
            show_alert("Please fill atleast one field");
            return false;
        }
        if (($("#splash_email").val() != ""))
        {
            var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!email_pattern.test($("#splash_email").val()))
            {
                show_alert("Please enter valid email address.");
                $("#splash_email").focus();
                ///$("#splash_email").addClass("control-error");
                return false;
            }
        }
        $.post("index.php?r=site/keepmeposted",$("#keepmeposted").serialize() , function(data){
            if(data == "success")
            {
                $("#splash_email").val("");
                $("#splash_phone").val("");
                $("#myModal").modal("show");   
            }
        })
        
    }
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Thanks for the info!</strong>
                <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
                    <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">                    
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Now you've got a backstage pass to something awesome, coming right around the corner. Since you're feeling all "exclusive," you should pop over to Facebook, like FINAOnation there, and you'll be even more in the know.
                </p>
                <p>
                    We're working on something right now just for you -- look for that in just a few days. Talk soon!
                </p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
               
            <div class="modal-body">
                <div class="content-page">
                  <div class="content-run-text">
                    <div class="orange font-20px padding-10pixels">
                      <span class="left">Terms of Use</span>
                      <span class="right">
                        <a href="">
                          <img src="http://cdn.finaonation.com/images/back.png" width="60">
                        </a>
                      </span>
                    </div>
                    <div class="clear"></div>

                    <p>
                      Thank you for using finaonation.com.  These Terms of Use ("Terms of Use") govern your access and use of <span class="orange">
                        both finaonation.com and the FINAO<sup>&reg;</sup> mobile app
                      </span> (collectively, the "Site").   By accessing, using, or placing an order through the Site, you consent to the Terms of Use listed below.  FINAO<sup>&reg;</sup> reserves the right to add, change, or remove portions of these Terms of Use at any time.  It is the your responsibility to check the Terms of Use each time prior to using the Site.  Continued use of the site is your consent to the latest Terms of Use.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Use of Site and Customer Accounts</span>
                    </p>

                    <p>
                      Only if you agree to these Terms of Use will FINAO<sup>&reg;</sup> grant you (the "End User") a personal, non-exclusive, non-transferrable, non-sub-licensable, limited privilege to enter and use the Site. <span class="orange">Any use or access by anyone under the age of 13 is prohibited, unless a parent or legal guardian consents to such use.</span>  Most services offered through the Site require you to create a user account, and to provide complete and accurate information about yourself and your billing information.  You are responsible for maintaining the confidentiality of your account information, including your password, and for all activity that occurs under your account.  You agree to notify FINAO<sup>&reg;</sup> immediately of unauthorized use of your account or password, or other breach of security.  You may be held liable for loss incurred by FINAO<sup>&reg;</sup> or another Site user due to someone else using your password or customer account.  You may not attempt to or in any way gain unauthorized access to the Site.  Should you do so or assisting others in making such attempts, or distributing tools, software, or instructions for that purpose, your customer account will be terminated.
                    </p>

                    <p>
                      All media (downloaded or samples), software, text, images, graphics, user interfaces, music, videos, photographs, trademarks, logos, artwork and other content on the Site (collectively, "Content"), including but not limited to the design, selection, arrangement, and coordination of such Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>.  You may not use any automatic device, program, algorithm, or methodology, or any similar manual process to access, acquire, copy, probe, test, or monitor any portion of the Site or any Content, or in any way reproduce or circumvent the navigational structure or presentation of the Site or any Content.  You may not obtain or attempt to obtain any materials, documents, or information through any means not purposely made available through the Site.  You may not take any action that imposes unreasonably large load on the infrastructure of the Site or any of the systems or networks comprising of or connected to the Site.
                    </p>

                    <p>If you create an account on behalf of a company, organization, or other entity, then both you and that entity warrant that you are authorized as an agent of the entity, and that you agree to and bind the entity to these Terms of Use.</p>

                    <p>
                      You also agree that FINAO<sup>&reg;</sup> may, in its sole discretion and without prior notice to you, terminate your access to the Site and your Account for any reason, including without limitation: (1) attempts to gain unauthorized access to the Site or assistance to others' attempting to do so, (2) overcoming software security features limiting use of or protecting any Content, (3) discontinuance or material modification of the Site or any service offered on or through the Site, (4) violations of this Terms of Use, (5) failure to pay for purchases, (6) suspected or actual copyright infringement, (7) unexpected operational difficulties, or (8) requests by law enforcement or other government agencies. You agree that FINAO<sup>&reg;</sup> will not be liable to you or to any third party for termination of your access to the Site.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Acceptable Use Policy</span>
                    </p>

                    <p>
                      FINAO<sup>&reg;</sup> provides a safe environment in which we all share and track goals and aspirations.  In order to promote this positive vibe, you agree to adhere to the following Acceptable Use Policy while using this Site.
                    </p>

                    <p>You agree to not post Content that:</p>

                    <ul class="answers">
                      <li>Is sexually explicit or looks to exploit children by exposing inappropriate content;</li>
                      <li>Creates risk of or actual mental or physical injury, death, disfigurement, or loss to any person or property;</li>
                      <li>Is deemed hateful, violent, abusive, racially offensive, defamatory, infringing, threatening, or humiliating;</li>
                      <li>Infringes on a third party's rights; or</li>
                      <li>Violates or encourages the violation of laws or regulations.</li>
                    </ul>

                    <p>
                      <span class="orange font-16px padding-10pixels">Data Use Policy and Personal Information</span>
                    </p>

                    <p>As more fully described in our Privacy Policy, you must disclose certain Personally Identifiable Information to use our Site, register, and make purchases. As a condition of registering with our Site or making any purchases of any products and/or services or conduct any transactions, you represent that you have first read our Privacy Policy and consent to the collection, use and disclosure of your Personally Identifiable Information and Non-Personally Identifiable Information as described in our Privacy Policy. We reserve the right to modify our Privacy Policy; as a condition of browsing the Site, using any features or making any purchase, you agree that you will first review our Privacy Policy prior to making any initial or subsequent purchases.</p>
                    <p>
                      While FINAO<sup>&reg;</sup> takes reasonable steps to safeguard and to prevent unauthorized access to your personal information, we cannot be responsible for the acts of those who gain unauthorized access, and we make no warranty, express, implied, or otherwise, that we will prevent unauthorized access to your private information. IN NO EVENT SHALL FINAO<sup>&reg;</sup> OR ITS AFFILIATES BE LIABLE FOR ANY DAMAGES (WHETHER CONSEQUENTIAL, DIRECT, INCIDENTAL, INDIRECT, PUNITIVE, SPECIAL OR OTHERWISE) ARISING OUT OF, OR IN ANY WAY CONNECTED WITH, A THIRD PARTY'S UNAUTHORIZED ACCESS TO YOUR PERSONAL INFORMATION, REGARDLESS OF WHETHER SUCH DAMAGES ARE BASED ON CONTRACT, STRICT LIABILITY, TORT OR OTHER THEORIES OF LIABILITY, AND ALSO REGARDLESS OF WHETHER FINAO<sup>&reg;</sup> WAS GIVEN ACTUAL OR CONSTRUCTIVE NOTICE THAT DAMAGES WERE POSSIBLE.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Email Communications</span>
                    </p>

                    <p>
                      By establishing an Account with us, and each time you make a purchase through our Site, you grant permission for FINAO<sup>&reg;</sup> to contact you at your e-mail address. To stop receiving our marketing emails, send an e-mail to us at <a href="#" class="orange-link font-14px">askus@finaonation.com</a> or follow the opt-out procedures set forth in such marketing emails. FINAO<sup>&reg;</sup> cannot be held responsible for emails not received due to SPAM filters installed by your Internet Service Provider (ISP), email provider or by you, the Customer. FINAO<sup>&reg;</sup> cannot be held responsible for order delays or failure to receive out of stock or declined notifications created by SPAM filters or other related computer software and/or hardware.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Intellectual Property</span>
                    </p>

                    <p>
                      All media and Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>, and is protected by copyright, trade dress, and trademark laws, and various other intellectual property rights laws. Except as expressly provided in this Terms of Use, no part of the Site and no Content may be reproduced, recorded, retransmitted, sold, rented, broadcast, distributed, published, uploaded, posted, publicly displayed, altered to make new works, performed, digitized, compiled, translated or transmitted in any way to any other computer, website or other medium or for any commercial purpose, without FINAO<sup>&reg;</sup>'s prior express written consent. Except as expressly provided herein, you are not granted any rights or license to patents, copyrights, trade secrets, trade dress, rights of publicity or trademarks with respect to any of the Content, and FINAO<sup>&reg;</sup> reserves all rights not expressly granted hereunder. FINAO<sup>&reg;</sup> expressly disclaims all responsibility and liability for uses by you of any Content obtained on or in connection with the Site.
                    </p>
                    <p>
                      FINAO<sup>&reg;</sup> and FlipWear are registered trademarks, trademarks or service marks of JoMoWaG, LLC – Dba FINAO<sup>&reg;</sup> . All custom graphics, icons, logos and service names are registered trademarks, trademarks or service marks of JoMoWaG, LLC – Dba FINAO<sup>&reg;</sup>. All other trademarks or service marks are property of their respective owners. The use of any FINAO<sup>&reg;</sup> trademark or service mark without FINAO<sup>&reg;</sup>'s express written consent is strictly prohibited.
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
                      <span class="orange font-16px padding-10pixels">Conditions of Sale and Payment Terms.</span>
                    </p>

                    <p>To purchase any goods and/or services on our Site, you must (a) be at least eighteen (18) years of age or the applicable state age of majority. Prior to the purchase of any goods or services on our Site, you must provide us with a valid credit card number and associated payment information including all of the following: (i) your name as it appears on the card, (ii) your credit card number, (iii) the credit card type, (iv) the date of expiration and (v) any activation numbers or codes needed to charge your card. By submitting that information to us, you hereby agree that you authorize us to charge your card at our convenience but within thirty (30) days of credit card authorization.</p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Methods of Payment, Credit Card Terms and Taxes.</span>
                    </p>

                    <p>
                      All payments must be made by VISA, MasterCard, American Express, or Discover Card. Your card issuer agreement governs your use of your designated card, and you must refer to that agreement and not this Terms of Use to determine your rights and liabilities as a cardholder. YOU, AND NOT FINAO<sup>&reg;</sup>, ARE RESPONSIBLE FOR PAYING ANY UNAUTHORIZED AMOUNTS BILLED TO YOUR CREDIT CARD BY A THIRD PARTY. You agree to pay all fees and charges incurred in connection with your purchases (including any applicable taxes) at the rates in effect when the charges were incurred. Unless you notify FINAO<sup>&reg;</sup> of any discrepancies within sixty (60) days after they first appear on your credit card statement, you agree that they will be deemed accepted by you for all purposes. If FINAO<sup>&reg;</sup> does not receive payment from your credit card issuer or its agent, you agree to pay all amounts due upon demand by FINAO<sup>&reg;</sup> or its agents. You are responsible for paying any governmental taxes imposed on your purchases and shipping, including, but not limited to, sales, use or value-added taxes. FINAO<sup>&reg;</sup> shall automatically charge and withhold the applicable sales tax for orders to be delivered to addresses within Washington State and any other states or localities that it deems are required.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Improper/Fraudulent Chargeback fee: $25.00</span>
                    </p>

                    <p>
                      <strong>Explanation:</strong> Customers issuing chargeback(s) with their Credit Card's issuing Bank without proper cause will be billed any fees incurred by FINAO<sup>&reg;</sup> in disputing the chargeback as well as a $25.00 Chargeback fee. This is necessary to recover the charges we were billed by Visa/MasterCard/Discover Card when the no cause chargeback was issued. With this type of fraud/negligence on the rise, and little recourse given to the Merchant by the credit card issuers, we must protect ourselves from this new type of crime/negligence.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Order Acceptance Policy</span>
                    </p>

                    <p>
                      Your receipt of an electronic or other form of order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell. FINAO<sup>&reg;</sup> reserves the right at any time after receipt of your order to accept or decline your order for any reason. FINAO<sup>&reg;</sup> further reserves the right any time after receipt of your order, without prior notice to you, to supply less than the quantity you ordered of any item. Your order will be deemed accepted by FINAO<sup>&reg;</sup> upon our shipment of products or delivery of services that you have ordered. All orders placed over $1000.00 (U.S.) must obtain pre-approval with an acceptable method of payment, as established by our credit and fraud avoidance department. We may require additional verifications or information before accepting any order.
                    </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">Jurisdiction and Limited Liability</span>
                    </p>
                    <p>These Terms of Use are governed by the laws of the State of Washington.  By using or accessing the Site, you agree to submit personal jurisdiction to the State Courts in King County or the United States District Court for the Western District of Washington.  </p>

                    <p>
                      <span class="orange font-16px padding-10pixels">International Use</span>
                    </p>
                    <p>If you are a user of the site that is outside of the United States, you consent to your personal information and any information transferred through the use of the Site, to be transmitted and stored in the United States.  All Site users, even if located or domiciled outside of the United States, consent to these Terms of Use.  </p>

                  </div>
                    <p><button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-left orange-text post-finao-hdline">CHOOSE A FINAO</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-right orange-text post-finao-right-text"><a href="#">Submit</a></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="entered-finaos">
                            <ul>
                                <li class="selected">I will travel the world.</li>
                                <li>I will run every morning.</li>
                                <li>I will save money for college.</li>
                                <li>I will maintain a 3.0 GPA</li>
                                <li>I will do all my homework this year.</li>
                                <li>I will spend time with my family.</li>
                                <li>I will go to state in XC.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="popup-selected-finao">
                            <div class="row">
                                <div class="col-md-8" style="padding-left: 0;">
                                    <img alt="Profile-image" src="content/images/mitchell.jpg" class="img-border">
                                        <span class="updated-by">Mitchell Wehlot</span>
                                </div>
                                <div class="col-md-4 text-right text-fade">just now</div>
                            </div>
                            <div class="row uploaded-finao-image">
                                <img alt="Post-image" src="content/images/finao-sample-img.jpg" class="img-responsive">
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding-left: 0;">
                                    <p class="finao-title-text">
                                        <img alt="Icon-finao" src="<? echo $icon_path. "icon-finao.png";?>"/>
                                        I will travel the world                                      
                                    </p>
                                    <p class="finao-activity-text">I drove over to Spokane with my family last week and got to see a sweet firework show in the mountains!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container" style="box-shadow: none!important; border: 0;">
        <div class="row">
            <div class="col-md-5 col-xs-5"></div>
            <div class="col-md-3 col-xs-2 splash-logo">
                <a href="#">                    
                    <img class="img-responsive" alt="Logo" src="<? echo $icon_path."logo-new.jpg"; ?>">
                </a>
            </div>
            <div class="col-md-4 col-xs-5 font-14px" style="padding: 15px 0 0 0; text-align: right;">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="landing-video">
            <div class="videoWrapper" style="margin-top: 50px">
                <iframe width="437" height="288" src="https://www.youtube-nocookie.com/embed/vjtIo1_YQxY?rel=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="what-willdo-hdline">What will <span class="orange">you</span> do?</div>
    </div>
</div>
<div class="get-notified">KEEP ME POSTED</div>
<div class="container">
    <div class="row">
        <div class="starter-template3">
            <p class="lead3" style="font-size: 20px;"
                >Enter your email or phone number to be one of the first to know about the FINAO revolution.
            </p>
            <form class="form-signin" role="form" id="keepmeposted">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" id="splash_email" name="splash_email" value="">
                    <p align="center">
                        <img alt="Icon-or" src="<? echo $icon_path."or.jpg"; ?>"  class="img-responsive">
                    </p>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="splash_phone" name="splash_phone" value="">
                    </div>
                    <p>
                        <input type="checkbox" checked>
                        I Agree to the  <a href="#" data-toggle="modal" data-target=".bs-modal-lg">terms and conditions.</a>                       
                    </p>
                    <p class="submit-button">
                        <button class="btn-sub" type="button" data-toggle="modal" onclick="submit_splash();">SUBMIT</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="share-options">
            <div align="center">
                <a href="#" onClick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[summary]=Spread+the+word+about+FINAO!&amp;p[url]=http://finaonation.com', 



      'facebook-share-dialog', 



      'width=626,height=436'); 



    return false;">
                    <img alt="Share-on-fb" src="<? echo $image_path."share-on-facebook-splash.png"; ?>" class="img-responsive">
                </a>
            </div>
            <div align="center" style="margin-top: 20px">
                <a href="https://twitter.com/share?url=http://finaonation.com">
                    <img alt="Share-on-twitter" src="<? echo $image_path."share-on-twitter-splash.png"; ?>" class="img-responsive">
                </a>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>