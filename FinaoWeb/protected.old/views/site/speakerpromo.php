<script type="text/javascript">
$(document).ready(function(){

    $("#registered1").fancybox({
        'scrolling'		: 'no',
        'titleShow'		: false,
        'hideOnOverlayClick' : false,
        'autoScale'           : true,
        'fixed': false,
        'resizeOnWindowResize' : false
    });

    <?php if(isset($_REQUEST['tile'])){ ?>
    $("#registered1").trigger('click');

    <?php }?>

    /***************************/
//Validation starts Here
//ref:				
    /***************************/


    //global vars

    var name = $("#name");
    var nameInfo = $("#nameInfo");

    var email = $("#uemail");
    var emailInfo = $("#emailInfo");


    var message = $("#finaomsg");
    var mobile = '';
    //On blur
    name.blur(validateName);
    email.blur(checkuseravailable);
    email.blur(validateEmail);

    //On key press
    name.keyup(validateName);

    message.keyup(validateMessage);
    //On Submitting

    $('#easysubmit').click(function()
    {
        if(validateName() & validateEmail() & validateMessage())
        {
            //alert("sucess");

            var name = $('#name').val();
            var mobile = '';
            var email = $('#uemail').val();
            var tilename = $('#tilename').val();
            var password = $('#password').val();
            //alert(email);
            var finaomsg = $('#finaomsg').val();
            var url= "<?php echo Yii::app()->createUrl('site/Easylogin'); ?>";
            $.post(url, {name:name,email:email,mobile:mobile,finaomsg:finaomsg,tilename:tilename,password:password},
                function(data) {
					
					

                    //alert(data);
                    if(data == 0)
                    {
                        $('#error_msgt').text('Enter fields');
                        //alert("Enter fields");
                    }else if(data == 1)
                    {
                        $('#error_msgt').text('You are already subscribed or your account may not be activated');
                    }
                    else if (data == 3)
                    {
                        $('#error_msgt').text('welcome back, please enter password');
                    }
                    else
                    {
                        var split = data.split('-');
                        var value = split[0];

                        if(value == 2 )
                        {
                            conf = 'false';
                            var titlename = split[1];
                        }else
                        {
                            conf = 'true';
                            var titlename = split[2];
                        }
                       if(titlename == 77)
					   {
						  
						   var rd ='<?php echo Yii::app()->createUrl("profile/profilelanding/tileid/##data"); ?>';
						   
						   rd = rd.replace('##data',titlename);
						    
						  
					   }
					   else
					   {
var rd ='<?php echo Yii::app()->createUrl("/finao/MotivationMesg/tile/##data1/confirm/##data2"); ?>';
                        rd = rd.replace('##data1',titlename);
                        rd = rd.replace('##data2',conf);						    
					   }
					  
                        window.location=rd;
                    }

                
					
					});

        }

        else
        {
            //alert('failed');
            return false;
        }

    });

    //validation functions
    function validateEmail(){
        //testing regular expression
        var a = $("#uemail").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        //if it's valid email
        if(filter.test(a)){
            email.removeClass("txtbox-error");
            emailInfo.text("Valid E-mail please, you will need it to log in!");
            emailInfo.removeClass("txtbox-error");
            return true;
        }
        //if it's NOT valid
        else{
            email.addClass("txtbox-error");
            email.attr("placeholder", "Type a valid e-mail please");
            emailInfo.text("Stop cowboy! Type a valid e-mail please :P");
            emailInfo.addClass("txtbox-error");
            return false;
        }
    }
    function validateName(){
        //if it's NOT valid
        if(name.val().length < 4){
            name.addClass("txtbox-error");
            name.attr("placeholder", "Name min of 3 Characters Please");
            nameInfo.text("We want names with more than 3 letters!");
            nameInfo.addClass("txtbox-error");
            return false;
        }
        //if it's valid
        else{
            name.removeClass("txtbox-error");
            nameInfo.text("What's your name?");
            nameInfo.removeClass("txtbox-error");
            return true;
        }
    }

    function validateMessage(){
        //it's NOT valid
        if(message.val().length < 6){
            message.addClass("multi-line-text-error");
            message.attr("placeholder", "FINAO Min of 6 Characters Please");
            return false;
        }
        //it's valid
        else{
            message.removeClass("multi-line-text-error");
            return true;
        }
    }

    function checkuseravailable(){
        var email = $("#uemail").val();
        var url= "<?php echo Yii::app()->createUrl('site/ValidEmail'); ?>";
        $.post(url, {email:email},
            function(data) {
                if(data === 'Already Activated')
                {
                    $('#error_msgt').html('welcome back, please enter password');
                    $('#showpasswordt').show();
                    $('#password').focus();

                    return true;
                }else
                {
                    $('#showpasswordt').hide();
                    return false;
                }

            });


        return false;
    }






});
function change_va(event)
{
    var url = '<?php echo Yii::app()->createUrl("finao/badWords"); ?>';
    if(event.keyCode == 32)
    {
        var valu=$('#finaomsg').val();
        //alert(valu);
        var mySplitResult = valu.split(" ");
        //alert(mySplitResult[mySplitResult.length-1]);
        var lastWord =  mySplitResult[mySplitResult.length-2];
        //		alert(valu.length);
        //		alert(valu.length-lastWord.length);

        $.post(url, { word : lastWord}, function (data){if(data=='yes'){
            if(valu.length-lastWord.length<=1){$('#finaomsg').val('');}
            else {// alert('f'); //var ss=valu.slice(0,lastword.length);
                $('#finaomsg').val($('#finaomsg').val().slice(0,valu.length-lastWord.length-2)); }
            $('#error_msg').html('Bad word');
        }});
        $('#error_msg').html('');
    }
}

</script>

<?php if(isset($_REQUEST['tile'])){ ?>
    <a id="registered1" href="#registeredcontent1" ></a>


    <div  style="display:none;">

        <div id = "registeredcontent1">

            <div class="signin-popup" id="login_form3" style="text-align:center;">
                <div class="orange font-20px padding-10pixels">What's Your FINAO?</div>

                <span id="error_msgt" style="color:red; text-align:left; float:left; width:100%; padding-bottom:10px;"></span>

                <?php
                foreach($tileids as $newtile)
                {
                    $tileid = $newtile["lookup_id"];
                }
                $tile  =  $newtile["lookup_name"];
                //echo $tile;
                $pieces = explode(" ", $tile);
                $tileimage = strtolower($pieces[0].$pieces[1]);
                //echo $tileimage;
                ?>
                <div class="popup-finao-container">
                    <div class="popup-finao-container-left"><img width="90" src="<?php echo $this->cdnurl; ?>/images/tiles/<?php echo $tileimage ?>.jpg"></div>
                    <div class="popup-finao-container-right">
                        <p><textarea class="multi-line-text" id="finaomsg" placeholder="Enter your FINAO" style="height:56px;" maxlength="140" onkeyup="change_va(event)"></textarea></p>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="padding-10pixels"><input placeholder="Name" id="name" type="text" style="width:95%;" class="txtbox"></div>
                <div class="padding-10pixels"><input placeholder="Email" id="uemail"  type="text" style="width:95%;" class="txtbox" onblur="checkuseravailable();"></div>

                <div style="display:none;" id="showpasswordt" class="padding-10pixels">
                    <input placeholder="********" id="password" type="password" style="width:95%;" class="txtbox"></div>


                <div class="font-12px padding-10pixels" style="color:#343434; text-align:left; line-height:20px;">We respect your privacy. You control what information is shared. Click for our full <a  target="_blank" href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>" class="orange-link1 font-12px">Privacy Statement</a> and <a target="_blank" href="<?php echo Yii::app()->createUrl('profile/terms'); ?>" class="orange-link1 font-12px">Terms and Conditions</a></div>

                <div style="padding-top:10px;" class="padding-10pixels">
                    <input type="hidden" id="tilename" value="<?php echo $_REQUEST['tile']; ?>" />
                    <input type="button" id="easysubmit" value="Submit" class="orange-button">
                </div>
            </div>




        </div>

    </div>
    
<?php }else{?>
    <?php  $this->widget('EasyRegister',array('type'=>$type,'pid'=>$pid));
    ?>

<?php }?>