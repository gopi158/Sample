<script>
  function submit_contactus_form()
  {
  if($("#name").val() == "")
  {
  show_alert("Enter your name.");
  return false;
  }
  if($("#email").val() == "")
  {
  show_alert("Enter email address.");
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
  show_alert("Enter your phone number.");
  return false;
  }
  if($("#message").val() == "")
  {
  show_alert("Enter message.");
  return false;
  }

  $.get("index.php?r=site/submit_contactus",$("#form_contactus").serialize(),function(data){
  if (data == "invalid_captcha_code")
  {
  show_alert("Invalid captcha code.");
  }
  else
  {
  show_alert(data);
  }
  $("#name").val("");
  $("#email").val("");
  $("#phoneno").val("");
  $("#message").val("");
  });
  }
</script>
<?
    include ("header.php");
    include_once("header_second.php");
?>





<div class="container white-background">
  <div class="content-wrapper  container-fixed-height" style="margin-top: 40px">
    <div class="row col-lg-12 col-md-12 col-sm-12">
      <div class="row about-title left">CONTACT US</div>
    </div>
    <div class="row col-lg-12 col-md-12 col-sm-12">
      <p class="about-text  font-20px">Have a question or a comment?</p>
      <p class="about-text  font-20px">Talk with us! We're available by phone or email to answer any questions, and to hear your feedback. You may also reach us by completing and submitting the below form. Thanks in advance for sharing.</p>
      <div class="margin-bottom-about-p">
        <p class=" font-20px">          <i>EMAIL</i> :   <a href="mailto:askus@finaonation.com">askus@finaonation.com</a>.        </p>
        <p class=" font-20px"> <i>Phone</i> :     800-FINAO-11 (1-800-34626-11)       </p>
        <p class=" font-20px">Corporate Headquarters:</p>
        <p class=" font-20px">FINAO</p>
        <p class=" font-20px">13024 Beverly Park Road, Suite 201</p>
        <p class=" font-20px">Mukilteo, Washington 98275</p>
      </div>
      <div class="col-lg-3 col-md-2 col-sm-2"></div>
      <div class="col-lg-6 col-md-9 col-sm-9 col-sm-push-1 col-push-gn-3 margin-top-20px">
        <form class="form-group-inquiries" role="form" id="form_contactus" method="post">
          <div class="row">
            <div class="col-lg-9 col-md-7 col-sm-9">
              <div class="form-group">
                <input type="text"  id="name" name="name" class="form-control placeholder" maxlength="50" required="" placeholder="NAME"/>
                            </div>
              <div class="form-group">
                <input type="text" id="email" name="email" class="form-control placeholder" maxlength="50" required="" placeholder="EMAIL"/>
                            </div>
              <div class="form-group">
                <input type="text" id="phoneno" name="phoneno" class="form-control placeholder" maxlength="25" required="" placeholder="PHONE"/>
                            </div>
              <div class="form-group">
                <textarea class="form-control text-align-center placeholder" id="message" name="message" maxlength="255" rows="5" required="" placeholder="MESSAGE"></textarea>
              </div>
              <div class="row fjallaon_regular font-18px fade-text text-align-left margin-5px">
                REQUEST FOR INTERVIEW :
              </div>
              <div class="form-group text-align-center">
                <div class="form-group" align="center">
                  <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC"></script>
                  <noscript>
                    <iframe src="https://www.google.com/recaptcha/api/noscript?k=6Ld2DfASAAAAACKEaXH9KR_aR9HsYGLqhk39qsCC" height="300" width="500" frameborder="0"></iframe>
                    <br/>
                                    </noscript>
                </div>
              </div>
              <div class="row  font-18px text-align-right ">
                <button class="submit-button-inquiries no-border margin-5px" onclick="submit_contactus_form(); return false;">SUBMIT</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?
    include_once("alert_modal.php");
?> 
 