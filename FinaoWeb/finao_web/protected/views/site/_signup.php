<form role="form" method="post" action="index.php?r=site/submitsignup">
    <div class="col-md-4"></div>
    <div class="col-md-3 splash-logo" style="background-color: rgb(255, 255, 255); height: auto; margin-top: 50px; display: block;">
        <div align="right" style="margin-right: -15px; margin-top: -15px">
            <a href="#">
                <img alt="" src="<? echo $icon_path."/icon-close.png"?>" class="img-responsive">                
            </a>
        </div>
        <div align="center">
            <a href="#">
                <img class="img-responsive" alt="Logo" src="content/images/logo-small.png">
            </a>
        </div>
        <br />
        <div class="row">
            <div class="col-md-1" style="padding: 20px"></div>
            <div class="col-md-4">
                <a href="#">
                    <img class="img-responsive" src="content/images/wallace.jpg">
                </a>
            </div>
            <div class="col-md-6">
                <div style="padding-top: 5px">
                    <input class="form-group col-md-10" placeholder="FIRST NAME" type="text" name="signup_details[first_name]" required />
                    <input class="form-group col-md-10" placeholder="LAST NAME" type="text"  name="signup_details[last_name]"/>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;">
            <div class="col-md-2"></div>
            <div style="padding-left: 20px; padding-right: 20px;">
                <input class="txtbox txtbox-error col-md-9" style="text-align: center" name="signup_details[email]" placeholder="EMAIL" type="text"/>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;">
            <div class="col-md-2"></div>
            <div style="padding-left: 20px; padding-right: 20px;">
                <input class="txtbox txtbox-error col-md-9" style="text-align: center" name="signup_details[password]" placeholder="PASSWORD" type="password"/>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;">
            <div class="col-md-2"></div>
            <div style="padding-left: 20px; padding-right: 20px;">
                <input class="txtbox txtbox-error col-md-9" style="text-align: center" name="signup_details[reenter_password]" placeholder="RE-ENTER PASSWORD" type="password"/>
            </div>
        </div>
        <div class="row" style="padding-top: 15px; padding-left: 45px; padding-right: 45px;" align="center">
            <img class="img-responsive col-md-12" src="content/images/captcha.jpg">
        </div>
        <div class="row" style="padding-top: 15px;" align="center">
            <div>
                <img class="img-responsive " src="content/images/or.jpg">
            </div>
        </div>
        <div class="row" style="padding-top: 15px;" align="center">
            <div>
                <img class="txtbox txtbox-error img-responsive " src="content/images/login-facebook.png">
            </div>
        </div>
        <div class="row font-12px" style="text-aline: center; padding: 20px;">
            <span>By clicking "Sign Up" you are agreeing to FINAO's Terms and Conditions.</span>
        </div>
        <div class="row font-25px" style="">
            <input type="submit" value="SIGN UP" style="background: #1286db; color: #FFFFFF; width:95%; padding-top: 10px; margin-top: 10px; padding-bottom: 10px; margin-left: -5px; margin-bottom: -5px; margin-right: -5px;"/>
        </div>
    </div>
</form>