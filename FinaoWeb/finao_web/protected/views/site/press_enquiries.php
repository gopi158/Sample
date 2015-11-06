<script>
    function submit_enquiry_form()
    {
        if($("#fname").val() == "")
        {
            show_alert("Please enter first name.");
            return false;
        }
        if($("#lname").val() == "")
        {
            show_alert("Please enter last name.");
            return false;
        }
        if($("#title").val() == "")
        {
            show_alert("Please enter title.");
            return false;
        }
        if($("#outletname").val() == "")
        {
            show_alert("Please enter media outlet name.");
            return false;
        }
        if($("#website").val() == "")
        {
            show_alert("Please enter website.");
            return false;
        }
        if($("#email").val() != "")
        {  
            var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!email_pattern.test($("#email").val()))
            {
                show_alert("Please enter valid email address.");               
                return false;
            }
        }
        if($("#phoneno").val() == "")
        {
            show_alert("Please enter your phone number.");
            return false;
        }
        if($("#topic").val() == "")
        {
            show_alert("Please enter topic.");
            return false;
        }
        
        if($("#deadline").val() == "")
        {
            show_alert("Please enter topic.");
            return false;
        }  
        
        $.get("index.php?r=site/submit_enquiry",$("#form_enquiry").serialize(),function(data){
            if(data == "invalid_captcha_code")
            {
                show_alert("Please enter captcha words correctly");
                Recaptcha.reload();
                return false; 
            } 
            show_alert(data);
            window.location.href = ""; 
        });
    }
</script>
<?
    include("header.php");
    include_once("header_second.php"); 
?>
<div class="container white-background">
    <div class="content-wrapper text-align-center container-fixed-height" style="margin-top: 40px">
        <div class="row col-lg-12 col-md-12 col-sm-12">
            <div class="row about-title left">PRESS INQUIRIES</div>
        </div>
        <div class="row col-lg-12 col-md-12 col-sm-12">
            <p class="about-text text-align-left font-20px">
              Media professionals seeking a press or public relations contact at FINAO, please submit your “Request For Information' below. Please do not submit a request which requires a response in less than 24 hours. If you need immediate assistance, please contact the PR Department at 206-858-9077 or at  <a href="mailto:media@finaonation.com">media@finaonation.com</a>.
            </p>
            <p class="about-text  text-align-left font-20px">
              If you are not a member of the news media, please contact our Customer Service Department at
              800-FINAO-11 (toll-free) or at  <a href="mailto:askus@finaonation.com">askus@finaonation.com</a>.
             
            </p>
          <p class="about-text  text-align-left font-20px">
            For media professionals seeking information, please fill out the below form fields as completely as possible so that we may thoroughly address your needs.

          </p>
          
            <div class="col-lg-3 col-md-3 col-sm-2"></div>
            <div class="col-lg-6 col-md-9 col-sm-9 col-sm-push-1 col-push-gn-3">
                <form class="form-group-inquiries" method="post" role="form" id="form_enquiry">
                    <div class="row">
                        <div class="col-lg-9 col-md-7 col-sm-9">
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="fname" id="fname" required placeholder="FIRST NAME">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="lname" id="lname" required placeholder="LAST NAME">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="title" id="title"  required placeholder="TITLE">
                            </div>
                            <div class="form-group">
                                    <input type="text" class="form-control placeholder" maxlength="50" name="outletname" id="outletname" required placeholder="MEDIA OUTLET NAME">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="website" id="website" required placeholder="WEBSITE">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="email" id="email" required placeholder="EMAIL">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="phoneno" id="phoneno" required placeholder="PHONE NUMBER">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="topic" id="topic" required placeholder="TOPIC OF REQUEST">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control placeholder" maxlength="50" name="deadline" id="deadline" required placeholder="DEADLINE">
                            </div>
                            <div class="row fjallaon_regular font-18px fade-text text-align-left margin-5px">
                                REQUEST FOR INTERVIEW :
                            </div>
                            <div class="col-lg-7 col-md-6 col-sm-7">
                                <div class="row">
                                    <p class=" oswald-font fade-text left  font-15px">
                                        <input class="margin-5px" type="checkbox" name="rfi_inperson" id="rfi_inperson"> IN PERSON
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="oswald-font fade-text left  font-15px">
                                        <input class="margin-5px" type="checkbox" name="rfi_phoneno" id="rfi_phoneno"> PHONE
                                    </p>
                                </div>
                                <div class="row">
                                    <p class=" oswald-font fade-text left  font-15px">
                                        <input class="margin-5px" type="checkbox" name="rfi_email" id="rfi_email"> E-MAIL
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-7">
                            <div class="form-group">
                                <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC"></script>
                                <noscript>
                                    <iframe src="https://www.google.com/recaptcha/api/noscript?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC" height="300" width="500" frameborder="0"></iframe>
                                    <br>
                                </noscript>
                            </div>
                            <div class="row  font-18px text-align-right ">
                                <button class="submit-button-inquiries no-border margin-5px" onclick="submit_enquiry_form(); return false;">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--media-->
<div id="popupBottom-media" style="margin-top: 20px; margin-left: 5px;" class="popover bottom" aria-hidden="true">
    <div class="arrow"></div>
    <div class="popover-content media-list">
        <ul>
            <li>
                <a href="in_the_news.html">IN THE NEWS</a>
            </li>
            <li>
                <a href="press_release.html">PRESS RELEASE</a>
            </li>
            <li>
                <a href="#">MEDIA LIBRARY</a>
            </li>
            <li>
                <a href="press_inquiries.html" class="current">PRESS INQUIRIES</a>
            </li>
        </ul>
    </div>
</div>
<!--media-->
<?
    include_once("alert_modal.php");
?>