    <div class="main-container">

    	<div class="finao-canvas">
		
        <div class="orange font-20px padding-10pixels"><span class="left">Contact Us</span> <span class="right"><a href="<?php echo Yii::app()->request->urlReferrer;?>"><img src="<?php echo $this->cdnurl; ?>/images/back.png" width="60" /></a></span></div>
            <div class="clear"></div>
        
        <div class="content-run-text" style="padding-bottom:25px;">Got a question? Have an awesome FINAO<sup>&reg;</sup> success story to share?  Just want to reach out to see if there are real people behind FINAO<sup>&reg;</sup>? Give us a shout or call us on phone <span class="orange">1-877-FINAO-11</span> or <span class="orange">1-877-346-2611</span>:</div>

		<div style="margin-bottom:10px;"><span id = "error" style="display:none;" class="red"> Please fill all the fields</span><span id = "error1" style="display:none;" class="red"> Please Enter Valid email adress</span></div>
		<div id="suc_msg" style="color:#009900; font-size:14px"></div>

        <div class="contact-form">

        	<fieldset>

            	<label>Name: <span class="red">*</span></label>

                <div><input id = "name" type="text" class="txtbox" style="width:80%" /></div>

            </fieldset>

            <fieldset>

            	<label>Email Address: <span class="red">*</span></label>

                <div><input id = "email" type="text" class="txtbox" style="width:80%" /></div>

            </fieldset>

            <fieldset>

            	<label>Telephone Number: <span class="red">*</span></label>

                <div><input id ="phone" type="text" class="txtbox" style="width:80%" /></div>

            </fieldset>

            <fieldset>

            	<label>Comment: <span class="red">*</span></label>

                <div><textarea id = "comment" class="add-story" style="resize:none; width:80%; height:100px;"></textarea></div>

            </fieldset>

            <fieldset>

            	<label>&nbsp;</label>

                <div><input type="button" class="orange-button" value="Submit" onclick="submitvalues()" /> <input type="button" class="orange-button" onclick = "clearfields()" value="Cancel" /></div>

            </fieldset>

        </div>

        </div>

    </div>

	<script type="text/javascript">

	

	function submitvalues()

	{

		var name = document.getElementById('name').value;

		var email = document.getElementById('email').value;

		var phone = document.getElementById('phone').value;

		var comment = document.getElementById('comment').value;

		

		if(name == "" || email == "" || phone == "" || comment == "")

		{

			$("#error").show();

			$("#error1").hide();

			return false;

		}else{

			var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

			if(email.match(emailExp))

			{

			//alert("correct");

			var url='<?php echo Yii::app()->createUrl("/profile/contactus"); ?>';

					$.post(url, { name:name, email:email, phone:phone, comment:comment },

						function(data){

						if(data = "success")

						{
							$('#suc_msg').html('Thank you for contacting us. We will get back to you soon.');
						//	var url = "<?php //echo Yii::app()->createUrl('/profile/contactus'); ?>";

   							//window.location = url;
							document.getElementById('name').value = "";

							document.getElementById('email').value = "";
					
							document.getElementById('phone').value = "";
					
							document.getElementById('comment').value = "";

						}

						});

			}else{

			$("#error").hide();

			$("#error1").show();

			}

		}

		

	}

	function clearfields()

	{

		document.getElementById('name').value = "";

		document.getElementById('email').value = "";

		document.getElementById('phone').value = "";

		document.getElementById('comment').value = "";

		

	}

	</script>